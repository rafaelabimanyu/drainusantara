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
        'type',
        'province_name',
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
        'presence_image',
        'presence_description',
        'gallery_ids',
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
            'type' => 'string',
            'starting_price' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
            'presence_description' => 'string',
            'gallery_ids' => 'array',
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

    public function isProvince(): bool
    {
        return $this->type === 'province' || $this->district === '[PROVINSI]';
    }

    public function isCity(): bool
    {
        return $this->type === 'city' || $this->district === '[KOTA]';
    }

    public function isDistrict(): bool
    {
        return ! $this->isProvince() && ! $this->isCity();
    }

    public function getCleanDistrict(): ?string
    {
        $d = trim((string) $this->district);
        if ($d === '' || $d === '[KOTA]' || $d === '[PROVINSI]' || $d === '{kota}' || $d === '{provinsi}' || $d === '{kecamatan}' || $d === '[KECAMATAN]') {
            return null;
        }

        return $d;
    }

    /**
     * Get resolved hero image URL via AreaImageResolver (CMS Upload -> Local Asset -> Fallback).
     */
    public function getResolvedHeroImageAttribute(): string
    {
        return \App\Services\AreaImageResolver::resolveUrl($this);
    }

    /**
     * Get resolved presence image URL via AreaImageResolver.
     */
    public function getResolvedPresenceImageAttribute(): string
    {
        return \App\Services\AreaImageResolver::resolvePresenceUrl($this);
    }

    /**
     * Get image resolution source ('cms_custom', 'district_asset', 'city_asset', 'province_asset', 'default_fleet').
     */
    public function getImageSourceAttribute(): string
    {
        return \App\Services\AreaImageResolver::resolve($this)['source'];
    }

    /**
     * Sync resolved asset images into the database coverage_areas table.
     *
     * @param bool $overwriteCustom Whether to overwrite existing custom uploads
     * @return array{updated: int, skipped: int, total: int}
     */
    public static function syncAreaImages(bool $overwriteCustom = false): array
    {
        $areas = self::orderBy('id')->get();
        $updated = 0;
        $skipped = 0;

        foreach ($areas as $area) {
            $hasExistingCustom = ! empty($area->hero_image);

            if ($hasExistingCustom && ! $overwriteCustom) {
                $skipped++;
                continue;
            }

            $resolved = \App\Services\AreaImageResolver::resolve($area);
            $newPath = $resolved['path'];

            if (in_array($resolved['source'], ['district_asset', 'city_asset', 'province_asset'], true)) {
                $area->hero_image = $newPath;

                if (empty($area->presence_image)) {
                    $area->presence_image = $newPath;
                }

                $area->save();
                $updated++;
            } else {
                $skipped++;
            }
        }

        return [
            'updated' => $updated,
            'skipped' => $skipped,
            'total' => $areas->count(),
        ];
    }

    /**
     * Get resolved galleries (hasil pengerjaan) chosen via CMS, or empty collection if none selected.
     *
     * @return \Illuminate\Support\Collection<int, \App\Models\Gallery>
     */
    public function getResolvedGalleries(?int $limit = 3): \Illuminate\Support\Collection
    {
        if (! empty($this->gallery_ids) && is_array($this->gallery_ids)) {
            $ids = array_values(array_filter(array_map('intval', $this->gallery_ids)));
            if (! empty($ids)) {
                $selected = Gallery::where('is_active', true)
                    ->with('service')
                    ->whereIn('id', $ids)
                    ->get();

                if ($selected->isNotEmpty()) {
                    $idOrder = array_flip($ids);
                    $ordered = $selected->sortBy(fn ($item) => $idOrder[$item->id] ?? 999)->values();
                    return $limit !== null ? $ordered->take($limit) : $ordered;
                }
            }
        }

        return collect();
    }

    /**
     * Get resolved presence description with rich geographical and plumbing differentiation.
     */
    public function getResolvedPresenceDescriptionAttribute(): string
    {
        if (! empty($this->presence_description)) {
            return $this->sanitizeText($this->presence_description);
        }

        $cityData = RegionService::findCity($this->city);
        $citySlug = $cityData['slug'] ?? Str::slug($this->city);
        $district = ($this->district && $this->district !== '[KOTA]' && $this->district !== '[PROVINSI]') ? $this->district : null;
        $profile = \App\Services\RegionalTaxonomy::getProfile($citySlug, $district, $this->city);

        return $this->sanitizeText($profile['presence_prose']);
    }

    /**
     * Get regional taxonomy profile for local SEO de-thinning.
     *
     * @return array{
     *     zone: string,
     *     zone_name: string,
     *     characteristics: string,
     *     challenges: string,
     *     building_focus: string,
     *     technical_solution: string,
     *     prominent_areas: array<int, string>,
     *     presence_prose: string,
     *     advantages_focus: string,
     *     local_faqs: array<int, array{question: string, answer: string}>
     * }
     */
    public function getResolvedRegionalProfileAttribute(): array
    {
        $cityData = RegionService::findCity($this->city);
        $citySlug = $cityData['slug'] ?? Str::slug($this->city);
        $district = ($this->district && $this->district !== '[KOTA]' && $this->district !== '[PROVINSI]') ? $this->district : null;

        $profile = \App\Services\RegionalTaxonomy::getProfile($citySlug, $district, $this->city);

        return \App\Services\RegionalTaxonomy::sanitizeRecursive($profile, $this->city, $district);
    }

    /**
     * Get deep localized analysis cards and service standards for this coverage area.
     *
     * @return array{
     *     sub_zone: string,
     *     landmarks: array<int, string>,
     *     analysis_cards: array<int, array{title: string, badge: string, icon: string, description: string, detail: string}>,
     *     service_specs: array<int, array{label: string, value: string, badge?: string}>
     * }
     */
    public function getResolvedDistrictAnalysisAttribute(): array
    {
        $cityData = RegionService::findCity($this->city);
        $citySlug = $cityData['slug'] ?? Str::slug($this->city);
        $district = ($this->district && $this->district !== '[KOTA]' && $this->district !== '[PROVINSI]') ? $this->district : null;

        $analysis = \App\Services\RegionalTaxonomy::getDistrictAnalysis($citySlug, $district, $this->city);

        return \App\Services\RegionalTaxonomy::sanitizeRecursive($analysis, $this->city, $district);
    }

    /**
     * Sanitize text by removing placeholder strings.
     */
    public function sanitizeText(string $text): string
    {
        $district = ($this->district && $this->district !== '[KOTA]' && $this->district !== '[PROVINSI]') ? $this->district : '';
        $city = $this->city ?: '';
        $prov = $this->province_name ?: $city;

        $replacements = [
            '[KOTA]' => $city,
            '[kota]' => $city,
            '{kota}' => $city,
            '[KECAMATAN]' => $district ?: $city,
            '[kecamatan]' => $district ?: $city,
            '{kecamatan}' => $district ?: $city,
            '[PROVINSI]' => $prov,
            '[provinsi]' => $prov,
            '{provinsi}' => $prov,
            'Pelancaran Pelancaran' => 'Pelancaran',
            'pelancaran pelancaran' => 'pelancaran',
            'Studi Kasus: Pelancaran Pelancaran' => 'Studi Kasus: Pelancaran',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $text);
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
                return array_map(function ($faq) {
                    return [
                        'question' => $this->sanitizeText($faq['question']),
                        'answer' => $this->sanitizeText($faq['answer']),
                    ];
                }, $filtered);
            }
        }

        $district = ($this->district && $this->district !== '[KOTA]' && $this->district !== '[PROVINSI]') ? $this->district : $this->city;
        $city = $this->city ?: 'sekitarnya';
        $priceFormatted = 'Rp ' . number_format($this->resolved_price, 0, ',', '.');

        $cityData = RegionService::findCity($this->city);
        $citySlug = $cityData['slug'] ?? Str::slug($this->city);
        $districtParam = ($this->district && $this->district !== '[KOTA]' && $this->district !== '[PROVINSI]') ? $this->district : null;
        $profile = \App\Services\RegionalTaxonomy::getProfile($citySlug, $districtParam, $this->city);
        $zoneFaqs = $profile['local_faqs'] ?? [];

        if ($this->isProvince()) {
            $provName = $this->province_name ?: $this->city;
            $provFaqs = [
                [
                    'question' => "Berapa lama estimasi kedatangan teknisi Drainusantara di wilayah {$provName}?",
                    'answer' => "Posko armada kami tersebar di kota-kota strategis {$provName}. Teknisi siaga langsung meluncur ke lokasi Anda secepatnya setelah konfirmasi pesanan via WhatsApp.",
                ],
                [
                    'question' => "Apakah pengerjaan saluran mampet di {$provName} membongkar lantai keramik?",
                    'answer' => "Sama sekali tidak (100% tanpa bongkar ubin/keramik). Kami menggunakan mesin spiral rotary Ridgid USA berkecepatan 400 RPM yang meliuk fleksibel menembus leher angsa dan pipa PVC tanpa merusak struktur lantai hunian.",
                ],
                [
                    'question' => "Jenis saluran pipa apa saja yang ditangani armada {$provName}?",
                    'answer' => "Kami menangani saluran wastafel cuci piring dapur, kloset/toilet duduk & jongkok, floor drain kamar mandi, bak kontrol, talang air hujan, hingga grease trap restoran dan saluran komersial ruko.",
                ],
                [
                    'question' => "Berapa biaya jasa pelancaran pipa mampet di {$provName}?",
                    'answer' => "Biaya jasa penanganan transparan mulai dari {$priceFormatted} dengan sistem No Cure No Pay. Jika saluran air gagal mengalir lancar, Anda bebas dari biaya jasa pengerjaan.",
                ],
                [
                    'question' => "Bagaimana ketentuan garansi pengerjaan pipa di {$provName}?",
                    'answer' => "Setiap pekerjaan yang selesai tuntas dilindungi nota digital garansi resmi 30 hari kalender. Jika terjadi kendala berulang pada titik yang sama selama masa garansi, teknisi kami datang kembali untuk perbaikan tuntas tanpa biaya tambahan.",
                ],
            ];

            return array_map(fn($f) => ['question' => $this->sanitizeText($f['question']), 'answer' => $this->sanitizeText($f['answer'])], $provFaqs);
        }

        if ($this->isCity()) {
            $baseCityFaqs = [
                [
                    'question' => "Berapa lama estimasi teknisi Drainusantara tiba di lokasi {$city}?",
                    'answer' => "Armada siaga teknisi kami di posko {$city} bergerak cepat menuju lokasi Anda secepatnya setelah konfirmasi pemesanan, menyesuaikan rute lalu lintas terdekat.",
                ],
                [
                    'question' => "Apakah pengerjaan saluran mampet di {$city} membongkar lantai keramik?",
                    'answer' => "Sama sekali tidak (100% tanpa bongkar ubin/keramik). Kami menggunakan mesin spiral baja rotary Ridgid berdaya puntir tinggi yang meliuk mengikuti alur pipa PVC hingga titik sumbatan terdalam tanpa merusak struktur ubin lantai.",
                ],
            ];

            if (! empty($zoneFaqs[0])) {
                $baseCityFaqs[] = $zoneFaqs[0];
            }
            if (! empty($zoneFaqs[2])) {
                $baseCityFaqs[] = $zoneFaqs[2];
            }

            $baseCityFaqs[] = [
                'question' => "Berapa biaya jasa pelancaran pipa mampet di {$city}?",
                'answer' => "Biaya jasa penanganan transparan mulai dari {$priceFormatted} dengan komitmen No Cure No Pay (jika saluran gagal mengalir plong, Anda bebas dari biaya jasa pengerjaan).",
            ];
            $baseCityFaqs[] = [
                'question' => "Apakah ada garansi resmi untuk pengerjaan saluran di {$city}?",
                'answer' => "Ya, setiap pengerjaan yang dinyatakan tuntas dilindungi nota digital garansi resmi 30 hari kalender. Jika terjadi sumbatan ulang di titik yang sama dalam masa garansi, tim kami melancarkan ulang gratis tanpa biaya tambahan.",
            ];

            return array_map(fn($f) => ['question' => $this->sanitizeText($f['question']), 'answer' => $this->sanitizeText($f['answer'])], $baseCityFaqs);
        }

        $baseDistrictFaqs = [
            [
                'question' => "Berapa lama estimasi teknisi Drainusantara tiba di area {$district}, {$city}?",
                'answer' => "Armada siaga teknisi kami di posko {$city} bergerak cepat, teknisi menuju ke lokasi anda secepatnya setelah konfirmasi pemesanan, menyesuaikan rute lalu lintas terdekat.",
            ],
            [
                'question' => "Apakah pengerjaan saluran mampet di {$district} membongkar lantai keramik?",
                'answer' => "Sama sekali tidak (100% tanpa bongkar ubin/keramik). Kami menggunakan mesin spiral baja rotary berdaya puntir tinggi yang meliuk mengikuti alur pipa PVC hingga titik sumbatan terdalam tanpa merusak struktur lantai.",
            ],
        ];

        if (! empty($zoneFaqs[0])) {
            $baseDistrictFaqs[] = $zoneFaqs[0];
        }
        if (! empty($zoneFaqs[1])) {
            $baseDistrictFaqs[] = $zoneFaqs[1];
        }

        $baseDistrictFaqs[] = [
            'question' => "Berapa biaya jasa pelancaran pipa mampet di {$district}?",
            'answer' => "Biaya jasa penanganan mulai dari {$priceFormatted} dengan skema No Cure No Pay (jika saluran gagal mengalir lancar, Anda bebas dari biaya jasa pengerjaan).",
        ];
        $baseDistrictFaqs[] = [
            'question' => "Apakah ada garansi resmi untuk pengerjaan di {$district}?",
            'answer' => "Ya, setiap pengerjaan yang dinyatakan tuntas dilindungi nota digital garansi resmi 30 hari kalender. Jika terjadi sumbatan ulang di titik yang sama dalam masa garansi, tim kami melancarkan ulang tanpa biaya tambahan.",
        ];

        return array_map(fn($f) => ['question' => $this->sanitizeText($f['question']), 'answer' => $this->sanitizeText($f['answer'])], $baseDistrictFaqs);
    }

    /**
     * Get resolved advantages (Keunggulan / Standar Operasional Wilayah) with local area context.
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

        $locationName = $this->isProvince() 
            ? ($this->province_name ?: $this->city) 
            : ($this->getCleanDistrict() ?: $this->city);

        $cityData = RegionService::findCity($this->city);
        $citySlug = $cityData['slug'] ?? Str::slug($this->city);
        $profile = \App\Services\RegionalTaxonomy::getProfile($citySlug, $this->getCleanDistrict(), $this->city);
        $advantageFocus = $profile['advantages_focus'] ?? 'Mengikis kerak lemak beku tanpa membongkar keramik lantai hunian.';

        return [
            [
                'title' => 'Rotary Ridgid 400 RPM Tanpa Bongkar',
                'code' => 'SOP-01',
                'badge' => 'Standar Terverifikasi',
                'description' => "Kabel spiral baja tempered meliuk fleksibel menembus leher angsa sifon hingga 30 meter di {$locationName}. {$advantageFocus}",
                'checkpoints' => [
                    'Kabel baja tempered elastis 16mm - 20mm',
                    'Jangkauan penetrasi fleksibel hingga 30 meter',
                    '100% keramik lantai dan dinding utuh aman',
                ],
                'icon' => 'tool',
            ],
            [
                'title' => '100% Bebas Soda Api & Kimia Korosif',
                'code' => 'SOP-02',
                'badge' => 'KEAMANAN PIPA PVC',
                'description' => 'Menghindari risiko panas reaksi kimia keras (NaOH) yang melunakkan pipa PVC, memicu deformasi jalur, atau merusak fitting lem pipa di bawah cor semen beton.',
                'checkpoints' => [
                    'Bebas risiko sambungan fitting pipa melorot',
                    'Aman dari uap panas kimia beracun di ruangan',
                    'Mencegah kerusakan struktur pipa di bawah semen',
                ],
                'icon' => 'shield',
            ],
            [
                'title' => 'Protokol Higienis & SOP K3 Teknisi',
                'code' => 'SOP-03',
                'badge' => 'STANDAR K3 & SANITASI',
                'description' => 'Teknisi berseragam rapi, mengenakan sarung tangan nitril steril, wajib memakai pelindung sepatu (cover shoes) di dalam hunian, dan membersihkan area kerja.',
                'checkpoints' => [
                    'Wajib cover shoes & sarung tangan nitril steril',
                    'Pembersihan & desinfeksi area kerja usai tindakan',
                    'Teknisi berseragam resmi dengan identitas jelas',
                ],
                'icon' => 'truck',
            ],
            [
                'title' => 'Uji Alir Sanitasi Debit Penuh',
                'code' => 'SOP-04',
                'badge' => 'QUALITY FLOW TEST',
                'description' => 'Pengujian aliran air debit maksimal di hadapan pemilik properti sebelum serah terima untuk memastikan saluran mengalir plong tanpa sumbatan tersisa.',
                'checkpoints' => [
                    'Flushing debit air maksimal bersama pemilik',
                    'Memastikan sisa kerak terdorong tuntas ke bak kontrol',
                    'Verifikasi tidak ada rembesan pada jalur sifon',
                ],
                'icon' => 'check',
            ],
            [
                'title' => 'Komitmen No Cure No Pay & Garansi 30 Hari',
                'code' => 'SOP-05',
                'badge' => 'JAMINAN RESMI TERTULIS',
                'description' => "Kepastian tarif transparan di {$locationName}. Bebas biaya pengerjaan jika saluran gagal lancar, serta dilindungi nota garansi resmi 30 hari kalender.",
                'checkpoints' => [
                    'Bebas biaya jika saluran gagal lancar (No Cure No Pay)',
                    'Nota fisik resmi dengan stempel garansi 30 hari',
                    'Layanan komplain prioritas bebas biaya tambahan',
                ],
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
        $cleanDistrict = $this->getCleanDistrict();
        $district = $cleanDistrict ?: $this->city;
        $city = $this->city;

        $rawName = $this->posko_name ?: "Posko Siaga Drainusantara Unit {$district}";
        $rawAddress = $this->posko_address ?: "Pusat Operasional Armada Siaga Drainusantara Area {$city} (Siaga menjangkau seluruh kelurahan di {$district} dan sekitarnya).";
        $rawRadius = $this->posko_coverage_radius ?: 'Radius Jangkauan 15-20 KM • Teknisi Menuju ke Lokasi Anda Secepatnya';

        return [
            'name' => $this->sanitizeText($rawName),
            'address' => $this->sanitizeText($rawAddress),
            'radius' => $this->sanitizeText($rawRadius),
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
        $cleanDistrict = $this->getCleanDistrict();
        $district = $cleanDistrict ?: $this->city;
        $city = $this->city;

        $defaultHeadline = "Saluran Air di {$district} Tersumbat Hari Ini?";
        $defaultButton = "Panggil Teknisi Sekarang";
        $defaultWa = $cleanDistrict
            ? "Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di area {$cleanDistrict}, {$city}. Mohon info biaya dan estimasi kedatangan teknisi ke lokasi saya."
            : "Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di area {$city}. Mohon info biaya dan estimasi kedatangan teknisi ke lokasi saya.";

        $rawHeadline = $this->cta_headline ?: $defaultHeadline;
        $rawButton = $this->cta_button_text ?: $defaultButton;
        $rawWa = $this->cta_whatsapp_text ?: $defaultWa;

        return [
            'headline' => $this->sanitizeText($rawHeadline),
            'button_text' => $this->sanitizeText($rawButton),
            'whatsapp_text' => $this->sanitizeText($rawWa),
        ];
    }

    public function publicUrl(): ?string
    {
        if (! $this->is_active) {
            return null;
        }

        if ($this->isProvince()) {
            return route('area.province', ['province' => $this->slug]);
        }

        if ($this->isCity()) {
            return route('area.city', ['city' => $this->slug]);
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

        foreach ($provinces as $provSlug => $province) {
            $provName = $province['name'];

            // 1. Sync Province level
            $provArea = self::where(function ($query) use ($provName, $provSlug) {
                $query->where('slug', $provSlug)
                    ->orWhere(function ($q) use ($provName) {
                        $q->where('city', $provName)->where('district', '[PROVINSI]');
                    });
            })->first();

            if (! $provArea) {
                $provRes = \App\Services\AreaImageResolver::resolve(null, $provSlug);
                self::create([
                    'type' => 'province',
                    'province_name' => $provName,
                    'city' => $provName,
                    'district' => '[PROVINSI]',
                    'slug' => $provSlug,
                    'hero_image' => $provRes['path'],
                    'presence_image' => $provRes['path'],
                    'meta_title' => "Jasa Saluran Mampet {$provName} - Drainusantara Bergaransi",
                    'meta_description' => "Layanan pelancaran pipa saluran mampet tanpa bongkar keramik di wilayah {$provName}. Armada siaga di seluruh kota dengan garansi resmi 30 hari.",
                    'content' => "Layanan penanganan saluran pipa mampet berstandar profesional di seluruh kota/kabupaten Provinsi {$provName}. Didukung armada mekanis spiral rotary tanpa bongkar keramik.",
                    'posko_name' => "Posko Siaga Regional {$provName}",
                    'posko_address' => "Pusat Koordinasi Armada Siaga Wilayah {$provName}",
                    'posko_coverage_radius' => "Jangkauan Seluruh Kota/Kabupaten di {$provName}",
                    'cta_headline' => "Saluran Air di {$provName} Tersumbat Hari Ini?",
                    'cta_button_text' => "Panggil Teknisi via WhatsApp",
                    'cta_whatsapp_text' => "Halo Admin Drainusantara, saya ingin konsultasi penanganan pipa mampet di Provinsi {$provName}. Mohon info armada terdekat.",
                    'is_active' => true,
                ]);
                $created++;
            } else {
                $updates = [];
                if ($provArea->type !== 'province' || empty($provArea->province_name)) {
                    $updates['type'] = 'province';
                    $updates['province_name'] = $provName;
                }
                if (empty($provArea->hero_image)) {
                    $provRes = \App\Services\AreaImageResolver::resolve(null, $provSlug);
                    $updates['hero_image'] = $provRes['path'];
                    if (empty($provArea->presence_image)) {
                        $updates['presence_image'] = $provRes['path'];
                    }
                }
                if (! empty($updates)) {
                    $provArea->update($updates);
                }
                $existing++;
            }

            // 2. Sync Cities & Districts
            foreach ($province['cities'] as $citySlug => $city) {
                $cityName = $city['name'];

                // City Level record
                $cityArea = self::where(function ($query) use ($cityName, $citySlug) {
                    $query->where('slug', $citySlug)
                        ->orWhere(function ($q) use ($cityName) {
                            $q->where('city', $cityName)->whereIn('district', ['[KOTA]', '', null]);
                        });
                })->first();

                if (! $cityArea) {
                    $cityRes = \App\Services\AreaImageResolver::resolve(null, $provSlug, $citySlug);
                    self::create([
                        'type' => 'city',
                        'province_name' => $provName,
                        'city' => $cityName,
                        'district' => '[KOTA]',
                        'slug' => $citySlug,
                        'hero_image' => $cityRes['path'],
                        'presence_image' => $cityRes['path'],
                        'meta_title' => "Jasa Saluran Mampet {$cityName} - Drainusantara Bergaransi",
                        'meta_description' => "Jasa pelancaran wastafel, kloset toilet, dan saluran mampet di {$cityName} tanpa bongkar keramik & garansi 30 hari. Hubungi teknisi terdekat sekarang!",
                        'content' => "Layanan penanganan saluran pipa mampet di seluruh wilayah {$cityName} dan sekitarnya.",
                        'posko_name' => "Posko Armada Siaga {$cityName}",
                        'posko_address' => $city['posko_address'] ?? "Posko Armada Siaga {$cityName}",
                        'posko_coverage_radius' => "Radius Jangkauan 15-20 KM • Teknisi Siaga Menuju Lokasi",
                        'cta_headline' => "Saluran Air di {$cityName} Mampet?",
                        'cta_button_text' => "Panggil Teknisi via WhatsApp",
                        'cta_whatsapp_text' => "Halo teknisi Drainusantara, saya butuh layanan darurat pelancaran saluran pipa mampet di area {$cityName}. Mohon info jadwal teknisi terdekat.",
                        'presence_description' => "Drainusantara hadir di {$cityName} dengan posko armada siaga untuk melayani perumahan, ruko, restoran, dan gedung tanpa bongkar lantai keramik.",
                        'is_active' => true,
                    ]);
                    $created++;
                } else {
                    $updates = [];
                    if ($cityArea->type !== 'city' || empty($cityArea->province_name)) {
                        $updates['type'] = 'city';
                        $updates['province_name'] = $provName;
                    }
                    if (empty($cityArea->hero_image)) {
                        $cityRes = \App\Services\AreaImageResolver::resolve(null, $provSlug, $citySlug);
                        $updates['hero_image'] = $cityRes['path'];
                        if (empty($cityArea->presence_image)) {
                            $updates['presence_image'] = $cityRes['path'];
                        }
                    }
                    if (! empty($updates)) {
                        $cityArea->update($updates);
                    }
                    $existing++;
                }

                // District Level records
                foreach ($city['districts'] as $district) {
                    $slug = Str::slug("{$cityName} {$district}");

                    $area = self::where(function ($query) use ($cityName, $district, $slug) {
                        $query->where(function ($q) use ($cityName, $district) {
                            $q->where('city', $cityName)->where('district', $district);
                        })->orWhere('slug', $slug);
                    })->first();

                    if ($area) {
                        $updates = [];
                        if ($area->type !== 'district' || empty($area->province_name)) {
                            $updates['type'] = 'district';
                            $updates['province_name'] = $provName;
                        }
                        if (empty($area->hero_image)) {
                            $distRes = \App\Services\AreaImageResolver::resolve(null, $provSlug, $citySlug, $district);
                            $updates['hero_image'] = $distRes['path'];
                            if (empty($area->presence_image)) {
                                $updates['presence_image'] = $distRes['path'];
                            }
                        }
                        if (! empty($updates)) {
                            $area->update($updates);
                        }
                        $existing++;
                        continue;
                    }

                    $distRes = \App\Services\AreaImageResolver::resolve(null, $provSlug, $citySlug, $district);
                    self::create([
                        'type' => 'district',
                        'province_name' => $provName,
                        'city' => $cityName,
                        'district' => $district,
                        'slug' => $slug,
                        'hero_image' => $distRes['path'],
                        'presence_image' => $distRes['path'],
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
