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
        'meta_title',
        'meta_description',
        'content',
        'hero_image',
        'faqs',
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
            'faqs' => 'array',
            'is_active' => 'boolean',
        ];
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

        return [
            [
                'question' => "Berapa lama estimasi teknisi Drainusantara tiba di area {$district}, {$city}?",
                'answer' => "Armada siaga teknisi kami di posko {$city} umumnya dapat tiba di lokasi Anda di area {$district} dalam waktu 30 hingga 60 menit setelah konfirmasi pemesanan, menyesuaikan rute lalu lintas terdekat.",
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
                'answer' => "Biaya jasa penanganan mulai dari Rp 400.000 dengan skema No Cure No Pay (jika saluran gagal mengalir lancar, Anda bebas dari biaya jasa pengerjaan).",
            ],
            [
                'question' => "Apakah ada garansi resmi untuk pengerjaan di {$district}?",
                'answer' => "Ya, setiap pengerjaan yang dinyatakan tuntas dilindungi nota digital garansi resmi 30 hari kalender. Jika terjadi sumbatan ulang di titik yang sama dalam masa garansi, tim kami melancarkan ulang tanpa biaya tambahan.",
            ],
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

