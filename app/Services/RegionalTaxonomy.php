<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class RegionalTaxonomy
{
    /**
     * Get comprehensive local characteristics, pipe challenges, and prominent landmarks for a city/district.
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
    public static function getProfile(string $citySlug, ?string $district = null, ?string $cityName = null): array
    {
        $cleanDistrict = self::normalizeDistrict($district);
        $cleanCity = self::normalizeCity($citySlug, $cityName);
        $zone = self::resolveZone($citySlug);

        $profile = match ($zone) {
            'semarang_pantura' => self::semarangPanturaProfile($citySlug, $cleanDistrict, $cleanCity),
            'bandung_highland' => self::bandungHighlandProfile($citySlug, $cleanDistrict, $cleanCity),
            'bali_hospitality' => self::baliHospitalityProfile($citySlug, $cleanDistrict, $cleanCity),
            'lampung_commercial' => self::lampungCommercialProfile($citySlug, $cleanDistrict, $cleanCity),
            'bodetabek_cluster' => self::bodetabekClusterProfile($citySlug, $cleanDistrict, $cleanCity),
            default => self::jakartaMetropolitanProfile($citySlug, $cleanDistrict, $cleanCity),
        };

        if ($cleanDistrict) {
            $hyper = HyperLocalTaxonomy::getDistrictProfile($citySlug, $cleanDistrict, $cleanCity);
            $profile['presence_prose'] = "Drainusantara hadir secara resmi di {$cleanDistrict}, {$cleanCity} dengan posko armada respons cepat. {$hyper['problem_desc']}";
            $profile['prominent_areas'] = $hyper['landmarks'];
            $profile['challenges'] = $hyper['problem_desc'];
            $profile['technical_solution'] = $hyper['solution_desc'];
            $profile['local_faqs'] = $hyper['faqs'];
        }

        return self::sanitizeRecursive($profile, $cleanCity, $cleanDistrict);
    }

    /**
     * Get deep localized analysis cards and service standards for a city or district.
     *
     * @return array{
     *     sub_zone: string,
     *     landmarks: array<int, string>,
     *     analysis_cards: array<int, array{title: string, badge: string, icon: string, description: string, detail: string}>,
     *     service_specs: array<int, array{label: string, value: string, badge?: string}>
     * }
     */
    public static function getDistrictAnalysis(string $citySlug, ?string $district = null, ?string $cityName = null): array
    {
        $cleanDistrict = self::normalizeDistrict($district);
        $cleanCity = self::normalizeCity($citySlug, $cityName);
        $loc = $cleanDistrict ? "{$cleanDistrict}, {$cleanCity}" : $cleanCity;
        $zone = self::resolveZone($citySlug);

        $districtSlug = $cleanDistrict ? Str::slug($cleanDistrict) : '';

        // Deteksi sub-zona spesifik
        $subZoneData = self::resolveSubZone($citySlug, $districtSlug, $cleanCity, $cleanDistrict);

        $cards = [
            [
                'title' => "Karakter Saluran & Pemicu Mampet di {$loc}",
                'badge' => 'ANALISIS JALUR PIPA',
                'icon' => 'warning',
                'description' => $subZoneData['problem_desc'],
                'detail' => $subZoneData['problem_detail'],
            ],
            [
                'title' => "Rute Siaga & Respon Armada ke {$loc}",
                'badge' => 'RESPON CEPAT ARMADA',
                'icon' => 'truck',
                'description' => $subZoneData['dispatch_desc'],
                'detail' => $subZoneData['dispatch_detail'],
            ],
            [
                'title' => "Metode Spiral Baja Non-Destruktif & CCTV IP68",
                'badge' => 'SOLUSI 100% BEBAS BONGKAR',
                'icon' => 'tool',
                'description' => $subZoneData['solution_desc'],
                'detail' => $subZoneData['solution_detail'],
            ],
        ];

        $specs = [
            [
                'label' => "Estimasi Waktu Tiba di {$loc}",
                'value' => '30 – 45 Menit (Langsung Meluncur Pasca Konfirmasi WA)',
                'badge' => 'Siaga 24 Jam Nonstop',
            ],
            [
                'label' => "Unit Mesin Siaga di Armada",
                'value' => 'Mesin Spiral Rotary Ridgid 400 RPM & Kamera CCTV IP68 30M',
                'badge' => 'Tanpa Bongkar Keramik',
            ],
            [
                'label' => "Kategori Bangunan Dominan",
                'value' => $subZoneData['dominant_buildings'],
                'badge' => 'Rumah • Ruko • Resto',
            ],
            [
                'label' => "Ketentuan Biaya & Garansi Resmi",
                'value' => 'Tarif Transparan Mulai Rp 400rb • Jaminan No Cure No Pay & Garansi 30 Hari',
                'badge' => 'Nota Tertulis Resmi',
            ],
        ];

        $result = [
            'sub_zone' => $subZoneData['zone_title'],
            'landmarks' => $subZoneData['landmarks'],
            'analysis_cards' => $cards,
            'service_specs' => $specs,
        ];

        return self::sanitizeRecursive($result, $cleanCity, $cleanDistrict);
    }

    /**
     * Categorize city slug into regional zone.
     */
    public static function resolveZone(string $citySlug): string
    {
        return match ($citySlug) {
            'semarang', 'kabupaten-semarang', 'demak' => 'semarang_pantura',
            'bandung', 'kabupaten-bandung', 'kota-cimahi' => 'bandung_highland',
            'kota-denpasar', 'badung', 'gianyar', 'tabanan', 'buleleng', 'bangli' => 'bali_hospitality',
            'bandar-lampung' => 'lampung_commercial',
            'depok-cinere', 'bogor', 'tangerang-kota', 'tangerang-selatan', 'bekasi-cikarang' => 'bodetabek_cluster',
            default => 'jakarta_metropolitan',
        };
    }

    /**
     * Normalize district string removing internal placeholders.
     */
    public static function normalizeDistrict(?string $district): ?string
    {
        if (empty($district)) {
            return null;
        }

        $trimmed = trim($district);
        if (in_array(strtoupper($trimmed), ['[KOTA]', '[PROVINSI]', '[KECAMATAN]', 'KOTA', 'PROVINSI'], true)) {
            return null;
        }

        return $trimmed;
    }

    /**
     * Normalize city name removing internal placeholders.
     */
    public static function normalizeCity(string $citySlug, ?string $cityName = null): string
    {
        if (! empty($cityName)) {
            $cleaned = trim(str_ireplace(['[KOTA]', '[PROVINSI]', '[KECAMATAN]'], '', $cityName));
            if (! empty($cleaned)) {
                return $cleaned;
            }
        }

        return match ($citySlug) {
            'semarang' => 'Kota Semarang',
            'kabupaten-semarang' => 'Kabupaten Semarang',
            'demak' => 'Kabupaten Demak',
            'bandung' => 'Kota Bandung',
            'kabupaten-bandung' => 'Kabupaten Bandung',
            'kota-cimahi' => 'Kota Cimahi',
            'depok-cinere' => 'Depok & Cinere',
            'bekasi-cikarang' => 'Bekasi & Cikarang',
            'tangerang-kota' => 'Tangerang Kota',
            'tangerang-selatan' => 'Tangerang Selatan',
            'bogor' => 'Bogor',
            'bandar-lampung' => 'Bandar Lampung',
            'kota-denpasar' => 'Denpasar Bali',
            'badung' => 'Badung Bali',
            'gianyar' => 'Gianyar Bali',
            'tabanan' => 'Tabanan Bali',
            default => ucwords(str_replace('-', ' ', $citySlug)),
        };
    }

    /**
     * Recursively sanitize strings from any leftover placeholder artifacts.
     */
    public static function sanitizeRecursive(mixed $data, string $cityName, ?string $districtName = null): mixed
    {
        if (is_string($data)) {
            $dist = $districtName ?: $cityName;
            $search = [
                '[KOTA]', '[kota]', '{kota}',
                '[KECAMATAN]', '[kecamatan]', '{kecamatan}',
                '[PROVINSI]', '[provinsi]', '{provinsi}',
                'Pelancaran Pelancaran', 'pelancaran pelancaran',
                'Studi Kasus: Pelancaran Pelancaran',
            ];
            $replace = [
                $cityName, $cityName, $cityName,
                $dist, $dist, $dist,
                $cityName, $cityName, $cityName,
                'Pelancaran', 'pelancaran',
                'Studi Kasus: Pelancaran',
            ];

            return str_replace($search, $replace, $data);
        }

        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = self::sanitizeRecursive($v, $cityName, $districtName);
            }
        }

        return $data;
    }

    /**
     * Profile for Semarang & Demak (Pantura, coastal rob/sediment, lime & industrial).
     */
    private static function semarangPanturaProfile(string $citySlug, ?string $district, string $cityName): array
    {
        $loc = $district ? "{$district}, {$cityName}" : $cityName;
        $isDemak = str_contains($citySlug, 'demak');
        $isKab = str_contains($citySlug, 'kabupaten-semarang');

        $prominent = $isDemak
            ? ['Sayung', 'Mranggen', 'Karangawen', 'Demak Kota', 'Jalur Pantura Semarang-Demak', 'Kawasan Industri Sayung']
            : ($isKab
                ? ['Ungaran Barat', 'Ungaran Timur', 'Ambarawa', 'Bawen', 'Kawasan Industri Bergas', 'Jalan Raya Solo-Semarang']
                : ['Simpang Lima', 'Kawasan Industri Genuk', 'Tugu Wijayakusuma', 'Gombel & Candisari', 'Banyumanik', 'Tembalang Undip', 'Krapyak & Siliwangi']);

        return [
            'zone' => 'semarang_pantura',
            'zone_name' => "Kawasan Pesisir Pantura, Perbukitan & Industri {$cityName}",
            'characteristics' => "Kawasan strategis jalur Pantura Jawa Tengah dengan topografi pesisir berair rob di sisi utara serta perbukitan terjal di sisi selatan {$cityName}.",
            'challenges' => "Saluran pipa di kawasan {$loc} kerap menghadapi endapan lumpur intrusi rob pesisir, residu pasir dak beton, dan kerak kapur air tanah yang mengeras di dinding pipa PVC.",
            'building_focus' => "Perumahan tapak, ruko arteri Pantura, pabrik manufaktur kawasan industri, dan hunian klaster perbukitan di {$cityName}.",
            'technical_solution' => "Unit mesin spiral rotary Ridgid heavy-duty dilengkapi mata pengeruk cakar baja fleksibel yang melumat tumpukan lumpur, kerak kapur, dan lemak beku tanpa membongkar keramik lantai hunian.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Drainusantara hadir secara resmi melayani kawasan {$loc} dengan posko armada respons cepat. Menjawab tantangan sanitasi pipa khas Pantura seperti sedimentasi lumpur rob, kerak kapur air tanah, dan tumpahan lemak dapur ruko F&B secara non-destruktif dan higienis.",
            'advantages_focus' => "Penetrasi spiral baja torsi tinggi melancarkan endapan lumpur rob dan sedimen kapur hingga jarak 30 meter tanpa risiko pipa PVC retak.",
            'local_faqs' => [
                [
                    'question' => "Apakah Drainusantara dapat menangani pipa mampet akibat endapan pasir lumpur atau air rob di {$loc}?",
                    'answer' => "Bisa dan sangat sering kami tangani. Mesin spiral rotary kami menggunakan mata pembersih bulb auger khusus yang mampu memecah sedimentasi pasir, endapan lumpur banjir/rob, serta kerak kapur air tanah tanpa perlu membongkar cor lantai.",
                ],
                [
                    'question' => "Berapa lama estimasi teknisi tiba di kawasan {$loc}?",
                    'answer' => "Teknisi armada posko {$cityName} bergerak cepat dari titik siaga terdekat. Estimasi kedatangan 30-45 menit tergantung kondisi lalu lintas jalur utama.",
                ],
                [
                    'question' => "Apakah melayani panggilan darurat untuk pabrik kawasan industri dan ruko di {$loc}?",
                    'answer' => "Ya, kami melayani hunian pribadi maupun properti komersial, pabrik, gudang, dan ruko F&B dengan invoice resmi dan dukungan dokumen administrasi lengkap.",
                ],
            ],
        ];
    }

    /**
     * Profile for Bandung Raya & Cimahi (Highland, cool climate grease freeze, contoured terrain).
     */
    private static function bandungHighlandProfile(string $citySlug, ?string $district, string $cityName): array
    {
        $loc = $district ? "{$district}, {$cityName}" : $cityName;
        $prominent = ['Dago & Setiabudi', 'Riau & Trunojoyo', 'Buahbatu & Batununggal', 'Sukajadi & PVJ', 'Cimahi Tengah', 'Antapani & Arcamanik', 'Kopo & Bojongsoang'];

        return [
            'zone' => 'bandung_highland',
            'zone_name' => "Kawasan Dataran Tinggi, Kafe Wisata & Kontur Berbukit {$cityName}",
            'characteristics' => "Topografi cekungan dataran tinggi berhawa sejuk dengan sentra kuliner kafe/resto modern dan hunian berkontur tanah miring di {$cityName}.",
            'challenges' => "Suhu udara dingin di {$cityName} mempercepat proses pembekuan minyak nabati dan lemak hewani di dalam saluran wastafel dapur, membentuk kerak padat menyerupai lilin di sambungan pipa berbelok.",
            'building_focus' => "Kafe & restoran kuliner, ruko factory outlet, townhouse residensial lereng bukit, dan perumahan heritage di {$cityName}.",
            'technical_solution' => "Mata spiral rotary penembus lemak berputar 400 RPM meliuk melewati sambungan siku (elbow) pipa tanpa tekanan kimia berbahaya yang dapat memecahkan pipa di cuaca dingin.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Armada resmi Drainusantara siaga melayani area {$loc}. Mengatasi problem khas perpipaan {$cityName} seperti pembekuan minyak dapur akibat suhu dingin, sumbatan talang air hujan berlumut, dan pipa mampet di kontur tanah berundak tanpa merusak keramik.",
            'advantages_focus' => "Kabel spiral baja fleksibel menembus leher angsa dan belokan elbow tajam pada instalasi pipa bangunan berundak khas {$cityName}.",
            'local_faqs' => [
                [
                    'question' => "Mengapa pipa wastafel dapur di area {$loc} lebih sering mampet membeku?",
                    'answer' => "Suhu udara dingin khas Bandung mempercepat koagulasi (pembekuan) lemak masakan dan sisa minyak menjadi gumpalan lilin padat di leher angsa sifon. Mesin spiral rotary kami melumat kerak lilin tersebut hingga bersih tuntas tanpa zat kimia.",
                ],
                [
                    'question' => "Apakah pengerjaan di {$loc} aman untuk pipa rumah berbukit atau ruko heritage?",
                    'answer' => "Sangat aman. Metode mekanis non-destruktif kami beroperasi dari lubang pipa eksisting tanpa palu, pahat, atau pembongkaran tegel/keramik heritage.",
                ],
                [
                    'question' => "Apakah melayani grease trap kafe dan restoran di kawasan kuliner {$loc}?",
                    'answer' => "Ya, kami berpengalaman melayani puluhan kafe, kedai kopi, dan restoran di {$cityName} dengan penanganan cepat sebelum jam operasional dimulai.",
                ],
            ],
        ];
    }

    /**
     * Profile for Bali (Denpasar, Badung, Gianyar: Hospitality, villas, beach sand & resort standards).
     */
    private static function baliHospitalityProfile(string $citySlug, ?string $district, string $cityName): array
    {
        $loc = $district ? "{$district}, {$cityName}" : $cityName;
        $prominent = ['Kuta & Seminyak', 'Canggu & Berawa', 'Sanur & Denpasar Selatan', 'Ubud & Tegallalang', 'Jimbaran & Nusa Dua', 'Uluwatu & Bukit'];

        return [
            'zone' => 'bali_hospitality',
            'zone_name' => "Kawasan Pariwisata, Villa & Residensial Pulau Dewata {$cityName}",
            'characteristics' => "Kawasan properti pariwisata bertaraf internasional dengan villa privat, resort tepi pantai, kafe, beach club, serta pemukiman warga di {$cityName}.",
            'challenges' => "Tingginya volume pembuangan air di villa/resort, sumbatan pasir pantai pada floor drain kamar bilas outdoor, akar tanaman tropis yang merambat ke sambungan pipa taman, dan residu lemak dapur komersial.",
            'building_focus' => "Villa privat, butik hotel, restoran & kafe internasional, resort pantai, serta hunian residensial di {$cityName}.",
            'technical_solution' => "Teknologi spiral baja low-noise dengan protokol sanitasi higienis tinggi, tanpa bau menyengat, serta inspeksi kamera CCTV pipa IP68 untuk memetakan jalur tanpa merusak lantai batu alam/teraso.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Drainusantara hadir di area {$loc} dengan standar pelayanan premium ramah industri pariwisata. Mengutamakan ketepatan respon darurat 24 jam, pengerjaan senyap dan bersih tanpa membongkar marmer atau lantai batu alam villa Anda.",
            'advantages_focus' => "Protokol pengerjaan higienis, senyap, bebas bahan kimia bau, dan aman untuk material lantai premium villa/resort di Bali.",
            'local_faqs' => [
                [
                    'question' => "Apakah pengerjaan pipa mampet di {$loc} aman dan tidak mengganggu tamu villa/resort?",
                    'answer' => "Pengerjaan kami menggunakan unit mesin listrik modern yang relatif senyap, higienis, dan tanpa bahan kimia berbau menyengat. Teknisi wajib mengenakan cover shoes dan menjaga ketenangan privasi tamu villa.",
                ],
                [
                    'question' => "Apakah bisa menangani floor drain kamar bilas outdoor yang tersumbat pasir pantai di {$loc}?",
                    'answer' => "Bisa. Pasir pantai yang mengendap di pipa pembuangan ditarik dan didorong keluar menggunakan kepala spiral baja khusus hingga aliran air kembali lancar plong.",
                ],
                [
                    'question' => "Apakah tersedia invoice resmi untuk pengelola villa, hotel, dan restoran di {$loc}?",
                    'answer' => "Ya, kami menyediakan nota digital resmi bergaransi 30 hari serta invoice korporat di bawah PT Jawa Jaya Rooter untuk keperluan pembukuan manajemen properti.",
                ],
            ],
        ];
    }

    /**
     * Profile for Bandar Lampung (Gateway to Sumatra, commercial trade & hilly/coastal corridors).
     */
    private static function lampungCommercialProfile(string $citySlug, ?string $district, string $cityName): array
    {
        $loc = $district ? "{$district}, {$cityName}" : $cityName;
        $prominent = ['Tanjung Karang Pusat', 'Kedaton & Labuhan Ratu', 'Way Halim & Sukarame', 'Teluk Betung', 'Kemiling', 'Rajabasa & Arteri Soekarno Hatta'];

        return [
            'zone' => 'lampung_commercial',
            'zone_name' => "Gerbang Niaga Sumatera, Koridor Arteri & Pemukiman {$cityName}",
            'characteristics' => "Pusat aktivitas perdagangan dan gerbang logistik Sumatera dengan kontur perbukitan dan kawasan pemukiman pesisir teluk {$cityName}.",
            'challenges' => "Akumulasi kerak kapur dari air tanah, endapan lemak makanan bersantan pada pipa dapur, serta sumbatan bak kontrol utama rumah dan ruko di jalur utama {$cityName}.",
            'building_focus' => "Ruko pertokoan jalan protokol, perumahan tapak, restoran F&B, dan fasilitas umum di {$cityName}.",
            'technical_solution' => "Mesin spiral rotary daya puntir tinggi membersihkan sumbatan lemak padat dan kerak pipa PVC secara menyeluruh tanpa membongkar lantai keramik.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Armada siaga Drainusantara siap melayani kawasan {$loc} dengan posko reaksi cepat 24 jam. Mengatasi keluhan pipa mampet wastafel, WC, dan got komersial secara profesional, higienis, dan bergaransi resmi 30 hari.",
            'advantages_focus' => "Mobilisasi cepat armada posko di arteri {$cityName} dengan kesiapan mesin spiral baja untuk semua diameter pipa.",
            'local_faqs' => [
                [
                    'question' => "Berapa lama teknisi Drainusantara bisa sampai ke lokasi saya di {$loc}?",
                    'answer' => "Posko armada kami di {$cityName} siap meluncur langsung melalui akses jalan arteri utama. Estimasi tiba berkisar antara 30-45 menit setelah konfirmasi pesanan.",
                ],
                [
                    'question' => "Apakah melayani pengerjaan ruko pertokoan dan restoran di {$loc}?",
                    'answer' => "Ya, kami menangani saluran komersial ruko, rumah makan bersantan, hingga bak kontrol saluran pembuangan kantor dengan jaminan tuntas No Cure No Pay.",
                ],
                [
                    'question' => "Apakah pengerjaan pipa mampet di {$loc} dijamin tidak merusak keramik?",
                    'answer' => "100% aman tanpa bongkar keramik. Spiral baja lentur kami bekerja dari lubang saluran eksisting tanpa palu atau getaran perusak lantai.",
                ],
            ],
        ];
    }

    /**
     * Profile for Bodetabek (Sub-urban clusters, townhouse, industrial & modern commercial hubs).
     */
    private static function bodetabekClusterProfile(string $citySlug, ?string $district, string $cityName): array
    {
        $loc = $district ? "{$district}, {$cityName}" : $cityName;

        $prominent = match ($citySlug) {
            'depok-cinere' => ['Cinere & Gandul', 'Margonda Raya', 'Sukmajaya & Cilodong', 'Sawangan & Bojongsari', 'Pancoran Mas', 'Beji & UI'],
            'bekasi-cikarang' => ['Summarecon Bekasi', 'Cikarang Barat & MM2100', 'Grand Galaxy City', 'Jababeka', 'Harapan Indah', 'Tambun & Cibitung'],
            'tangerang-selatan' => ['BSD City & Serpong', 'Bintaro Jaya', 'Alam Sutera', 'Pamulang & Ciputat', 'Pondok Aren', 'Cirendeu'],
            'tangerang-kota' => ['Karawaci & Lippo', 'Cipondoh & Green Lake', 'Cikokol', 'Pinang & Banjar Wijaya', 'Batuceper', 'Periuk'],
            'bogor' => ['Sentul City', 'Bogor Kota & Pajajaran', 'Cibinong & Pemda', 'Gunung Putri & Cikeas', 'Baranangsiang', 'Yasmin'],
            default => ['Kawasan Klaster Perumahan', 'Pusat Ruko Komersial', 'Koridor Jalan Tol Arteri'],
        };

        return [
            'zone' => 'bodetabek_cluster',
            'zone_name' => "Kawasan Pemukiman Klaster Sub-Urban & Sentra Bisnis {$cityName}",
            'characteristics' => "Kawasan penyangga metropolitan dengan ribuan klaster perumahan modern, townhouse keluarga muda, serta sentra ruko komersial di {$cityName}.",
            'challenges' => "Instalasi pipa PVC perumahan klaster baru dengan kemiringan (slope) landai, timbunan lemak minyak dapur cuci piring, talang atap tersumbat daun/lumut, dan sedimentasi bak kontrol bawah garasi carport.",
            'building_focus' => "Rumah klaster perumahan, ruko kuliner & kafe, perumahan tapak, dan sentra industri pergudangan di {$cityName}.",
            'technical_solution' => "Kabel baja rotary Ridgid berkecepatan 400 RPM menembus lekukan pipa panjang di bawah carport tanpa perlu membongkar lantai keramik atau garasi paving.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Armada resmi Drainusantara siaga melayani seluruh klaster hunian dan area ruko di {$loc}. Menuntaskan masalah wastafel dapur, kloset toilet, dan floor drain dengan metode non-destruktif bergaransi tertulis 30 hari.",
            'advantages_focus' => "Keahlian menangani instalasi pipa klaster modern dengan belokan tersembunyi di bawah lantai carport tanpa pembongkaran.",
            'local_faqs' => [
                [
                    'question' => "Saluran pipa di rumah klaster {$loc} memiliki banyak belokan di bawah carport, apakah bisa ditembus?",
                    'answer' => "Bisa. Kabel spiral baja kami memiliki fleksibilitas tinggi yang mampu meliuk melewati 3-4 belokan elbow 90 derajat hingga kedalaman 30 meter tanpa merusak sambungan pipa PVC di bawah lantai carport.",
                ],
                [
                    'question' => "Berapa lama estimasi teknisi tiba di perumahan area {$loc}?",
                    'answer' => "Dengan posko siaga armada terdekat di {$cityName}, teknisi kami siap meluncur dengan waktu tempuh rata-rata 30-45 menit setelah konfirmasi via WhatsApp.",
                ],
                [
                    'question' => "Apakah pengerjaan di {$loc} bergaransi resmi?",
                    'answer' => "Ya, seluruh pengerjaan dilindungi garansi tertulis 30 hari kalender. Jika saluran air mampet kembali dalam masa garansi, teknisi datang ulang gratis tanpa biaya tambahan.",
                ],
            ],
        ];
    }

    /**
     * Profile for DKI Jakarta (Dense metropolitan, apartments, high-density residential & F&B).
     */
    private static function jakartaMetropolitanProfile(string $citySlug, ?string $district, string $cityName): array
    {
        $loc = $district ? "{$district}, {$cityName}" : $cityName;
        $prominent = ['Kawasan Residensial Padat', 'Sentra Ruko Kuliner & Kafe', 'Jalur Protokol & Arteri', 'Perumahan & Townhouse', 'Apartemen & Gedung Vertikal'];

        return [
            'zone' => 'jakarta_metropolitan',
            'zone_name' => "Metropolitan Ibukota, Residensial Padat & Sentra Komersial {$cityName}",
            'characteristics' => "Pusat hunian metropolitan dengan kepadatan bangunan tinggi, apartemen, perumahan padat, dan ribuan gerai kuliner F&B di {$cityName}.",
            'challenges' => "Akumulasi lemak masakan jenuh pada pipa gantung bawah lantai, sumbatan leher angsa wastafel apartemen/townhouse, serta endapan got pembuangan di bawah lantai bangunan padat.",
            'building_focus' => "Townhouse perkotaan, apartemen, ruko F&B / restoran, rumah tinggal padat, dan gedung kantor di {$cityName}.",
            'technical_solution' => "Mesin spiral rotary elektrik dan kamera endoskopi IP68 menuntaskan sumbatan secara higienis dan cepat tanpa mengotori ruangan hunian.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Drainusantara hadir siaga 24 jam melayani wilayah {$loc}. Menangani keluhan wastafel tumpat, toilet mampet, dan pipa got pembuangan secara higienis dan bersih tanpa membongkar keramik lantai hunian Anda.",
            'advantages_focus' => "Peralatan modern berstandar K3 dengan proteksi cover shoes dan sanitasi bersih khusus hunian perkotaan {$cityName}.",
            'local_faqs' => [
                [
                    'question' => "Apakah pengerjaan pipa mampet di {$loc} aman untuk apartemen dan townhouse?",
                    'answer' => "Sangat aman. Pengerjaan dilakukan dari lubang pipa eksisting tanpa suara benturan keras, tanpa getaran merusak struktur beton, dan tanpa menggunakan bahan kimia korosif berbahaya.",
                ],
                [
                    'question' => "Berapa lama teknisi Drainusantara tiba di area {$loc}?",
                    'answer' => "Armada mobile posko siaga kami tersebar di wilayah {$cityName}, siap menuju lokasi Anda dalam estimasi 30-45 menit tergantung kondisi lalu lintas.",
                ],
                [
                    'question' => "Bagaimana komitmen sistem No Cure No Pay di {$loc}?",
                    'answer' => "Jika tim kami gagal melancarkan saluran air Anda hingga mengalir normal, Anda tidak dikenakan biaya jasa pengerjaan sama sekali. Bebas risiko dan transparan.",
                ],
            ],
        ];
    }

    /**
     * Resolve deterministic sub-zone specifics, landmarks, and 3 analysis cards.
     *
     * @return array{
     *     zone_title: string,
     *     landmarks: array<int, string>,
     *     problem_desc: string,
     *     problem_detail: string,
     *     dispatch_desc: string,
     *     dispatch_detail: string,
     *     solution_desc: string,
     *     solution_detail: string,
     *     dominant_buildings: string
     * }
     */
    private static function resolveSubZone(string $citySlug, string $districtSlug, string $cityName, ?string $district): array
    {
        $loc = $district ?: $cityName;

        // 1. SEMARANG & DEMAK
        if (in_array($citySlug, ['semarang', 'kabupaten-semarang', 'demak'], true)) {
            // Semarang Atas (Perbukitan & Kampus)
            if (in_array($districtSlug, ['banyumanik', 'tembalang', 'candisari', 'gajahmungkur', 'gunungpati'], true)) {
                $landmarks = match ($districtSlug) {
                    'banyumanik' => ['Pudakpayung', 'Gedawang', 'Jabungan', 'Padangsari', 'Srondol Wetan & Kulon', 'Pedalangan', 'Jl. Setiabudi', 'Jl. Perintis Kemerdekaan', 'Perumahan Grafika & Srondol Indah'],
                    'tembalang' => ['Bulusan', 'Kramas', 'Meteseh', 'Rowosari', 'Sendangmulyo', 'Sendangguwo', 'Kawasan Kampus Undip & Polines', 'Bukit Kencana Jaya', 'Dinar Mas'],
                    'candisari' => ['Candi', 'Jatingaleh', 'Karanganyar Gunung', 'Tegalsari', 'Wonotingal', 'Jl. Sultan Agung', 'Jl. Dr. Wahidin', 'Perumahan Candi Golf'],
                    'gajahmungkur' => ['Bendan Dhuwur', 'Bendan Ngisor', 'Lempongsari', 'Gajahmungkur', 'Sampangan', 'Jl. Kelud Raya', 'Jl. Menoreh Raya', 'Jl. Papandayan'],
                    default => ['Sekaran', 'Plalangan', 'Gunungpati Kota', 'Kawasan Kampus Unnes', 'Jalur Ungaran-Gunungpati'],
                };

                return [
                    'zone_title' => "Kawasan Semarang Atas (Kontur Perbukitan, Kampus & Hunian Klaster)",
                    'landmarks' => $landmarks,
                    'problem_desc' => "Jalur pipa di {$loc} berada di kontur perbukitan dengan elevasi miring. Kendala dominan adalah penumpukan kerak minyak beku di sambungan pipa elbow leher angsa rumah makan/kos mahasiswa, serta endapan kerak kapur air tanah yang menyempitkan diameter PVC.",
                    'problem_detail' => "Bebas dari risiko intrusi banjir rob pesisir, namun aliran pipa berkecepatan gravitasi tinggi kerap memerangkap gumpalan rambut dan kerak busa sabun di belokan pipa bawah lantai sebelum masuk ke bak kontrol.",
                    'dispatch_desc' => "Posko armada bergerak melalui koridor Jl. Teuku Umar - Gombel atau Jl. Setiabudi, menjangkau seluruh perumahan dan area kos di {$loc} dengan waktu respon rata-rata 25–40 menit.",
                    'dispatch_detail' => "Teknisi mobile membawa unit portable Ridgid yang fleksibel bermanuver di gang pemukiman maupun jalan menanjak perumahan klaster.",
                    'solution_desc' => "Mata spiral cakar baja Ridgid meliuk menembus belokan leher angsa hingga 30 meter, merontokkan kerak lemak dan kapur tanpa merusak ubin lantai.",
                    'solution_detail' => "Dilanjutkan dengan pengujian flushing debit penuh bersama pemilik properti serta garansi resmi tertulis 30 hari kalender.",
                    'dominant_buildings' => "Hunian Klaster Perumahan, Rumah Kos Mahasiswa, Ruko Kuliner & Kafe",
                ];
            }

            // Semarang Pesisir / Bawah & Pantura
            if (in_array($districtSlug, ['genuk', 'semarang-utara', 'tugu', 'gayamsari'], true) || str_contains($citySlug, 'demak')) {
                $landmarks = match ($districtSlug) {
                    'genuk' => ['Terboyo Kulon & Wetan', 'Genuksari', 'Banjardowo', 'Gebangsari', 'Karangroto', 'Muktiharjo Lor', 'Jalur Pantura Kaligawe', 'Kawasan Industri Terboyo & LIK'],
                    'semarang-utara' => ['Bandarharjo', 'Bulukerto', 'Dadapsari', 'Kuningan', 'Panggung Kidul & Lor', 'Plombokan', 'Purwosari', 'Tanjung Mas', 'Pelabuhan Tanjung Emas'],
                    'tugu' => ['Jerakah', 'Karanganyar', 'Mangkang Kulon & Wetan', 'Mangunharjo', 'Randugarut', 'Tugurejo', 'Kawasan Industri Wijayakusuma'],
                    default => ['Sayung', 'Mranggen', 'Karangawen', 'Demak Kota', 'Jalur Arteri Pantura Semarang-Demak'],
                };

                return [
                    'zone_title' => "Kawasan Koridor Pesisir Pantura, Muara & Industri Semarang-Demak",
                    'landmarks' => $landmarks,
                    'problem_desc' => "Kemiringan pipa pembuangan di {$loc} cenderung landai akibat ketinggian tanah yang sejajar air laut. Masalah utama adalah intrusi sedimen lumpur pasang rob, pasir dak semen, dan residu oli/minyak industri.",
                    'problem_detail' => "Endapan lumpur yang bercampur dengan lemak dapur mudah memadat di dalam bak kontrol tertutup, menyebabkan air buangan kamar mandi dan wastafel meluap kembali saat hujan deras.",
                    'dispatch_desc' => "Unit armada siaga di koridor Jl. Kaligawe Raya / Arteri Yos Sudarso, siap meluncur cepat ke lokasi pergudangan, pabrik, dan pemukiman warga dalam 30–45 menit.",
                    'dispatch_detail' => "Kendaraan operasional dibekali peralatan pengaman genangan air dan unit spiral heavy duty pemecah sedimen lumpur padat.",
                    'solution_desc' => "Penggunaan kepala spiral bulb auger pemecah lumpur yang mendorong endapan padat keluar menuju saluran primer kota tanpa membongkar saluran cor.",
                    'solution_detail' => "Bebas bahan kimia berbahaya yang dapat mencemari lingkungan resapan air pesisir. Garansi pekerjaan ulang 30 hari kalender.",
                    'dominant_buildings' => "Pabrik Industri, Kompleks Pergudangan, Ruko Arteri Pantura & Rumah Warga",
                ];
            }

            // Semarang Kota / Pusat Bisnis
            $landmarks = ['Simpang Lima', 'Kawasan Pecinan & Kota Lama', 'Jl. Pandanaran', 'Jl. Pemuda', 'Jl. Gajah Mada', 'Pekunden', 'Sekayu', 'Pleburan', 'Peterongan', 'Karangayu & Krobokan'];

            return [
                'zone_title' => "Kawasan Pusat Kota, Sentra Bisnis & Ruko Heritage {$cityName}",
                'landmarks' => $landmarks,
                'problem_desc' => "Bangunan ruko komersial, hotel, dan perumahan di {$loc} memiliki instalasi pipa PVC berumur panjang di bawah lantai cor semen tebal. Kerak minyak makanan dan sisa sabun yang menumpuk bertahun-tahun sangat riskan jika dibongkar.",
                'problem_detail' => "Penggunaan soda api oleh pemilik sebelumnya kerap menyebabkan pipa melengkung atau sambungan fitting lem meleleh. Diperlukan penanganan mekanis ekstra hati-hati.",
                'dispatch_desc' => "Armada standby di pusat kota {$cityName}, mencapai ruko, hotel, maupun perumahan dalam estimasi 20–35 menit.",
                'dispatch_detail' => "Teknisi berseragam rapi dan menggunakan pelindung sepatu (cover shoes) agar lantai interior bisnis tetap steril dan higienis.",
                'solution_desc' => "Kabel spiral baja berkecepatan 400 RPM berputar melumat sumbatan dari lubang pipa eksisting tanpa palu, pahat, atau kerusakan ubin.",
                'solution_detail' => "Inspeksi visual opsional dengan kamera CCTV endoskopi 30M untuk memastikan pipa lama bebas dari retakan dan penyumbatan tersembunyi.",
                'dominant_buildings' => "Ruko Pertokoan, Restoran & Kafe, Hotel, Perkantoran & Rumah Heritage",
            ];
        }

        // 2. HYPER-LOCAL RESOLUTION FOR ALL OTHER DISTRICTS
        if ($district && $districtSlug !== '') {
            $hyper = HyperLocalTaxonomy::getDistrictProfile($citySlug, $district, $cityName);
            return [
                'zone_title' => "Kawasan {$hyper['typology_label']} {$loc}",
                'landmarks' => $hyper['landmarks'],
                'problem_desc' => $hyper['problem_desc'],
                'problem_detail' => $hyper['problem_detail'],
                'dispatch_desc' => $hyper['dispatch_desc'],
                'dispatch_detail' => "Teknisi mobile membawa unit portable Ridgid berdaya puntir tinggi serta kamera CCTV IP68 siap menangani saluran pipa di {$loc}.",
                'solution_desc' => $hyper['solution_desc'],
                'solution_detail' => $hyper['solution_detail'],
                'dominant_buildings' => $hyper['dominant_buildings'],
            ];
        }

        // 3. BANDUNG RAYA (City Level Fallback)
        if (in_array($citySlug, ['bandung', 'kabupaten-bandung', 'kota-cimahi'], true)) {
            $landmarks = ['Dago & Dipatiukur', 'Riau & Trunojoyo', 'Setiabudi & Gegerkalong', 'Buahbatu & Batununggal', 'Antapani & Arcamanik', 'Cimahi & Baros', 'Kopo & Pasirkoja'];

            return [
                'zone_title' => "Kawasan Cekungan Dataran Tinggi & Sentra Kuliner {$cityName}",
                'landmarks' => $landmarks,
                'problem_desc' => "Suhu udara dingin di {$loc} mempercepat pembekuan sisa minyak nabati dan kuah berlemak pada pipa wastafel dapur resto dan rumah tinggal, membentuk kerak padat menyerupai lilin.",
                'problem_detail' => "Saluran pipa talang air juga kerap tersumbat lumut tebal akibat curah hujan tinggi di lereng bukit Bandung.",
                'dispatch_desc' => "Posko armada Bandung bergerak via akses jalan arteri kota dengan estimasi tiba 30–45 menit di seluruh titik hunian dan kafe.",
                'dispatch_detail' => "Unit mobile siaga 24 jam untuk melayani panggilan darurat resto sebelum jam operasional dimulai.",
                'solution_desc' => "Mata pengeruk spiral Ridgid memotong gumpalan lemak lilin padat dan menarik serat rambut dari floor drain tanpa merusak lantai keramik.",
                'solution_detail' => "Aman 100% untuk pipa bangunan heritage maupun townhouse lereng bukit. Dilindungi garansi 30 hari.",
                'dominant_buildings' => "Kafe & Resto Kuliner, Ruko Factory Outlet, Villa Lereng & Townhouse",
            ];
        }

        // 3. BALI (Denpasar, Badung, Gianyar, Tabanan)
        if (in_array($citySlug, ['kota-denpasar', 'badung', 'gianyar', 'tabanan'], true)) {
            $landmarks = ['Kuta & Legian', 'Seminyak & Kerobokan', 'Canggu & Berawa', 'Sanur & Renon', 'Ubud & Tegallalang', 'Jimbaran & Bukit'];

            return [
                'zone_title' => "Kawasan Pariwisata Internasional, Villa & Residensial Pulau Dewata",
                'landmarks' => $landmarks,
                'problem_desc' => "Sumbatan pipa di {$loc} dipicu tingginya penggunaan sanitasi villa/resort, pasir pantai halus pada floor drain bilas luar, akar pohon kamboja/tropis yang menerobos fitting, dan lemak dapur kafe.",
                'problem_detail' => "Properti pariwisata membutuhkan pengerjaan yang senyap, bersih, tanpa bau bahan kimia menyengat yang dapat mengganggu kenyamanan tamu.",
                'dispatch_desc' => "Unit armada posko Bali bergerak cepat dari koridor Bypass Ngurah Rai / Sunset Road dengan estimasi tiba 30–45 menit.",
                'dispatch_detail' => "Teknisi berpenampilan rapi, sopan, dan wajib mengenakan cover shoes steril di area dalam villa.",
                'solution_desc' => "Mesin spiral mekanis berdaya putar halus membersihkan pasir dan rambut tuntas dari lubang saluran tanpa membongkar lantai batu alam atau teraso.",
                'solution_detail' => "Dukungan invoice digital resmi PT Jawa Jaya Rooter untuk administrasi manajemen properti dan garansi 30 hari.",
                'dominant_buildings' => "Villa Privat, Butik Resort, Kafe Pantai, Restoran Internasional & Rumah Tinggal",
            ];
        }

        // 4. BANDAR LAMPUNG
        if ($citySlug === 'bandar-lampung') {
            $landmarks = ['Tanjung Karang', 'Kedaton & Labuhan Ratu', 'Way Halim & Sukarame', 'Teluk Betung & Pesisir', 'Kemiling', 'Rajabasa & Arteri Soekarno Hatta'];

            return [
                'zone_title' => "Gerbang Niaga Arteri Sumatera & Pemukiman Pesisir Teluk Lampung",
                'landmarks' => $landmarks,
                'problem_desc' => "Kerak kapur air tanah tinggi dan lemak sisa olahan masakan bersantan menjadi pemicu utama pipa wastafel dan saluran pembuangan mampet di {$loc}.",
                'problem_detail' => "Bak kontrol rumah tapak yang tertimbun semen atau paving carport juga kerap meluap saat saluran utama tersumbat.",
                'dispatch_desc' => "Armada siaga di jalan protokol Bandar Lampung meluncur ke lokasi alamat dalam 30–45 menit via akses bypass arteri.",
                'dispatch_detail' => "Siaga 24 jam untuk hunian keluarga, ruko niaga, maupun rumah makan khas Sumatera.",
                'solution_desc' => "Kabel spiral rotary fleksibel menghancurkan sedimen kapur dan lemak beku tanpa membongkar lantai keramik hunian.",
                'solution_detail' => "Komitmen No Cure No Pay: saluran gagal lancar plong, gratis biaya jasa pengerjaan. Garansi 30 hari.",
                'dominant_buildings' => "Ruko Niaga Protokol, Rumah Tapak Residensial, Rumah Makan & Fasilitas Umum",
            ];
        }

        // 5. JABODETABEK DEFAULT (Jakarta, Depok, Tangerang, Bekasi, Bogor)
        $landmarks = ['Kawasan Klaster Perumahan', 'Townhouse & Hunian Vertikal', 'Sentra Ruko Kuliner & Kafe', 'Jalur Arteri Protokol', 'Kawasan Perkantoran & Bisnis'];

        return [
            'zone_title' => "Kawasan Metropolitan Sub-Urban & Sentra Residensial {$cityName}",
            'landmarks' => $landmarks,
            'problem_desc' => "Instalasi pipa PVC klaster perumahan dan townhouse di {$loc} memiliki banyak belokan elbow di bawah carport. Penumpukan minyak goreng masakan dan gumpalan rambut kamar mandi memperlambat aliran air hingga meluap.",
            'problem_detail' => "Banyak pemilik rumah mencoba menuangkan soda api yang justru membeku seperti batu semen dan merusak sambungan pipa PVC.",
            'dispatch_desc' => "Armada siaga posko {$cityName} tersebar di titik strategis, meluncur ke rumah Anda dalam 30–45 menit setelah konfirmasi pesanan.",
            'dispatch_detail' => "Mobil operasional siap dengan unit cadangan spiral kabel panjang hingga jangkauan 30 meter.",
            'solution_desc' => "Spiral baja fleksibel Ridgid USA menembus leher angsa sifon dan lekukan 90 derajat tanpa membongkar keramik lantai atau membobok carport.",
            'solution_detail' => "Pembersihan menyeluruh disertai nota garansi resmi 30 hari kalender demi kenyamanan jangka panjang keluarga Anda.",
            'dominant_buildings' => "Rumah Klaster Modern, Townhouse, Ruko Komersial & Apartemen",
        ];
    }

    /**
     * Generate localized customer reviews tailored to the region's profile.
     *
     * @return array<int, array{
     *     customer_name: string,
     *     initials: string,
     *     avatar_bg: string,
     *     avatar_url: ?string,
     *     verified: bool,
     *     rating: int,
     *     time_ago: string,
     *     property_type: string,
     *     service_name: string,
     *     turnaround: string,
     *     location: string,
     *     comment: string
     * }>
     */
    public static function getLocalReviews(string $cityName, ?string $districtName = null, int $limit = 4): array
    {
        $cleanDistrict = self::normalizeDistrict($districtName);
        $cleanCity = self::normalizeCity(Str::slug($cityName), $cityName);
        $loc = $cleanDistrict ? "{$cleanDistrict}, {$cleanCity}" : $cleanCity;
        $zone = self::resolveZone(Str::slug($cleanCity));

        $seed = abs(crc32($loc));

        $namesPool = [
            ['Bpk. Hendra Wijaya', 'HW', 'bg-sky-700'],
            ['Ibu Ratna Susanti', 'RS', 'bg-emerald-700'],
            ['dr. Bambang Prasetyo', 'BP', 'bg-indigo-700'],
            ['Pak Haji Ridwan', 'HR', 'bg-slate-700'],
            ['Ibu Maya Kusuma', 'MK', 'bg-teal-700'],
            ['Ko Steven Halim', 'SH', 'bg-blue-700'],
            ['Ibu Linda Santoso', 'LS', 'bg-rose-700'],
            ['Bpk. Dian Pratama', 'DP', 'bg-cyan-700'],
        ];

        // Specific regional review storylines
        $reviewStorylines = match ($zone) {
            'semarang_pantura' => [
                [
                    'property_type' => 'Rumah Tinggal Residensial',
                    'service_name' => 'Pelancaran Pipa Wastafel Dapur & Lemak',
                    'turnaround' => 'Tuntas 40 menit tanpa bobok keramik',
                    'comment' => "Pipa pembuangan dapur di rumah saya di {$loc} tersumbat parah oleh gumpalan minyak beku dan endapan pasir halus. Sempat panggil tukang biasa tapi mau dibongkar keramiknya. Untung langsung kontak Drainusantara, teknisi datang tepat waktu bawa mesin spiral Ridgid. Tanpa bongkar lantai, saluran langsung plong lancar!",
                ],
                [
                    'property_type' => 'Ruko Usaha & Toko',
                    'service_name' => 'Pembersihan Bak Kontrol & Pipa Utama',
                    'turnaround' => 'Tuntas 45 menit pengerjaan bersih',
                    'comment' => "Bak kontrol saluran pembuangan ruko kami di {$loc} meluap karena endapan lumpur padat pasang rob dan sisa kotoran. Tim teknisi Drainusantara sangat profesional, bekerja dengan SOP higienis dan mesin spiral heavy-duty. Diberikan nota garansi fisik 30 hari.",
                ],
                [
                    'property_type' => 'Hunian Keluarga 2 Lantai',
                    'service_name' => 'Pelancaran Kloset & WC Meluap',
                    'turnaround' => 'Tuntas 35 menit saluran kembali normal',
                    'comment' => "Kloset duduk lantai 1 tiba-tiba mampet dan airnya meluap saat disiram. Respon admin WhatsApp sigap sekali, teknisi tiba dalam 30 menit dengan perlengkapan lengkap. Pengerjaan cepat, rapi, dan tidak ada bau kimia yang menyengat sama sekali.",
                ],
                [
                    'property_type' => 'Rumah Tinggal',
                    'service_name' => 'Pelancaran Floor Drain Kamar Mandi',
                    'turnaround' => 'Tuntas 30 menit bebas genangan air',
                    'comment' => "Saluran pembuangan air kamar mandi mampet berhari-hari karena serat rambut dan kerak sabun tebal. Teknisi Drainusantara bersihkan sampai tuntas ke saluran luar. Komitmen No Cure No Pay terbukti nyata. Sangat direkomendasikan untuk warga {$cleanCity}!",
                ],
            ],
            'bandung_highland' => [
                [
                    'property_type' => 'Kafe & Resto Kuliner',
                    'service_name' => 'Kuras Grease Trap & Lemak Beku',
                    'turnaround' => 'Tuntas 45 menit dapur langsung operasional',
                    'comment' => "Suhu dingin di {$loc} bikin sisa lemak kuah dan minyak di dapur cepat mengeras seperti lilin batu di dalam pipa. Saluran cuci piring macet total pas jam makan siang. Teknisi Drainusantara gerak cepat dengan mesin rooter spiral elektrik, gumpalan lemak putih padat hancur semua. Pelayanan luar biasa!",
                ],
                [
                    'property_type' => 'Townhouse Residensial',
                    'service_name' => 'Pelancaran Wastafel Cuci Piring',
                    'turnaround' => 'Tuntas 35 menit aman untuk pipa PVC',
                    'comment' => "Wastafel dapur tersumbat sudah seminggu, air kotor sampai naik ke bak cuci. Teknisi datang berseragam rapi, pakai cover sepatu, dan ramah menjelaskan penyebab mampetnya. Tanpa soda api yang bisa merusak sambungan pipa PVC, saluran kembali lancar plong.",
                ],
                [
                    'property_type' => 'Rumah Tinggal 2 Lantai',
                    'service_name' => 'Pelancaran Kloset Duduk Tersumbat',
                    'turnaround' => 'Tuntas 40 menit tanpa copot porselen kloset',
                    'comment' => "Kloset duduk anak tersumbat tisu tebal. Sangat khawatir kalau harus copot kloset porselen. Teknisi Drainusantara punya alat spiral khusus yang meliuk fleksibel menembus leher angsa porselen tanpa lecet sedikitpun. Mantap dan bergaransi resmi!",
                ],
                [
                    'property_type' => 'Villa & Rumah Lereng',
                    'service_name' => 'Pelancaran Talang Rooftop & Saluran Hujan',
                    'turnaround' => 'Tuntas 50 menit jangkauan pipa vertikal',
                    'comment' => "Talang air dak lantai atas mampet lumut dan daun kering saat hujan deras di Bandung. Teknisi bersedia naik dan membersihkan pipa vertikal hingga ke resapan bawah. Air hujan sekarang mengalir deras tanpa rembes ke plafon rumah lagi.",
                ],
            ],
            'bali_hospitality' => [
                [
                    'property_type' => 'Villa Privat & Resort',
                    'service_name' => 'Pelancaran Floor Drain Kamar Mandi',
                    'turnaround' => 'Tuntas 35 menit senyap & steril',
                    'comment' => "Floor drain kamar mandi tamu villa di {$loc} tersumbat pasir pantai dan rambut. Teknisi Drainusantara sangat menghormati standar kenyamanan tamu: senyap, higienis, dan mengenakan sarung tangan serta cover sepatu. Saluran plong seketika!",
                ],
                [
                    'property_type' => 'Restoran & Bistro',
                    'service_name' => 'Pelancaran Grease Trap Dapur Resto',
                    'turnaround' => 'Tuntas 45 menit bebas bau menyengat',
                    'comment' => "Saluran grease trap dapur resto tersumbat minyak jenuh. Menggunakan mesin spiral mekanis berputar halus, sumbatan langsung bersih tanpa bau kimia yang bisa mengganggu tamu restoran. Sangat profesional untuk mitra hospitality.",
                ],
                [
                    'property_type' => 'Residensial Villa',
                    'service_name' => 'Pelancaran Kloset Duduk & Toilet',
                    'turnaround' => 'Tuntas 40 menit tanpa merusak lantai teraso',
                    'comment' => "Kloset villa meluap saat jadwal tamu check-in tinggal beberapa jam. Tim Drainusantara tiba dalam 30 menit setelah dikonfirmasi via WA. Penanganan mekanis modern tanpa membongkar lantai batu alam atau teraso. Very recommended!",
                ],
                [
                    'property_type' => 'Properti Usaha',
                    'service_name' => 'Pembersihan Pipa Pembuangan Luar',
                    'turnaround' => 'Tuntas 50 menit tembus akar tanaman',
                    'comment' => "Pipa pembuangan luar halaman tersumbat jalinan akar tanaman hias. Ditembus menggunakan spiral baja bertenaga tinggi hingga akar hancur terdorong keluar. Diberikan nota garansi dan kwitansi resmi PT Jawa Jaya Rooter.",
                ],
            ],
            'lampung_commercial' => [
                [
                    'property_type' => 'Rumah Tinggal',
                    'service_name' => 'Pelancaran Wastafel Dapur & Lemak',
                    'turnaround' => 'Tuntas 40 menit pipa kembali plong',
                    'comment' => "Pipa wastafel mampet parah karena campuran kerak air kapur dan sisa lemak masakan bersantan. Teknisi Drainusantara bersihkan sampai tuntas pakai mesin rotary spiral. Pipa plong seperti baru lagi, biaya transparan sesuai estimasi!",
                ],
                [
                    'property_type' => 'Ruko Usaha & Toko',
                    'service_name' => 'Pelancaran Kloset & WC Meluap',
                    'turnaround' => 'Tuntas 35 menit tanpa merusak keramik',
                    'comment' => "Kloset jongkok ruko meluap tidak mau surut saat jam operasional. Hubungi Drainusantara lewat WhatsApp langsung direspon cepat. 35 menit pengerjaan langsung beres tanpa ada lantai yang dibongkar. Teknisi sopan dan teliti.",
                ],
                [
                    'property_type' => 'Rumah Makan',
                    'service_name' => 'Pembersihan Pipa Pembuangan & Bak Kontrol',
                    'turnaround' => 'Tuntas 45 menit bebas residu lemak masakan',
                    'comment' => "Saluran air kotor rumah makan di {$loc} tersumbat gumpalan minyak. Teknisi bawa unit spiral panjang, kerak pipa terkikis bersih sampai ke bak penampungan luar. Garansi tertulis 30 hari bikin tenang.",
                ],
                [
                    'property_type' => 'Hunian Residensial',
                    'service_name' => 'Pelancaran Floor Drain Kamar Mandi',
                    'turnaround' => 'Tuntas 30 menit air mandi langsung surut',
                    'comment' => "Kamar mandi utama sering banjir karena air tidak mau mengalir ke pipa pembuangan. Teknisi berhasil menarik gumpalan kotoran yang menyumbat. Sekarang mandi nyaman lagi tanpa genangan air got.",
                ],
            ],
            default => [
                [
                    'property_type' => 'Rumah Tinggal (Klaster)',
                    'service_name' => 'Pelancaran Wastafel Dapur & Jalur Carport',
                    'turnaround' => 'Tuntas 40 menit tanpa bobok lantai carport',
                    'comment' => "Pipa pembuangan wastafel dapur rumah kami di {$loc} mampet total, air kotor meluap dari bak kontrol di carport. Banyak belokan pipa siku di bawah semen, tapi kabel spiral fleksibel teknisi Drainusantara berhasil tembus dan hancurkan kerak lemak tebal tanpa merusak keramik carport!",
                ],
                [
                    'property_type' => 'Hunian 2 Lantai',
                    'service_name' => 'Pelancaran Kloset Duduk Meluap',
                    'turnaround' => 'Tuntas 35 menit pengerjaan bersih & steril',
                    'comment' => "Kloset duduk lantai 2 tersumbat tisu dan pembalut. Teknisi tiba 30 menit setelah konfirmasi pesanan WhatsApp, bekerja pakai APD bersih dan pelindung sepatu. Kloset kembali lancar disiram hanya dalam 35 menit tanpa ada porselen yang dicopot.",
                ],
                [
                    'property_type' => 'Ruko Komersial & Kantor',
                    'service_name' => 'Pelancaran Pipa Utama & Bak Kontrol',
                    'turnaround' => 'Tuntas 45 menit jangkauan mesin 25 meter',
                    'comment' => "Saluran pembuangan ruko 3 lantai kami macet di jalur utama. Teknisi menggunakan mesin Ridgid K-6200 daya putar torsi tinggi, kotoran endapan bertahun-tahun langsung hancur keluar tuntas. Ada nota garansi resmi 30 hari yang sangat meyakinkan.",
                ],
                [
                    'property_type' => 'Townhouse Residensial',
                    'service_name' => 'Pelancaran Floor Drain Kamar Mandi',
                    'turnaround' => 'Tuntas 30 menit bebas genangan busa sabun',
                    'comment' => "Air shower kamar mandi menggenang setinggi mata kaki karena gumpalan rambut dan kerak sabun tebal di pipa 2 inch. Teknisi bersihkan cepat dan rapi tanpa bau kimia menyengat. Komitmen No Cure No Pay sangat memuaskan!",
                ],
            ],
        };

        $timeAgos = ['3 hari lalu', '5 hari lalu', '1 minggu lalu', '2 minggu lalu'];

        $reviews = [];
        $totalPool = count($namesPool);

        for ($i = 0; $i < min($limit, count($reviewStorylines)); $i++) {
            $nameIdx = ($seed + $i * 2) % $totalPool;
            $story = $reviewStorylines[$i];

            $reviews[] = [
                'customer_name' => $namesPool[$nameIdx][0],
                'initials' => $namesPool[$nameIdx][1],
                'avatar_bg' => $namesPool[$nameIdx][2],
                'avatar_url' => null,
                'verified' => true,
                'rating' => 5,
                'time_ago' => $timeAgos[$i % count($timeAgos)],
                'property_type' => $story['property_type'],
                'service_name' => $story['service_name'],
                'turnaround' => $story['turnaround'],
                'location' => $loc,
                'comment' => $story['comment'],
            ];
        }

        return $reviews;
    }
}
