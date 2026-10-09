<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class RegionService
{
    /**
     * Complete hierarchical data of provinces, cities, and districts.
     */
    public static function all(): array
    {
        return [
            'dki-jakarta' => [
                'name' => 'DKI Jakarta',
                'slug' => 'dki-jakarta',
                'type' => 'Provinsi',
                'description' => 'Layanan pembersihan pipa mampet tanpa bongkar keramik di seluruh wilayah Daerah Khusus Ibukota Jakarta dengan armada posko siaga 24 jam.',
                'cities' => [
                    'jakarta-timur' => [
                        'name' => 'Jakarta Timur',
                        'slug' => 'jakarta-timur',
                        'type' => 'Kota Administrasi',
                        'province_name' => 'DKI Jakarta',
                        'province_slug' => 'dki-jakarta',
                        'posko_address' => 'Posko Armada Siaga Jakarta Timur (Area Duren Sawit & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Ciracas',
                            'Duren Sawit',
                            'Cakung',
                            'Rawamangun',
                            'Jatinegara',
                            'Kramat Jati',
                            'Matraman',
                            'Pasar Rebo',
                            'Pulo Gadung',
                            'Cipayung',
                            'Makasar',
                        ],
                    ],
                    'jakarta-selatan' => [
                        'name' => 'Jakarta Selatan',
                        'slug' => 'jakarta-selatan',
                        'type' => 'Kota Administrasi',
                        'province_name' => 'DKI Jakarta',
                        'province_slug' => 'dki-jakarta',
                        'posko_address' => 'Posko Armada Siaga Jakarta Selatan (Area Tebet & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Tebet',
                            'Cilandak',
                            'Kebayoran Baru',
                            'Kebayoran Lama',
                            'Mampang Prapatan',
                            'Pancoran',
                            'Pasar Minggu',
                            'Pesanggrahan',
                            'Setiabudi',
                            'Jagakarsa',
                        ],
                    ],
                    'jakarta-barat' => [
                        'name' => 'Jakarta Barat',
                        'slug' => 'jakarta-barat',
                        'type' => 'Kota Administrasi',
                        'province_name' => 'DKI Jakarta',
                        'province_slug' => 'dki-jakarta',
                        'posko_address' => 'Posko Armada Siaga Jakarta Barat (Area Kebon Jeruk & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Kebon Jeruk',
                            'Puri Kembangan',
                            'Grogol Petamburan',
                            'Palmerah',
                            'Cengkareng',
                            'Kalideres',
                            'Tambora',
                            'Taman Sari',
                        ],
                    ],
                    'jakarta-utara' => [
                        'name' => 'Jakarta Utara',
                        'slug' => 'jakarta-utara',
                        'type' => 'Kota Administrasi',
                        'province_name' => 'DKI Jakarta',
                        'province_slug' => 'dki-jakarta',
                        'posko_address' => 'Posko Armada Siaga Jakarta Utara (Area Kelapa Gading & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Kelapa Gading',
                            'Pantai Indah Kapuk',
                            'Sunter',
                            'Pluit',
                            'Tanjung Priok',
                            'Penjaringan',
                            'Pademangan',
                            'Koja',
                            'Cilincing',
                        ],
                    ],
                    'jakarta-pusat' => [
                        'name' => 'Jakarta Pusat',
                        'slug' => 'jakarta-pusat',
                        'type' => 'Kota Administrasi',
                        'province_name' => 'DKI Jakarta',
                        'province_slug' => 'dki-jakarta',
                        'posko_address' => 'Posko Armada Siaga Jakarta Pusat (Area Kemayoran & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Kemayoran',
                            'Cempaka Putih',
                            'Menteng',
                            'Gambir',
                            'Sawah Besar',
                            'Senen',
                            'Tanah Abang',
                            'Johar Baru',
                        ],
                    ],
                ],
            ],
            'jawa-barat' => [
                'name' => 'Jawa Barat',
                'slug' => 'jawa-barat',
                'type' => 'Provinsi',
                'description' => 'Posko teknisi siaga pelancaran pipa mampet untuk wilayah hunian, ruko, dan kawasan industri di Bogor, Depok, dan Bekasi.',
                'cities' => [
                    'bogor' => [
                        'name' => 'Bogor',
                        'slug' => 'bogor',
                        'type' => 'Kota & Kabupaten',
                        'province_name' => 'Jawa Barat',
                        'province_slug' => 'jawa-barat',
                        'posko_address' => 'Posko Armada Siaga Bogor (Area Cibinong, Sentul & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Cibinong',
                            'Sentul City',
                            'Kota Bogor',
                            'Bojonggede',
                            'Gunung Putri',
                            'Cileungsi',
                            'Sukaraja',
                            'Babakan Madang',
                        ],
                    ],
                    'depok-cinere' => [
                        'name' => 'Depok & Cinere',
                        'slug' => 'depok-cinere',
                        'type' => 'Kota',
                        'province_name' => 'Jawa Barat',
                        'province_slug' => 'jawa-barat',
                        'posko_address' => 'Posko Armada Siaga Depok & Cinere (Area Margonda & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Cinere',
                            'Margonda',
                            'Sawangan',
                            'Beji',
                            'Pancoran Mas',
                            'Sukmajaya',
                            'Cimanggis',
                            'Tapos',
                        ],
                    ],
                    'bekasi-cikarang' => [
                        'name' => 'Bekasi & Cikarang',
                        'slug' => 'bekasi-cikarang',
                        'type' => 'Kota & Kabupaten',
                        'province_name' => 'Jawa Barat',
                        'province_slug' => 'jawa-barat',
                        'posko_address' => 'Posko Armada Siaga Bekasi & Cikarang',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Cikarang Selatan',
                            'Cikarang Utara',
                            'Bekasi Barat',
                            'Bekasi Timur',
                            'Bekasi Selatan',
                            'Bekasi Utara',
                            'Tambun Selatan',
                            'Harapan Indah',
                            'Cibitung',
                        ],
                    ],
                    'bandung' => [
                        'name' => 'Kota Bandung',
                        'slug' => 'bandung',
                        'type' => 'Kota',
                        'province_name' => 'Jawa Barat',
                        'province_slug' => 'jawa-barat',
                        'posko_address' => 'Posko Armada Siaga Kota Bandung',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Buahbatu',
                            'Antapani',
                            'Coblong',
                            'Sukajadi',
                            'Dago',
                            'Lengkong',
                            'Cibiru',
                            'Regol',
                            'Batununggal',
                            'Arcamanik',
                        ],
                    ],
                ],
            ],
            'banten' => [
                'name' => 'Banten',
                'slug' => 'banten',
                'type' => 'Provinsi',
                'description' => 'Layanan cepat teknisi saluran pipa mampet untuk perumahan, klaster modern, dan sentra niaga di Tangerang Raya.',
                'cities' => [
                    'tangerang-kota' => [
                        'name' => 'Tangerang Kota',
                        'slug' => 'tangerang-kota',
                        'type' => 'Kota',
                        'province_name' => 'Banten',
                        'province_slug' => 'banten',
                        'posko_address' => 'Posko Armada Siaga Tangerang Kota (Area Cipondoh & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Cipondoh',
                            'Karawaci',
                            'Ciledug',
                            'Tangerang',
                            'Batuceper',
                            'Benda',
                            'Pinang',
                            'Cibodas',
                            'Larangan',
                        ],
                    ],
                    'tangerang-selatan' => [
                        'name' => 'Tangerang Selatan',
                        'slug' => 'tangerang-selatan',
                        'type' => 'Kota',
                        'province_name' => 'Banten',
                        'province_slug' => 'banten',
                        'posko_address' => 'Posko Armada Siaga Tangerang Selatan (Area BSD & Bintaro)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Serpong',
                            'BSD City',
                            'Bintaro',
                            'Pondok Aren',
                            'Pamulang',
                            'Ciputat',
                            'Setu',
                        ],
                    ],
                ],
            ],
            'jawa-tengah' => [
                'name' => 'Jawa Tengah',
                'slug' => 'jawa-tengah',
                'type' => 'Provinsi',
                'description' => 'Hub operasional Jawa Tengah melayani seluruh area Kota Semarang dan sekitarnya tanpa bongkar keramik.',
                'cities' => [
                    'semarang' => [
                        'name' => 'Kota Semarang',
                        'slug' => 'semarang',
                        'type' => 'Kota',
                        'province_name' => 'Jawa Tengah',
                        'province_slug' => 'jawa-tengah',
                        'posko_address' => 'Posko Armada Siaga Kota Semarang (Area Candisari & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Candisari',
                            'Banyumanik',
                            'Simpang Lima',
                            'Tembalang',
                            'Gajahmungkur',
                            'Semarang Tengah',
                            'Semarang Barat',
                            'Pedurungan',
                            'Ngaliyan',
                        ],
                    ],
                ],
            ],
            'lampung' => [
                'name' => 'Lampung',
                'slug' => 'lampung',
                'type' => 'Provinsi',
                'description' => 'Armada siaga pulau Sumatera berpusat di Bandar Lampung dengan peralatan spiral mekanis lengkap dan garansi 30 hari.',
                'cities' => [
                    'bandar-lampung' => [
                        'name' => 'Bandar Lampung',
                        'slug' => 'bandar-lampung',
                        'type' => 'Kota',
                        'province_name' => 'Lampung',
                        'province_slug' => 'lampung',
                        'posko_address' => 'Posko Armada Siaga Bandar Lampung (Area Kedaton & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Kedaton',
                            'Tanjung Karang Pusat',
                            'Tanjung Karang Timur',
                            'Way Halim',
                            'Teluk Betung',
                            'Sukarame',
                            'Rajabasa',
                            'Kemiling',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Find a province by slug.
     */
    public static function findProvince(string $slug): ?array
    {
        $all = self::all();
        $normalized = Str::slug($slug);
        return $all[$normalized] ?? null;
    }

    /**
     * Find a city by slug across all provinces.
     */
    public static function findCity(string $citySlug): ?array
    {
        $normalized = Str::slug($citySlug);
        $aliases = [
            'jaksel' => 'jakarta-selatan',
            'jaktim' => 'jakarta-timur',
            'jakbar' => 'jakarta-barat',
            'jakut' => 'jakarta-utara',
            'jakpus' => 'jakarta-pusat',
            'tangsel' => 'tangerang-selatan',
            'tangerang' => 'tangerang-kota',
            'depok' => 'depok-cinere',
            'bekasi' => 'bekasi-cikarang',
            'cikarang' => 'bekasi-cikarang',
            'kota-semarang' => 'semarang',
            'kota-bandung' => 'bandung',
        ];

        $targetSlug = $aliases[$normalized] ?? $normalized;

        foreach (self::all() as $province) {
            if (isset($province['cities'][$targetSlug])) {
                return $province['cities'][$targetSlug];
            }
        }

        return null;
    }

    /**
     * Flatten searchable items for Alpine.js Quick Area Finder.
     * Orders: Provinces first, then Cities, then Districts.
     */
    public static function getSearchableItems(): array
    {
        $items = [];

        foreach (self::all() as $provSlug => $prov) {
            $items[] = [
                'type' => 'Provinsi',
                'badge' => 'PROVINSI',
                'name' => 'Provinsi ' . $prov['name'],
                'short_name' => $prov['name'],
                'subtitle' => count($prov['cities']) . ' Kota / Wilayah Siaga',
                'url' => route('area.province', ['province' => $provSlug]),
                'eta' => '24 JAM',
                'search' => strtolower('provinsi ' . $prov['name'] . ' ' . $prov['slug']),
            ];

            foreach ($prov['cities'] as $citySlug => $city) {
                $items[] = [
                    'type' => 'Kota',
                    'badge' => 'KOTA',
                    'name' => $city['name'],
                    'short_name' => $city['name'],
                    'subtitle' => $prov['name'] . ' &bull; ' . count($city['districts']) . ' Kecamatan Siaga',
                    'url' => route('area.city', ['city' => $citySlug]),
                    'eta' => 'Respon Cepat',
                    'search' => strtolower($city['name'] . ' ' . $citySlug),
                ];

                foreach ($city['districts'] as $district) {
                    $districtSlug = Str::slug($district);
                    $items[] = [
                        'type' => 'Kecamatan',
                        'badge' => 'KECAMATAN',
                        'name' => $district,
                        'short_name' => $district,
                        'subtitle' => $city['name'] . ', ' . $prov['name'],
                        'url' => route('area.detail', ['city' => $citySlug, 'district' => $districtSlug]),
                        'eta' => 'Respon Cepat',
                        'search' => strtolower($district),
                    ];
                }
            }
        }

        return $items;
    }
}
