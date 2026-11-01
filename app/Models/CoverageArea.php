<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\RegionService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CoverageArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'district',
        'slug',
        'postal_code',
        'starting_price',
        'meta_title',
        'meta_description',
        'geo_keywords',
        'latitude',
        'longitude',
        'content',
        'hero_image',
        'posko_name',
        'posko_address',
        'posko_coverage_radius',
        'cta_headline',
        'cta_button_text',
        'cta_whatsapp_text',
        'faqs',
        'advantages',
        'service_categories',
        'comparison_data',
        'supporting_tags',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starting_price' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
            'faqs' => 'array',
            'advantages' => 'array',
            'service_categories' => 'array',
            'comparison_data' => 'array',
            'supporting_tags' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get resolved starting price with fallback.
     */
    public function getResolvedPriceAttribute(): int
    {
        return (int) ($this->starting_price ?: 400000);
    }

    /**
     * Get resolved latitude and longitude coordinates.
     * Uses explicit database coordinates if available, otherwise falls back to official centroid.
     *
     * @return array{lat: float, lng: float}
     */
    public function getResolvedCoordinatesAttribute(): array
    {
        if (! empty($this->latitude) && ! empty($this->longitude)) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ];
        }

        $cityData = RegionService::findCity($this->city);
        $citySlug = $cityData['slug'] ?? Str::slug($this->city);

        return RegionService::centroid($citySlug, $this->district);
    }

    /**
     * Get official ISO 3166-2 Indonesian subdivision code for this area.
     */
    public function getIsoRegionAttribute(): string
    {
        $cityData = RegionService::findCity($this->city);
        $provinceSlug = $cityData['province_slug'] ?? null;

        return RegionService::isoRegion($provinceSlug);
    }

    /**
     * Get resolved FAQs either from custom CMS entries or dynamic local templates.
     *
     * @return array<int, array{question: string, answer: string}>
     */
    public function getResolvedFaqsAttribute(): array
    {
        if (is_array($this->faqs) && count($this->faqs) > 0) {
            $filtered = array_values(array_filter($this->faqs, function ($item) {
                return ! empty($item['question']) && ! empty($item['answer']);
            }));

            if (! empty($filtered)) {
                return $filtered;
            }
        }

        $district = $this->district ?: 'wilayah Anda';
        $city = $this->city ?: 'sekitarnya';
        $priceFormatted = 'Rp ' . number_format($this->resolved_price, 0, ',', '.');

        return [
            [
                'question' => "Berapa lama estimasi teknisi Drainusantara tiba di area {$district}, {$city}?",
                'answer' => "Armada siaga teknisi kami di posko {$city} bergerak cepat, teknisi menuju ke lokasi anda secepatnya setelah konfirmasi pemesanan, menyesuaikan rute lalu lintas terdekat.",
            ],
            [
                'question' => "Apakah pengerjaan saluran mampet di {$district} membongkar lantai keramik?",
                'answer' => "Sama sekali tidak (100% tanpa bongkar ubin/keramik). Kami menggunakan mesin spiral baja rotary berdaya puntir tinggi yang meliuk mengikuti alur pipa PVC hingga titik sumbatan terdalam tanpa merusak struktur lantai.",
            ],
            [
                'question' => "Jenis saluran apa saja yang dilayani di {$district}?",
                'answer' => "Kami menangani pelancaran wastafel sink cuci piring, kloset toilet duduk/jongkok, floor drain kamar mandi, bak kontrol rumah, talang pipa atap, hingga pembersihan rutin grease trap restoran & ruko di seluruh area {$district}.",
            ],
            [
                'question' => "Berapa biaya jasa pelancaran pipa mampet di {$district}?",
                'answer' => "Biaya jasa penanganan mulai dari {$priceFormatted} dengan skema No Cure No Pay (jika saluran gagal mengalir lancar, Anda bebas dari biaya jasa pengerjaan).",
            ],
            [
                'question' => "Apakah ada garansi resmi untuk pengerjaan di {$district}?",
                'answer' => "Ya, setiap pengerjaan yang dinyatakan tuntas dilindungi nota digital garansi resmi 30 hari kalender. Jika terjadi sumbatan ulang di titik yang sama dalam masa garansi, tim kami melancarkan ulang tanpa biaya tambahan.",
            ],
        ];
    }

    /**
     * Get resolved advantages (Keunggulan) with local area context.
     *
     * @return array<int, array{title: string, description: string, icon?: string}>
     */
    public function getResolvedAdvantagesAttribute(): array
    {
        if (is_array($this->advantages) && count($this->advantages) > 0) {
            $filtered = array_values(array_filter($this->advantages, fn ($item) => ! empty($item['title'])));
            if (! empty($filtered)) {
                return $filtered;
            }
        }

        $district = $this->district ?: $this->city;

        return [
            [
                'title' => "Teknisi Siaga di Area {$district}",
                'description' => "Posko armada terdekat bergerak cepat, teknisi menuju ke lokasi anda secepatnya.",
                'icon' => 'truck',
            ],
            [
                'title' => 'Rotary Spiral Tempered Tanpa Kimia',
                'description' => 'Meliuk fleksibel membersihkan lemak dan endapan tanpa risiko pipa PVC meleleh atau keramik terbongkar.',
                'icon' => 'tool',
            ],
            [
                'title' => 'Garansi Resmi 30 Hari Kalender',
                'description' => 'Dilindungi nota garansi digital. Apabila terjadi kendala berulang di titik yang sama, kami perbaiki gratis.',
                'icon' => 'shield',
            ],
            [
                'title' => 'Transparansi Biaya No Cure No Pay',
                'description' => 'Kepastian biaya sejak awal. Bebas biaya jasa jika saluran air gagal kami lancarkan secara tuntas.',
                'icon' => 'currency',
            ],
        ];
    }

    /**
     * Get resolved comparison matrix between conventional plumbers vs Drainusantara.
     *
     * @return array<int, array{aspect: string, tukang: string, drainusantara: string}>
     */
    public function getResolvedComparisonAttribute(): array
    {
        if (is_array($this->comparison_data) && count($this->comparison_data) > 0) {
            $filtered = array_values(array_filter($this->comparison_data, fn ($item) => ! empty($item['aspect'])));
            if (! empty($filtered)) {
                return $filtered;
            }
        }

        return [
            [
                'aspect' => 'Metode Pengerjaan',
                'tukang' => 'Sering kali menyarankan bongkar keramik lantai atau menuangkan cairan soda api keras yang membuat pipa PVC getas & bocor.',
                'drainusantara' => '100% mekanis menggunakan kabel spiral baja rotary Ridgid yang meliuk fleksibel tanpa merusak ubin lantai hunian.',
            ],
            [
                'aspect' => 'Peralatan & Teknologi',
                'tukang' => 'Kawat manual seadanya atau bambu yang rawan patah di dalam jalur pembuangan dan memperparah sumbatan.',
                'drainusantara' => 'Mesin Spiral Elektrik berdaya puntir tinggi plus inspeksi kamera CCTV 30M untuk diagnosa presisi.',
            ],
            [
                'aspect' => 'Jaminan & Garansi',
                'tukang' => 'Tanpa nota atau garansi tertulis. Jika mampet kembali keesokan harinya, Anda harus membayar jasa dari awal.',
                'drainusantara' => 'Garansi resmi 30 hari kalender dengan nota digital. Ada kendala berulang di titik sama, perbaikan tuntas gratis.',
            ],
            [
                'aspect' => 'Keamanan Pipa PVC',
                'tukang' => 'Zat kimia korosif dapat melunakkan sambungan fitting lem pipa di bawah cor semen dan memicu kebocoran tersembunyi.',
                'drainusantara' => 'Sangat aman untuk sambungan PVC standar perumahan, ruko, restoran, hingga pipa talang vertikal gedung.',
            ],
            [
                'aspect' => 'Kepastian Biaya',
                'tukang' => 'Biaya spekulasi borongan yang dapat membengkak di tengah proses pengerjaan.',
                'drainusantara' => 'Tarif jelas sejak awal dengan komitmen No Cure No Pay (tidak lancar, bebas dari tagihan biaya jasa pengerjaan).',
            ],
        ];
    }

    /**
     * Get resolved armada pool / posko information.
     *
     * @return array{name: string, address: string, radius: string}
     */
    public function getResolvedPoskoAttribute(): array
    {
        $district = $this->district ?: $this->city;
        $city = $this->city;

        return [
            'name' => $this->posko_name ?: "Posko Siaga Drainusantara Unit {$district}",
            'address' => $this->posko_address ?: "Pusat Operasional Armada Siaga Drainusantara Area {$city} (Siaga menjangkau seluruh kelurahan di {$district} dan sekitarnya).",
            'radius' => $this->posko_coverage_radius ?: 'Radius Jangkauan 15-20 KM • Teknisi Menuju ke Lokasi Anda Secepatnya',
        ];
    }

    /**
     * Get resolved service sectors/categories (Rumahan, Restoran, Gedung, Pabrik, Ruko).
     *
     * @return array<int, array{key: string, title: string, scope: string, problem: string, solution: string}>
     */
    public function getResolvedServiceCategoriesAttribute(): array
    {
        if (is_array($this->service_categories) && count($this->service_categories) > 0) {
            $filtered = array_values(array_filter($this->service_categories, fn ($item) => ! empty($item['title'])));
            if (! empty($filtered)) {
                return $filtered;
            }
        }

        return [
            [
                'key' => 'rumahan',
                'title' => 'Rumahan / Residensial',
                'scope' => 'Wastafel cuci piring, kloset duduk/jongkok, floor drain kamar mandi hunian.',
                'problem' => 'Endapan lemak makanan rumah tangga, gumpalan rambut rontok, dan tisu/pembalut.',
                'solution' => 'Pembersihan pipa spiral 16mm tanpa bongkar ubin keramik hunian.',
            ],
            [
                'key' => 'restoran',
                'title' => 'Restoran & FnB / Kafe',
                'scope' => 'Grease trap, sink cucian dapur kotor, saluran buangan utama dapur resto.',
                'problem' => 'Kerak minyak jenuh membeku (grease solid) yang menyempitkan diameter pipa hingga 90%.',
                'solution' => 'Penghancuran mekanis kerak lemak beku hingga pipa kembali ke diameter optimal.',
            ],
            [
                'key' => 'gedung',
                'title' => 'Gedung & Perkantoran',
                'scope' => 'Saluran toilet perkantoran multi-lantai, pipa vertikal (stack pipe), talang pembuangan hujan.',
                'problem' => 'Akumulasi kotoran pada jalur vertikal dan junction horizontal antar lantai gedung.',
                'solution' => 'Rooting jangkauan panjang spiral baja tempered dengan safety APD steril standar industri.',
            ],
            [
                'key' => 'pabrik',
                'title' => 'Pabrik & Pergudangan',
                'scope' => 'Saluran limbah non-B3, saluran drainase got tertutup, bak kontrol luar kawasan.',
                'problem' => 'Sedimen endapan lumpur padat, pasir, sisa serat material, dan lumut saluran.',
                'solution' => 'Kombinasi spiral diameter besar dan pembilasan tekanan terarah.',
            ],
            [
                'key' => 'ruko',
                'title' => 'Ruko & Komersial',
                'scope' => 'Toilet lantai 1-3 ruko, bak kontrol pembuangan ke drainase kota.',
                'problem' => 'Sumbatan komposit dari berbagai aktivitas harian ruko komersial.',
                'solution' => 'Pelancaran cepat tanpa mengganggu aktivitas operasional bisnis pelanggan Anda.',
            ],
        ];
    }

    /**
     * Get resolved CTA headline and buttons.
     *
     * @return array{headline: string, button_text: string, whatsapp_text: string}
     */
    public function getResolvedCtaAttribute(): array
    {
        $district = $this->district ?: $this->city;
        $city = $this->city;

        $defaultHeadline = "Saluran Air di {$district} Tersumbat Hari Ini?";
        $defaultButton = "Panggil Teknisi Sekarang";
        $defaultWa = "Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di area {$district}, {$city}. Mohon info biaya dan estimasi kedatangan teknisi ke lokasi saya.";

        return [
            'headline' => $this->cta_headline ?: $defaultHeadline,
            'button_text' => $this->cta_button_text ?: $defaultButton,
            'whatsapp_text' => $this->cta_whatsapp_text ?: $defaultWa,
        ];
    }

    public function publicUrl(): ?string
    {
        if (! $this->is_active) {
            return null;
        }

        $city = collect(RegionService::all())
            ->flatMap(fn (array $province) => $province['cities'])
            ->first(fn (array $city) => $city['name'] === $this->city);

        if (! $city || ! in_array($this->district, $city['districts'], true)) {
            return null;
        }

        return route('area.detail', [
            'city' => $city['slug'],
            'district' => Str::slug($this->district),
        ]);
    }

    /**
     * Synchronize missing coverage areas from RegionService master hierarchy into the database.
     *
     * @return array{created: int, existing: int, total: int}
     */
    public static function syncFromMaster(): array
    {
        $created = 0;
        $existing = 0;

        $provinces = RegionService::all();

        foreach ($provinces as $province) {
            foreach ($province['cities'] as $city) {
                $cityName = $city['name'];

                foreach ($city['districts'] as $district) {
                    $slug = Str::slug("{$cityName} {$district}");

                    $area = self::where(function ($query) use ($cityName, $district, $slug) {
                        $query->where(function ($q) use ($cityName, $district) {
                            $q->where('city', $cityName)->where('district', $district);
                        })->orWhere('slug', $slug);
                    })->first();

                    if ($area) {
                        $existing++;
                        continue;
                    }

                    self::create([
                        'city' => $cityName,
                        'district' => $district,
                        'slug' => $slug,
                        'meta_title' => "Jasa Saluran Mampet di {$district}, {$cityName} - Drainusantara Bergaransi",
                        'meta_description' => "Jasa pipa mampet wastafel, toilet, & talang air di {$district}, {$cityName}. Tanpa bongkar keramik pakai spiral baja, respons chat via WhatsApp & garansi 30 hari.",
                        'content' => "Layanan penanganan saluran pipa mampet berstandar profesional di area {$district}, {$cityName} dan sekitarnya. Teknisi siaga berbekal mesin rotary spiral elektrik tanpa bongkar ubin.",
                        'is_active' => true,
                    ]);

                    $created++;
                }
            }
        }

        return [
            'created' => $created,
            'existing' => $existing,
            'total' => $created + $existing,
        ];
    }
}
