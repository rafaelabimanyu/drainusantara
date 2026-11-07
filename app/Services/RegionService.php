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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                        'posko_address' => 'Posko Armada Siaga Kota Bandung (Area Buahbatu, Dago & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Andir',
                            'Antapani',
                            'Arcamanik',
                            'Astanaanyar',
                            'Babakan Ciparay',
                            'Bandung Kidul',
                            'Bandung Kulon',
                            'Bandung Wetan',
                            'Batununggal',
                            'Bojongloa Kaler',
                            'Bojongloa Kidul',
                            'Buahbatu',
                            'Cibeunying Kaler',
                            'Cibeunying Kidul',
                            'Cibiru',
                            'Cicendo',
                            'Cidadap',
                            'Cinambo',
                            'Coblong',
                            'Dago',
                            'Gedebage',
                            'Kiaracondong',
                            'Lengkong',
                            'Mandalajati',
                            'Panyileukan',
                            'Rancasari',
                            'Regol',
                            'Sukajadi',
                            'Sukasari',
                            'Sumur Bandung',
                            'Ujungberung',
                        ],
                    ],
                    'kabupaten-bandung' => [
                        'name' => 'Kabupaten Bandung',
                        'slug' => 'kabupaten-bandung',
                        'type' => 'Kabupaten',
                        'province_name' => 'Jawa Barat',
                        'province_slug' => 'jawa-barat',
                        'posko_address' => 'Posko Armada Siaga Kabupaten Bandung (Area Soreang, Baleendah, Bojongsoang & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Arjasari',
                            'Baleendah',
                            'Banjaran',
                            'Bojongsoang',
                            'Cangkuang',
                            'Cicalengka',
                            'Cikancung',
                            'Cilengkrang',
                            'Cileunyi',
                            'Cimaung',
                            'Cimenyan',
                            'Ciparay',
                            'Ciwidey',
                            'Dayeuhkolot',
                            'Ibun',
                            'Katapang',
                            'Kertasari',
                            'Kutawaringin',
                            'Majalaya',
                            'Margaasih',
                            'Margahayu',
                            'Nagreg',
                            'Pacet',
                            'Pameungpeuk',
                            'Pangalengan',
                            'Paseh',
                            'Pasirjambu',
                            'Rancabali',
                            'Rancaekek',
                            'Solokanjeruk',
                            'Soreang',
                        ],
                    ],
                    'kota-cimahi' => [
                        'name' => 'Kota Cimahi',
                        'slug' => 'kota-cimahi',
                        'type' => 'Kota',
                        'province_name' => 'Jawa Barat',
                        'province_slug' => 'jawa-barat',
                        'posko_address' => 'Posko Armada Siaga Kota Cimahi (Area Cimahi Tengah & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Cimahi Selatan',
                            'Cimahi Tengah',
                            'Cimahi Utara',
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
                'description' => 'Hub operasional Jawa Tengah melayani seluruh area Kota Semarang, Kabupaten Semarang, dan Kabupaten Demak tanpa bongkar keramik.',
                'cities' => [
                    'semarang' => [
                        'name' => 'Kota Semarang',
                        'slug' => 'semarang',
                        'type' => 'Kota',
                        'province_name' => 'Jawa Tengah',
                        'province_slug' => 'jawa-tengah',
                        'posko_address' => 'Posko Armada Siaga Kota Semarang (Area Candisari, Simpang Lima & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Banyumanik',
                            'Candisari',
                            'Gajahmungkur',
                            'Gayamsari',
                            'Genuk',
                            'Gunungpati',
                            'Mijen',
                            'Ngaliyan',
                            'Pedurungan',
                            'Semarang Barat',
                            'Semarang Selatan',
                            'Semarang Tengah',
                            'Semarang Timur',
                            'Semarang Utara',
                            'Simpang Lima',
                            'Tembalang',
                            'Tugu',
                        ],
                    ],
                    'kabupaten-semarang' => [
                        'name' => 'Kabupaten Semarang',
                        'slug' => 'kabupaten-semarang',
                        'type' => 'Kabupaten',
                        'province_name' => 'Jawa Tengah',
                        'province_slug' => 'jawa-tengah',
                        'posko_address' => 'Posko Armada Siaga Kabupaten Semarang (Area Ungaran, Bawen, Ambarawa & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Ambarawa',
                            'Bancak',
                            'Bandungan',
                            'Banyubiru',
                            'Bawen',
                            'Bergas',
                            'Bringin',
                            'Getasan',
                            'Jambu',
                            'Kaliwungu',
                            'Pabelan',
                            'Pringapus',
                            'Sumowono',
                            'Suruh',
                            'Susukan',
                            'Tengaran',
                            'Tuntang',
                            'Ungaran Barat',
                            'Ungaran Timur',
                        ],
                    ],
                    'demak' => [
                        'name' => 'Kabupaten Demak',
                        'slug' => 'demak',
                        'type' => 'Kabupaten',
                        'province_name' => 'Jawa Tengah',
                        'province_slug' => 'jawa-tengah',
                        'posko_address' => 'Posko Armada Siaga Demak (Area Mranggen, Sayung, Demak Kota & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Bonang',
                            'Demak',
                            'Dempet',
                            'Gajah',
                            'Guntur',
                            'Karang Tengah',
                            'Karanganyar',
                            'Karangawen',
                            'Kebonagung',
                            'Mijen',
                            'Mranggen',
                            'Sayung',
                            'Wedung',
                            'Wonosalam',
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
                        'phone' => config('app.whatsapp_number', '6285609009009'),
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
            'bali' => [
                'name' => 'Bali',
                'slug' => 'bali',
                'type' => 'Provinsi',
                'description' => 'Layanan pembersihan pipa saluran mampet tanpa bongkar di seluruh Provinsi Bali dengan armada posko siaga respon cepat untuk villa, restoran, hotel, dan hunian.',
                'cities' => [
                    'kota-denpasar' => [
                        'name' => 'Kota Denpasar',
                        'slug' => 'kota-denpasar',
                        'type' => 'Kota',
                        'province_name' => 'Bali',
                        'province_slug' => 'bali',
                        'posko_address' => 'Posko Armada Siaga Denpasar (Area Teuku Umar, Sanur & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Sanur',
                            'Denpasar Selatan',
                            'Denpasar Barat',
                            'Denpasar Timur',
                            'Denpasar Utara',
                        ],
                    ],
                    'kabupaten-badung' => [
                        'name' => 'Kabupaten Badung',
                        'slug' => 'kabupaten-badung',
                        'type' => 'Kabupaten',
                        'province_name' => 'Bali',
                        'province_slug' => 'bali',
                        'posko_address' => 'Posko Armada Siaga Badung Selatan (Kawasan Kuta, Sunset Road & Nusa Dua)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Kuta',
                            'Seminyak',
                            'Canggu',
                            'Jimbaran',
                            'Nusa Dua',
                            'Kuta Utara',
                            'Kuta Selatan',
                            'Mengwi',
                            'Abiansemal',
                        ],
                    ],
                    'kabupaten-gianyar' => [
                        'name' => 'Kabupaten Gianyar',
                        'slug' => 'kabupaten-gianyar',
                        'type' => 'Kabupaten',
                        'province_name' => 'Bali',
                        'province_slug' => 'bali',
                        'posko_address' => 'Posko Armada Siaga Gianyar (Area Ubud, Batubulan & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Ubud',
                            'Sukawati',
                            'Blahbatuh',
                            'Gianyar',
                            'Tegallalang',
                        ],
                    ],
                    'kabupaten-tabanan' => [
                        'name' => 'Kabupaten Tabanan',
                        'slug' => 'kabupaten-tabanan',
                        'type' => 'Kabupaten',
                        'province_name' => 'Bali',
                        'province_slug' => 'bali',
                        'posko_address' => 'Posko Armada Siaga Tabanan (Kediri, Kota Tabanan & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Tabanan',
                            'Kediri',
                            'Baturiti',
                            'Marga',
                        ],
                    ],
                    'kabupaten-buleleng' => [
                        'name' => 'Kabupaten Buleleng',
                        'slug' => 'kabupaten-buleleng',
                        'type' => 'Kabupaten',
                        'province_name' => 'Bali',
                        'province_slug' => 'bali',
                        'posko_address' => 'Posko Armada Siaga Bali Utara (Singaraja, Lovina & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Buleleng',
                            'Lovina',
                            'Seririt',
                        ],
                    ],
                    'kabupaten-bangli' => [
                        'name' => 'Kabupaten Bangli',
                        'slug' => 'kabupaten-bangli',
                        'type' => 'Kabupaten',
                        'province_name' => 'Bali',
                        'province_slug' => 'bali',
                        'posko_address' => 'Posko Armada Siaga Bangli (Pusat Kota Bangli & Kintamani)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Bangli',
                            'Kintamani',
                        ],
                    ],
                    'kabupaten-klungkung' => [
                        'name' => 'Kabupaten Klungkung',
                        'slug' => 'kabupaten-klungkung',
                        'type' => 'Kabupaten',
                        'province_name' => 'Bali',
                        'province_slug' => 'bali',
                        'posko_address' => 'Posko Siaga Klungkung (Semarapura & Sekitarnya)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Klungkung',
                            'Dawan',
                            'Nusa Penida',
                        ],
                    ],
                    'kabupaten-karangasem' => [
                        'name' => 'Kabupaten Karangasem',
                        'slug' => 'kabupaten-karangasem',
                        'type' => 'Kabupaten',
                        'province_name' => 'Bali',
                        'province_slug' => 'bali',
                        'posko_address' => 'Posko Armada Siaga Karangasem (Amlapura & Kawasan Pesisir Timur)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Karangasem',
                            'Candidasa',
                            'Padangbai',
                        ],
                    ],
                    'kabupaten-jembrana' => [
                        'name' => 'Kabupaten Jembrana',
                        'slug' => 'kabupaten-jembrana',
                        'type' => 'Kabupaten',
                        'province_name' => 'Bali',
                        'province_slug' => 'bali',
                        'posko_address' => 'Posko Armada Siaga Jembrana (Negara & Jalur Gilimanuk)',
                        'phone' => config('app.whatsapp_number', '6285609009009'),
                        'eta_minutes' => 'Respon Cepat',
                        'districts' => [
                            'Negara',
                            'Gilimanuk',
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function districtType(array $city, string $district): string
    {
        $types = [
            'jakarta-timur' => ['rawamangun' => 'Kelurahan'],
            'jakarta-barat' => ['puri-kembangan' => 'Kawasan'],
            'jakarta-utara' => ['pantai-indah-kapuk' => 'Kawasan', 'sunter' => 'Kawasan', 'pluit' => 'Kelurahan'],
            'bogor' => ['sentul-city' => 'Kawasan', 'kota-bogor' => 'Kota'],
            'depok-cinere' => ['margonda' => 'Kawasan'],
            'bekasi-cikarang' => ['harapan-indah' => 'Kawasan'],
            'bandung' => ['dago' => 'Kelurahan'],
            'tangerang-selatan' => ['bsd-city' => 'Kawasan', 'bintaro' => 'Kawasan'],
            'semarang' => ['simpang-lima' => 'Kawasan'],
            'bandar-lampung' => ['teluk-betung' => 'Kawasan'],
        ];

        $slug = Str::slug($district);
        $known = collect($city['districts'] ?? [])->contains(fn (string $name) => Str::slug($name) === $slug);

        return $types[$city['slug'] ?? ''][$slug] ?? ($known ? 'Kecamatan' : 'Area');
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
            'kab-bandung' => 'kabupaten-bandung',
            'cimahi' => 'kota-cimahi',
            'kab-semarang' => 'kabupaten-semarang',
            'kabupaten-demak' => 'demak',
            'demak-kota' => 'demak',
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
                    'type' => $city['type'],
                    'badge' => strtoupper($city['type']),
                    'name' => $city['name'],
                    'short_name' => $city['name'],
                    'subtitle' => $prov['name'] . ' &bull; ' . count($city['districts']) . ' Area Layanan',
                    'url' => route('area.city', ['city' => $citySlug]),
                    'eta' => 'Respon Cepat',
                    'search' => strtolower($city['name'] . ' ' . $citySlug),
                ];

                foreach ($city['districts'] as $district) {
                    $districtSlug = Str::slug($district);
                    $items[] = [
                        'type' => self::districtType($city, $district),
                        'badge' => strtoupper(self::districtType($city, $district)),
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

    /**
     * Map province slug to official ISO 3166-2 Indonesian subdivision code.
     */
    public static function isoRegion(?string $provinceSlug): string
    {
        return match ($provinceSlug) {
            'dki-jakarta' => 'ID-JK',
            'jawa-barat' => 'ID-JB',
            'banten' => 'ID-BT',
            'jawa-tengah' => 'ID-JT',
            'lampung' => 'ID-LA',
            'bali' => 'ID-BA',
            default => 'ID',
        };
    }

    /**
     * Get official centroid geographic coordinates for a given city and optional district.
     * Always returns valid latitude and longitude for 100% Geo SEO coverage.
     *
     * @return array{lat: float, lng: float}
     */
    public static function centroid(string $citySlug, ?string $districtName = null): array
    {
        $cityCentroids = [
            'jakarta-timur' => ['lat' => -6.2250, 'lng' => 106.9004],
            'jakarta-selatan' => ['lat' => -6.2615, 'lng' => 106.8106],
            'jakarta-barat' => ['lat' => -6.1683, 'lng' => 106.7589],
            'jakarta-utara' => ['lat' => -6.1384, 'lng' => 106.8640],
            'jakarta-pusat' => ['lat' => -6.1865, 'lng' => 106.8341],
            'bogor' => ['lat' => -6.5971, 'lng' => 106.8060],
            'depok-cinere' => ['lat' => -6.4025, 'lng' => 106.7942],
            'bekasi-cikarang' => ['lat' => -6.2383, 'lng' => 106.9756],
            'bandung' => ['lat' => -6.9175, 'lng' => 107.6191],
            'kabupaten-bandung' => ['lat' => -7.0253, 'lng' => 107.5198],
            'kota-cimahi' => ['lat' => -6.8722, 'lng' => 107.5422],
            'tangerang-kota' => ['lat' => -6.1783, 'lng' => 106.6319],
            'tangerang-selatan' => ['lat' => -6.2887, 'lng' => 106.7179],
            'semarang' => ['lat' => -6.9667, 'lng' => 110.4167],
            'kabupaten-semarang' => ['lat' => -7.1396, 'lng' => 110.4039],
            'demak' => ['lat' => -6.8944, 'lng' => 110.6386],
            'bandar-lampung' => ['lat' => -5.4500, 'lng' => 105.2667],
            'kota-denpasar' => ['lat' => -8.6705, 'lng' => 115.2126],
            'kabupaten-badung' => ['lat' => -8.5833, 'lng' => 115.1833],
            'kabupaten-gianyar' => ['lat' => -8.5433, 'lng' => 115.3267],
            'kabupaten-tabanan' => ['lat' => -8.5394, 'lng' => 115.1239],
            'kabupaten-buleleng' => ['lat' => -8.1120, 'lng' => 115.0882],
            'kabupaten-bangli' => ['lat' => -8.4542, 'lng' => 115.3547],
            'kabupaten-klungkung' => ['lat' => -8.5367, 'lng' => 115.4050],
            'kabupaten-karangasem' => ['lat' => -8.4483, 'lng' => 115.6133],
            'kabupaten-jembrana' => ['lat' => -8.3583, 'lng' => 114.6500],
        ];

        $districtCentroids = [
            'tebet' => ['lat' => -6.2297, 'lng' => 106.8553],
            'cilandak' => ['lat' => -6.2941, 'lng' => 106.7997],
            'kebayoran-baru' => ['lat' => -6.2435, 'lng' => 106.8041],
            'kebayoran-lama' => ['lat' => -6.2577, 'lng' => 106.7758],
            'mampang-prapatan' => ['lat' => -6.2541, 'lng' => 106.8256],
            'pancoran' => ['lat' => -6.2514, 'lng' => 106.8483],
            'pasar-minggu' => ['lat' => -6.2858, 'lng' => 106.8378],
            'pesanggrahan' => ['lat' => -6.2483, 'lng' => 106.7611],
            'setiabudi' => ['lat' => -6.2117, 'lng' => 106.8292],
            'jagakarsa' => ['lat' => -6.3314, 'lng' => 106.8236],
            'ciracas' => ['lat' => -6.3317, 'lng' => 106.8778],
            'duren-sawit' => ['lat' => -6.2274, 'lng' => 106.9189],
            'cakung' => ['lat' => -6.1917, 'lng' => 106.9450],
            'rawamangun' => ['lat' => -6.1964, 'lng' => 106.8872],
            'jatinegara' => ['lat' => -6.2297, 'lng' => 106.8731],
            'kramat-jati' => ['lat' => -6.2731, 'lng' => 106.8681],
            'matraman' => ['lat' => -6.2056, 'lng' => 106.8583],
            'pasar-rebo' => ['lat' => -6.3214, 'lng' => 106.8617],
            'pulo-gadung' => ['lat' => -6.1906, 'lng' => 106.8964],
            'cipayung' => ['lat' => -6.3208, 'lng' => 106.9022],
            'makasar' => ['lat' => -6.2742, 'lng' => 106.8833],
            'kebon-jeruk' => ['lat' => -6.1951, 'lng' => 106.7722],
            'puri-kembangan' => ['lat' => -6.1883, 'lng' => 106.7450],
            'kembangan' => ['lat' => -6.1883, 'lng' => 106.7450],
            'grogol-petamburan' => ['lat' => -6.1667, 'lng' => 106.7867],
            'palmerah' => ['lat' => -6.1950, 'lng' => 106.7933],
            'cengkareng' => ['lat' => -6.1517, 'lng' => 106.7317],
            'kalideres' => ['lat' => -6.1483, 'lng' => 106.7033],
            'tambora' => ['lat' => -6.1467, 'lng' => 106.8050],
            'taman-sari' => ['lat' => -6.1433, 'lng' => 106.8183],
            'kelapa-gading' => ['lat' => -6.1627, 'lng' => 106.9061],
            'pantai-indah-kapuk' => ['lat' => -6.1111, 'lng' => 106.7408],
            'sunter' => ['lat' => -6.1417, 'lng' => 106.8750],
            'pluit' => ['lat' => -6.1217, 'lng' => 106.7917],
            'tanjung-priok' => ['lat' => -6.1214, 'lng' => 106.8825],
            'penjaringan' => ['lat' => -6.1283, 'lng' => 106.7850],
            'pademangan' => ['lat' => -6.1367, 'lng' => 106.8400],
            'koja' => ['lat' => -6.1283, 'lng' => 106.9083],
            'cilincing' => ['lat' => -6.1250, 'lng' => 106.9400],
            'kemayoran' => ['lat' => -6.1583, 'lng' => 106.8583],
            'cempaka-putih' => ['lat' => -6.1800, 'lng' => 106.8700],
            'menteng' => ['lat' => -6.1983, 'lng' => 106.8333],
            'gambir' => ['lat' => -6.1750, 'lng' => 106.8250],
            'sawah-besar' => ['lat' => -6.1550, 'lng' => 106.8300],
            'senen' => ['lat' => -6.1867, 'lng' => 106.8450],
            'tanah-abang' => ['lat' => -6.1917, 'lng' => 106.8167],
            'johar-baru' => ['lat' => -6.1850, 'lng' => 106.8550],
            'cibinong' => ['lat' => -6.4817, 'lng' => 106.8542],
            'sentul-city' => ['lat' => -6.5583, 'lng' => 106.8833],
            'kota-bogor' => ['lat' => -6.5971, 'lng' => 106.8060],
            'bojonggede' => ['lat' => -6.4950, 'lng' => 106.7983],
            'gunung-putri' => ['lat' => -6.4467, 'lng' => 106.9200],
            'cileungsi' => ['lat' => -6.4167, 'lng' => 106.9667],
            'sukaraja' => ['lat' => -6.5667, 'lng' => 106.8500],
            'babakan-madang' => ['lat' => -6.5667, 'lng' => 106.9000],
            'cinere' => ['lat' => -6.3250, 'lng' => 106.7833],
            'margonda' => ['lat' => -6.3725, 'lng' => 106.8322],
            'sawangan' => ['lat' => -6.4167, 'lng' => 106.7667],
            'beji' => ['lat' => -6.3717, 'lng' => 106.8217],
            'pancoran-mas' => ['lat' => -6.3983, 'lng' => 106.8117],
            'sukmajaya' => ['lat' => -6.4017, 'lng' => 106.8450],
            'cimanggis' => ['lat' => -6.3667, 'lng' => 106.8750],
            'tapos' => ['lat' => -6.4250, 'lng' => 106.8833],
            'cikarang-selatan' => ['lat' => -6.3417, 'lng' => 107.1333],
            'cikarang-utara' => ['lat' => -6.2667, 'lng' => 107.1667],
            'bekasi-barat' => ['lat' => -6.2367, 'lng' => 106.9800],
            'bekasi-timur' => ['lat' => -6.2550, 'lng' => 107.0150],
            'bekasi-selatan' => ['lat' => -6.2617, 'lng' => 106.9867],
            'bekasi-utara' => ['lat' => -6.2083, 'lng' => 107.0083],
            'tambun-selatan' => ['lat' => -6.2650, 'lng' => 107.0583],
            'harapan-indah' => ['lat' => -6.1833, 'lng' => 106.9833],
            'cibitung' => ['lat' => -6.2667, 'lng' => 107.1000],
            'cipondoh' => ['lat' => -6.1833, 'lng' => 106.6833],
            'karawaci' => ['lat' => -6.2167, 'lng' => 106.6000],
            'ciledug' => ['lat' => -6.2283, 'lng' => 106.7117],
            'tangerang' => ['lat' => -6.1783, 'lng' => 106.6319],
            'batuceper' => ['lat' => -6.1667, 'lng' => 106.6667],
            'benda' => ['lat' => -6.1250, 'lng' => 106.6833],
            'pinang' => ['lat' => -6.2250, 'lng' => 106.6833],
            'cibodas' => ['lat' => -6.2000, 'lng' => 106.5833],
            'larangan' => ['lat' => -6.2417, 'lng' => 106.7333],
            'serpong' => ['lat' => -6.3167, 'lng' => 106.6667],
            'bsd-city' => ['lat' => -6.3017, 'lng' => 106.6533],
            'bintaro' => ['lat' => -6.2833, 'lng' => 106.7167],
            'pondok-aren' => ['lat' => -6.2750, 'lng' => 106.7083],
            'pamulang' => ['lat' => -6.3417, 'lng' => 106.7333],
            'ciputat' => ['lat' => -6.3117, 'lng' => 106.7483],
            'setu' => ['lat' => -6.3483, 'lng' => 106.6833],
            'candisari' => ['lat' => -7.0167, 'lng' => 110.4333],
            'banyumanik' => ['lat' => -7.0667, 'lng' => 110.4167],
            'simpang-lima' => ['lat' => -6.9903, 'lng' => 110.4228],
            'tembalang' => ['lat' => -7.0500, 'lng' => 110.4500],
            'gajahmungkur' => ['lat' => -7.0117, 'lng' => 110.4117],
            'semarang-tengah' => ['lat' => -6.9800, 'lng' => 110.4200],
            'semarang-barat' => ['lat' => -6.9833, 'lng' => 110.3833],
            'pedurungan' => ['lat' => -7.0083, 'lng' => 110.4750],
            'ngaliyan' => ['lat' => -7.0000, 'lng' => 110.3333],
            'kedaton' => ['lat' => -5.3833, 'lng' => 105.2500],
            'tanjung-karang-pusat' => ['lat' => -5.4167, 'lng' => 105.2583],
            'tanjung-karang-timur' => ['lat' => -5.4117, 'lng' => 105.2750],
            'way-halim' => ['lat' => -5.3883, 'lng' => 105.2833],
            'teluk-betung' => ['lat' => -5.4500, 'lng' => 105.2667],
            'sukarame' => ['lat' => -5.3833, 'lng' => 105.3000],
            'rajabasa' => ['lat' => -5.3583, 'lng' => 105.2333],
            'kemiling' => ['lat' => -5.4000, 'lng' => 105.2167],
            'soreang' => ['lat' => -7.0253, 'lng' => 107.5198],
            'baleendah' => ['lat' => -6.9944, 'lng' => 107.6322],
            'bojongsoang' => ['lat' => -6.9800, 'lng' => 107.6400],
            'cileunyi' => ['lat' => -6.9389, 'lng' => 107.7444],
            'cimahi-selatan' => ['lat' => -6.8900, 'lng' => 107.5300],
            'cimahi-tengah' => ['lat' => -6.8722, 'lng' => 107.5422],
            'cimahi-utara' => ['lat' => -6.8500, 'lng' => 107.5500],
            'ungaran-barat' => ['lat' => -7.1396, 'lng' => 110.4039],
            'ungaran-timur' => ['lat' => -7.1300, 'lng' => 110.4200],
            'ambarawa' => ['lat' => -7.2600, 'lng' => 110.4000],
            'bawen' => ['lat' => -7.2500, 'lng' => 110.4300],
            'mranggen' => ['lat' => -7.0250, 'lng' => 110.5100],
            'sayung' => ['lat' => -6.9200, 'lng' => 110.5000],
            'bonang' => ['lat' => -6.8333, 'lng' => 110.6167],
            // Bali Districts
            'sanur' => ['lat' => -8.6882, 'lng' => 115.2625],
            'denpasar-selatan' => ['lat' => -8.6980, 'lng' => 115.2280],
            'denpasar-barat' => ['lat' => -8.6650, 'lng' => 115.1950],
            'denpasar-timur' => ['lat' => -8.6500, 'lng' => 115.2400],
            'denpasar-utara' => ['lat' => -8.6250, 'lng' => 115.2150],
            'kuta' => ['lat' => -8.7275, 'lng' => 115.1726],
            'seminyak' => ['lat' => -8.6894, 'lng' => 115.1583],
            'canggu' => ['lat' => -8.6478, 'lng' => 115.1385],
            'jimbaran' => ['lat' => -8.7712, 'lng' => 115.1687],
            'nusa-dua' => ['lat' => -8.7963, 'lng' => 115.2253],
            'kuta-utara' => ['lat' => -8.6400, 'lng' => 115.1600],
            'kuta-selatan' => ['lat' => -8.8100, 'lng' => 115.1650],
            'mengwi' => ['lat' => -8.5450, 'lng' => 115.1700],
            'abiansemal' => ['lat' => -8.5300, 'lng' => 115.2100],
            'ubud' => ['lat' => -8.5069, 'lng' => 115.2625],
            'sukawati' => ['lat' => -8.5950, 'lng' => 115.2817],
            'blahbatuh' => ['lat' => -8.5700, 'lng' => 115.3000],
            'gianyar' => ['lat' => -8.5433, 'lng' => 115.3267],
            'tegallalang' => ['lat' => -8.4350, 'lng' => 115.2800],
            'tabanan' => ['lat' => -8.5394, 'lng' => 115.1239],
            'kediri' => ['lat' => -8.5567, 'lng' => 115.1483],
            'baturiti' => ['lat' => -8.3267, 'lng' => 115.1883],
            'marga' => ['lat' => -8.4733, 'lng' => 115.1950],
            'buleleng' => ['lat' => -8.1120, 'lng' => 115.0882],
            'lovina' => ['lat' => -8.1567, 'lng' => 115.0250],
            'seririt' => ['lat' => -8.1967, 'lng' => 114.9350],
            'bangli' => ['lat' => -8.4542, 'lng' => 115.3547],
            'kintamani' => ['lat' => -8.2450, 'lng' => 115.3283],
            // Kota Bandung Districts
            'dago' => ['lat' => -6.8797, 'lng' => 107.6186],
            'buahbatu' => ['lat' => -6.9533, 'lng' => 107.6433],
            'sukajadi' => ['lat' => -6.8850, 'lng' => 107.5933],
            'antapani' => ['lat' => -6.9150, 'lng' => 107.6600],
            'arcamanik' => ['lat' => -6.9200, 'lng' => 107.6767],
            'cibiru' => ['lat' => -6.9250, 'lng' => 107.7167],
            'lengkong' => ['lat' => -6.9350, 'lng' => 107.6200],
            'regol' => ['lat' => -6.9367, 'lng' => 107.6083],
            'batununggal' => ['lat' => -6.9450, 'lng' => 107.6283],
            'sukasari' => ['lat' => -6.8700, 'lng' => 107.5883],
            'coblong' => ['lat' => -6.8833, 'lng' => 107.6167],
            'andir' => ['lat' => -6.9133, 'lng' => 107.5850],
            'cicendo' => ['lat' => -6.9033, 'lng' => 107.5933],
            'cidadap' => ['lat' => -6.8600, 'lng' => 107.5983],
            'cibeunying-kaler' => ['lat' => -6.8917, 'lng' => 107.6300],
            'cibeunying-kidul' => ['lat' => -6.9033, 'lng' => 107.6400],
            'sumur-bandung' => ['lat' => -6.9150, 'lng' => 107.6133],
            'bandung-wetan' => ['lat' => -6.9050, 'lng' => 107.6167],
            'bandung-kulon' => ['lat' => -6.9283, 'lng' => 107.5700],
            'bandung-kidul' => ['lat' => -6.9600, 'lng' => 107.6300],
            'astanaanyar' => ['lat' => -6.9367, 'lng' => 107.6000],
            'babakan-ciparay' => ['lat' => -6.9383, 'lng' => 107.5800],
            'bojongloa-kaler' => ['lat' => -6.9300, 'lng' => 107.5900],
            'bojongloa-kidul' => ['lat' => -6.9500, 'lng' => 107.5950],
            'cinambo' => ['lat' => -6.9283, 'lng' => 107.6900],
            'gedebage' => ['lat' => -6.9583, 'lng' => 107.6850],
            'kiaracondong' => ['lat' => -6.9317, 'lng' => 107.6467],
            'mandalajati' => ['lat' => -6.9067, 'lng' => 107.6700],
            'panyileukan' => ['lat' => -6.9350, 'lng' => 107.7050],
            'rancasari' => ['lat' => -6.9550, 'lng' => 107.6650],
            'ujungberung' => ['lat' => -6.9150, 'lng' => 107.6983],
        ];

        if ($districtName !== null) {
            $districtSlug = Str::slug($districtName);
            if (isset($districtCentroids[$districtSlug])) {
                return $districtCentroids[$districtSlug];
            }
        }

        if (isset($cityCentroids[$citySlug])) {
            return $cityCentroids[$citySlug];
        }

        return ['lat' => -6.2250, 'lng' => 106.9004]; // Default to Jakarta pusat/timur hub
    }

    /**
     * Sub-regions clustering for Bandung Raya.
     *
     * @return array<string, array<int, string>>
     */
    public static function bandungSubregions(): array
    {
        return [
            'Bandung Utara' => ['Coblong', 'Sukajadi', 'Sukasari', 'Cidadap', 'Cibeunying Kaler', 'Dago'],
            'Bandung Barat' => ['Cicendo', 'Andir', 'Bandung Kulon', 'Babakan Ciparay', 'Bojongloa Kaler'],
            'Bandung Tengah' => ['Sumur Bandung', 'Bandung Wetan', 'Regol', 'Lengkong', 'Astanaanyar', 'Bojongloa Kidul'],
            'Bandung Timur' => ['Antapani', 'Arcamanik', 'Cibiru', 'Cinambo', 'Gedebage', 'Kiaracondong', 'Mandalajati', 'Panyileukan', 'Rancasari', 'Ujungberung'],
        ];
    }
}
