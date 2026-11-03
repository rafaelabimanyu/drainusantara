<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CoverageArea;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BaliAreaSeeder extends Seeder
{
    /**
     * Run the database seeds for Bali Province and its Regencies/Districts.
     */
    public function run(): void
    {
        $provinceName = 'Bali';
        $provinceSlug = 'bali';

        // -------------------------------------------------------------
        // 1. Data Wilayah Hierarki Bali
        // -------------------------------------------------------------
        $hierarchy = [
            'Kota Denpasar' => [
                'slug' => 'kota-denpasar',
                'posko' => 'Posko Armada Siaga Denpasar (Area Teuku Umar, Sanur & Sekitarnya)',
                'lat' => -8.6704582,
                'lng' => 115.2126293,
                'districts' => [
                    ['name' => 'Sanur', 'lat' => -8.6882, 'lng' => 115.2625, 'postal_code' => '80228'],
                    ['name' => 'Denpasar Selatan', 'lat' => -8.6980, 'lng' => 115.2280, 'postal_code' => '80225'],
                    ['name' => 'Denpasar Barat', 'lat' => -8.6650, 'lng' => 115.1950, 'postal_code' => '80119'],
                    ['name' => 'Denpasar Timur', 'lat' => -8.6500, 'lng' => 115.2400, 'postal_code' => '80235'],
                    ['name' => 'Denpasar Utara', 'lat' => -8.6250, 'lng' => 115.2150, 'postal_code' => '80115'],
                ],
            ],
            'Kabupaten Badung' => [
                'slug' => 'kabupaten-badung',
                'posko' => 'Posko Armada Siaga Badung Selatan (Kawasan Kuta, Sunset Road & Nusa Dua)',
                'lat' => -8.5833,
                'lng' => 115.1833,
                'districts' => [
                    ['name' => 'Kuta', 'lat' => -8.7275, 'lng' => 115.1726, 'postal_code' => '80361'],
                    ['name' => 'Seminyak', 'lat' => -8.6894, 'lng' => 115.1583, 'postal_code' => '80361'],
                    ['name' => 'Canggu', 'lat' => -8.6478, 'lng' => 115.1385, 'postal_code' => '80351'],
                    ['name' => 'Jimbaran', 'lat' => -8.7712, 'lng' => 115.1687, 'postal_code' => '80361'],
                    ['name' => 'Nusa Dua', 'lat' => -8.7963, 'lng' => 115.2253, 'postal_code' => '80363'],
                    ['name' => 'Kuta Utara', 'lat' => -8.6400, 'lng' => 115.1600, 'postal_code' => '80361'],
                    ['name' => 'Kuta Selatan', 'lat' => -8.8100, 'lng' => 115.1650, 'postal_code' => '80361'],
                    ['name' => 'Mengwi', 'lat' => -8.5450, 'lng' => 115.1700, 'postal_code' => '80351'],
                    ['name' => 'Abiansemal', 'lat' => -8.5300, 'lng' => 115.2100, 'postal_code' => '80352'],
                ],
            ],
            'Kabupaten Gianyar' => [
                'slug' => 'kabupaten-gianyar',
                'posko' => 'Posko Armada Siaga Gianyar (Area Ubud, Batubulan & Sekitarnya)',
                'lat' => -8.5433,
                'lng' => 115.3267,
                'districts' => [
                    ['name' => 'Ubud', 'lat' => -8.5069, 'lng' => 115.2625, 'postal_code' => '80571'],
                    ['name' => 'Sukawati', 'lat' => -8.5975, 'lng' => 115.2831, 'postal_code' => '80582'],
                    ['name' => 'Blahbatuh', 'lat' => -8.5714, 'lng' => 115.3050, 'postal_code' => '80581'],
                    ['name' => 'Gianyar', 'lat' => -8.5433, 'lng' => 115.3267, 'postal_code' => '80511'],
                    ['name' => 'Tegallalang', 'lat' => -8.4400, 'lng' => 115.2800, 'postal_code' => '80561'],
                ],
            ],
            'Kabupaten Tabanan' => [
                'slug' => 'kabupaten-tabanan',
                'posko' => 'Posko Armada Siaga Tabanan (Kediri, Kota Tabanan & Sekitarnya)',
                'lat' => -8.5392,
                'lng' => 115.1256,
                'districts' => [
                    ['name' => 'Tabanan', 'lat' => -8.5392, 'lng' => 115.1256, 'postal_code' => '82113'],
                    ['name' => 'Kediri', 'lat' => -8.5600, 'lng' => 115.1400, 'postal_code' => '82121'],
                    ['name' => 'Baturiti', 'lat' => -8.3200, 'lng' => 115.1800, 'postal_code' => '82191'],
                    ['name' => 'Marga', 'lat' => -8.4900, 'lng' => 115.1700, 'postal_code' => '82181'],
                ],
            ],
            'Kabupaten Buleleng' => [
                'slug' => 'kabupaten-buleleng',
                'posko' => 'Posko Armada Siaga Bali Utara (Singaraja, Lovina & Sekitarnya)',
                'lat' => -8.1120,
                'lng' => 115.0882,
                'districts' => [
                    ['name' => 'Buleleng', 'lat' => -8.1120, 'lng' => 115.0882, 'postal_code' => '81119'],
                    ['name' => 'Lovina', 'lat' => -8.1610, 'lng' => 115.0250, 'postal_code' => '81151'],
                    ['name' => 'Seririt', 'lat' => -8.1950, 'lng' => 114.9350, 'postal_code' => '81153'],
                ],
            ],
            'Kabupaten Bangli' => [
                'slug' => 'kabupaten-bangli',
                'posko' => 'Posko Armada Siaga Bangli (Pusat Kota Bangli & Kintamani)',
                'lat' => -8.4542,
                'lng' => 115.3550,
                'districts' => [
                    ['name' => 'Bangli', 'lat' => -8.4542, 'lng' => 115.3550, 'postal_code' => '80614'],
                    ['name' => 'Kintamani', 'lat' => -8.2450, 'lng' => 115.3350, 'postal_code' => '80652'],
                ],
            ],
            'Kabupaten Klungkung' => [
                'slug' => 'kabupaten-klungkung',
                'posko' => 'Posko Siaga Klungkung (Semarapura & Sekitarnya)',
                'lat' => -8.5350,
                'lng' => 115.4050,
                'districts' => [
                    ['name' => 'Klungkung', 'lat' => -8.5350, 'lng' => 115.4050, 'postal_code' => '80711'],
                    ['name' => 'Dawan', 'lat' => -8.5300, 'lng' => 115.4400, 'postal_code' => '80761'],
                    ['name' => 'Nusa Penida', 'lat' => -8.7278, 'lng' => 115.5444, 'postal_code' => '80771'],
                ],
            ],
            'Kabupaten Karangasem' => [
                'slug' => 'kabupaten-karangasem',
                'posko' => 'Posko Armada Siaga Karangasem (Amlapura & Kawasan Pesisir Timur)',
                'lat' => -8.4500,
                'lng' => 115.6100,
                'districts' => [
                    ['name' => 'Karangasem', 'lat' => -8.4500, 'lng' => 115.6100, 'postal_code' => '80811'],
                    ['name' => 'Candidasa', 'lat' => -8.5080, 'lng' => 115.5680, 'postal_code' => '80871'],
                    ['name' => 'Padangbai', 'lat' => -8.5330, 'lng' => 115.5080, 'postal_code' => '80872'],
                ],
            ],
            'Kabupaten Jembrana' => [
                'slug' => 'kabupaten-jembrana',
                'posko' => 'Posko Armada Siaga Jembrana (Negara & Jalur Gilimanuk)',
                'lat' => -8.3583,
                'lng' => 114.6167,
                'districts' => [
                    ['name' => 'Negara', 'lat' => -8.3583, 'lng' => 114.6167, 'postal_code' => '82218'],
                    ['name' => 'Gilimanuk', 'lat' => -8.1630, 'lng' => 114.4380, 'postal_code' => '82252'],
                ],
            ],
        ];

        // -------------------------------------------------------------
        // 2. Seeding Tingkat Provinsi: BALI
        // -------------------------------------------------------------
        CoverageArea::updateOrCreate(
            ['slug' => $provinceSlug],
            [
                'type' => 'province',
                'province_name' => $provinceName,
                'city' => $provinceName,
                'district' => '[PROVINSI]',
                'meta_title' => 'Jasa Saluran Pipa Mampet Bali - Drainusantara Bergaransi',
                'meta_description' => 'Jasa pelancaran pipa saluran mampet tanpa bongkar di seluruh Provinsi Bali (Denpasar, Badung, Gianyar, Tabanan). Bergaransi resmi 30 hari & respon cepat.',
                'content' => 'Layanan pembersihan dan pelancaran pipa saluran mampet profesional untuk villa, hotel, restoran, kafe, resort, dan hunian di seluruh Provinsi Bali menggunakan mesin spiral baja rotary berteknologi modern tanpa merusak ubin keramik.',
                'posko_name' => 'Posko Siaga Regional Bali',
                'posko_address' => 'Pusat Koordinasi Wilayah Bali, Siaga Melayani Seluruh Kota & Kabupaten di Pulau Dewata',
                'posko_coverage_radius' => 'Jangkauan Seluruh Kabupaten/Kota se-Bali • Siaga Cepat',
                'cta_headline' => 'Saluran Pipa di Bali Tersumbat Hari Ini?',
                'cta_button_text' => 'Panggil Teknisi via WhatsApp',
                'cta_whatsapp_text' => 'Halo Admin Drainusantara, saya membutuhkan layanan pelancaran saluran pipa mampet di Provinsi Bali. Mohon info teknisi terdekat.',
                'latitude' => -8.4095178,
                'longitude' => 115.188916,
                'is_active' => true,
            ]
        );

        // -------------------------------------------------------------
        // 3. Seeding Tingkat Kota/Kabupaten & Kecamatan/Kawasan
        // -------------------------------------------------------------
        foreach ($hierarchy as $cityName => $cityData) {
            // Level Kota / Kabupaten
            CoverageArea::updateOrCreate(
                ['slug' => $cityData['slug']],
                [
                    'type' => 'city',
                    'province_name' => $provinceName,
                    'city' => $cityName,
                    'district' => '[KOTA]',
                    'meta_title' => "Jasa Saluran Mampet {$cityName} - Drainusantara Bergaransi",
                    'meta_description' => "Jasa saluran pipa wastafel, kloset toilet, dan grease trap restoran mampet di {$cityName}, Bali. 100% tanpa bongkar keramik, teknisi ber-APD & garansi 30 hari.",
                    'content' => "Layanan pelancaran pipa mampet untuk perumahan, villa, ruko, restoran, dan hotel di area {$cityName}. Ditangani langsung dengan mesin spiral Ridgid tanpa bahan kimia berbahaya.",
                    'posko_name' => "Posko Siaga {$cityName}",
                    'posko_address' => $cityData['posko'],
                    'posko_coverage_radius' => 'Radius Jangkauan 15-25 KM • Teknisi Siaga Menuju Lokasi',
                    'cta_headline' => "Saluran Pembuangan Air di {$cityName} Mampet?",
                    'cta_button_text' => 'Panggil Teknisi via WhatsApp',
                    'cta_whatsapp_text' => "Halo teknisi Drainusantara, saya membutuhkan layanan darurat pipa mampet di {$cityName}. Mohon info kedatangan teknisi terdekat.",
                    'presence_description' => "Drainusantara hadir di {$cityName} dengan posko armada siaga untuk melayani perumahan, villa resort, dan restoran cepat tuntas bergaransi.",
                    'latitude' => $cityData['lat'],
                    'longitude' => $cityData['lng'],
                    'is_active' => true,
                ]
            );

            // Level Kecamatan / Kawasan
            foreach ($cityData['districts'] as $dist) {
                $districtName = $dist['name'];
                $districtSlug = Str::slug("{$cityName} {$districtName}");

                CoverageArea::updateOrCreate(
                    [
                        'city' => $cityName,
                        'district' => $districtName,
                    ],
                    [
                        'type' => 'district',
                        'province_name' => $provinceName,
                        'slug' => $districtSlug,
                        'postal_code' => $dist['postal_code'] ?? null,
                        'meta_title' => "Jasa Saluran Mampet di {$districtName}, {$cityName} - Bergaransi",
                        'meta_description' => "Spesialis pipa mampet wastafel, kamar mandi, WC, dan saluran lemak dapur di {$districtName}, {$cityName}. Tanpa bongkar lantai, garansi resmi 30 hari.",
                        'content' => "Layanan penanganan saluran pipa mampet berstandar profesional di kawasan {$districtName}, {$cityName}. Solusi ideal untuk villa privat, resort hotel, kafe, restoran, dan hunian warga tanpa soda api.",
                        'latitude' => $dist['lat'],
                        'longitude' => $dist['lng'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}

