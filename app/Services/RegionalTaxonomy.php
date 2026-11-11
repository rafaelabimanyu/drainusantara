<?php

declare(strict_types=1);

namespace App\Services;

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
    public static function getProfile(string $citySlug, ?string $district = null): array
    {
        $zone = self::resolveZone($citySlug);

        return match ($zone) {
            'semarang_pantura' => self::semarangPanturaProfile($citySlug, $district),
            'bandung_highland' => self::bandungHighlandProfile($citySlug, $district),
            'bali_hospitality' => self::baliHospitalityProfile($citySlug, $district),
            'lampung_commercial' => self::lampungCommercialProfile($citySlug, $district),
            'bodetabek_cluster' => self::bodetabekClusterProfile($citySlug, $district),
            default => self::jakartaMetropolitanProfile($citySlug, $district),
        };
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
     * Profile for Semarang & Demak (Pantura, coastal rob/sediment, lime & industrial).
     */
    private static function semarangPanturaProfile(string $citySlug, ?string $district): array
    {
        $loc = $district ?: 'Semarang & Pantura';
        $isDemak = str_contains($citySlug, 'demak');
        $isKab = str_contains($citySlug, 'kabupaten-semarang');

        $prominent = $isDemak
            ? ['Sayung', 'Mranggen', 'Karangawen', 'Demak Kota', 'Jalur Pantura Semarang-Demak', 'Kawasan Industri Sayung']
            : ($isKab
                ? ['Ungaran Barat', 'Ungaran Timur', 'Ambarawa', 'Bawen', 'Kawasan Industri Bergas', 'Jalan Raya Solo-Semarang']
                : ['Simpang Lima', 'Kawasan Industri Genuk', 'Tugu Wijayakusuma', 'Gombel & Candisari', 'Banyumanik', 'Tembalang Undip', 'Krapyak & Siliwangi']);

        return [
            'zone' => 'semarang_pantura',
            'zone_name' => 'Kawasan Pesisir Pantura, Perbukitan & Industri Semarang-Demak',
            'characteristics' => "Kawasan strategis jalur Pantura Jawa Tengah dengan topografi pesisir berair rob di sisi utara serta perbukitan terjal di sisi selatan.",
            'challenges' => "Saluran pipa di kawasan {$loc} kerap menghadapi endapan lumpur intrusi rob pesisir, residu pasir dak beton, dan kerak kapur air tanah yang mengeras di dinding pipa PVC.",
            'building_focus' => "Perumahan tapak, ruko arteri Pantura, pabrik manufaktur kawasan industri, dan hunian klaster perbukitan.",
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
                    'answer' => "Teknisi armada posko Semarang & Demak bergerak cepat dari titik siaga terdekat. Estimasi kedatangan 30-60 menit tergantung kondisi lalu lintas jalur utama.",
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
    private static function bandungHighlandProfile(string $citySlug, ?string $district): array
    {
        $loc = $district ?: 'Bandung Raya';
        $prominent = ['Dago & Setiabudi', 'Riau & Trunojoyo', 'Buahbatu & Batununggal', 'Sukajadi & PVJ', 'Cimahi Tengah', 'Antapani & Arcamanik', 'Kopo & Bojongsoang'];

        return [
            'zone' => 'bandung_highland',
            'zone_name' => 'Kawasan Dataran Tinggi, Kafe Wisata & Kontur Berbukit Bandung',
            'characteristics' => "Topografi cekungan dataran tinggi berhawa sejuk dengan sentra kuliner kafe/resto modern dan hunian berkontur tanah miring.",
            'challenges' => "Suhu udara dingin di Bandung mempercepat proses pembekuan minyak nabati dan lemak hewani di dalam saluran wastafel dapur, membentuk kerak padat menyerupai lilin di sambungan pipa berbelok.",
            'building_focus' => "Kafe & restoran kuliner, ruko factory outlet, townhouse residensial lereng bukit, dan perumahan heritage.",
            'technical_solution' => "Mata spiral rotary penembus lemak berputar 400 RPM meliuk melewati sambungan siku (elbow) pipa tanpa tekanan kimia berbahaya yang dapat memecahkan pipa di cuaca dingin.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Armada resmi Drainusantara siaga melayani area {$loc}. Mengatasi problem khas perpipaan Bandung seperti pembekuan minyak dapur akibat suhu dingin, sumbatan talang air hujan berlumut, dan pipa mampet di kontur tanah berundak tanpa merusak keramik.",
            'advantages_focus' => "Kabel spiral baja fleksibel menembus leher angsa dan belokan elbow tajam pada instalasi pipa bangunan berundak khas Bandung.",
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
                    'answer' => "Ya, kami berpengalaman melayani puluhan kafe, kedai kopi, dan restoran di Bandung Raya dengan penanganan cepat sebelum jam buka operasional.",
                ],
            ],
        ];
    }

    /**
     * Profile for Bali (Denpasar, Badung, Gianyar: Hospitality, villas, beach sand & resort standards).
     */
    private static function baliHospitalityProfile(string $citySlug, ?string $district): array
    {
        $loc = $district ?: 'Bali';
        $prominent = ['Kuta & Seminyak', 'Canggu & Berawa', 'Sanur & Denpasar Selatan', 'Ubud & Tegallalang', 'Jimbaran & Nusa Dua', 'Uluwatu & Bukit'];

        return [
            'zone' => 'bali_hospitality',
            'zone_name' => 'Kawasan Pariwisata, Villa & Residensial Pulau Dewata',
            'characteristics' => "Kawasan properti pariwisata bertaraf internasional dengan villa privat, resort tepi pantai, kafe, beach club, serta pemukiman warga perkotaan.",
            'challenges' => "Tingginya volume pembuangan air di villa/resort, sumbatan pasir pantai pada floor drain kamar bilas outdoor, akar tanaman tropis yang merambat ke sambungan pipa taman, dan residu lemak dapur komersial.",
            'building_focus' => "Villa privat, butik hotel, restoran & kafe internasional, resort pantai, serta hunian residensial.",
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
    private static function lampungCommercialProfile(string $citySlug, ?string $district): array
    {
        $loc = $district ?: 'Bandar Lampung';
        $prominent = ['Tanjung Karang Pusat', 'Kedaton & Labuhan Ratu', 'Way Halim & Sukarame', 'Teluk Betung', 'Kemiling', 'Rajabasa & Arteri Soekarno Hatta'];

        return [
            'zone' => 'lampung_commercial',
            'zone_name' => 'Gerbang Niaga Sumatera, Koridor Arteri & Pemukiman Bandar Lampung',
            'characteristics' => "Pusat aktivitas perdagangan dan gerbang logistik Sumatera dengan kontur perbukitan dan kawasan pemukiman pesisir teluk.",
            'challenges' => "Akumulasi kerak kapur dari air tanah, endapan lemak makanan bersantan pada pipa dapur, serta sumbatan bak kontrol utama rumah dan ruko di jalur utama kota.",
            'building_focus' => "Ruko pertokoan jalan protokol, perumahan tapak, restoran F&B, dan fasilitas umum.",
            'technical_solution' => "Mesin spiral rotary daya puntir tinggi membersihkan sumbatan lemak padat dan kerak pipa PVC secara menyeluruh tanpa membongkar lantai keramik.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Armada siaga Drainusantara siap melayani kawasan {$loc} dengan posko reaksi cepat 24 jam. Mengatasi keluhan pipa mampet wastafel, WC, dan got komersial secara profesional, higienis, dan bergaransi resmi 30 hari.",
            'advantages_focus' => "Mobilisasi cepat armada posko di arteri Bandar Lampung dengan kesiapan mesin spiral baja untuk semua diameter pipa.",
            'local_faqs' => [
                [
                    'question' => "Berapa lama teknisi Drainusantara bisa sampai ke lokasi saya di {$loc}?",
                    'answer' => "Posko armada kami di Bandar Lampung siap meluncur langsung melalui akses jalan arteri utama. Estimasi tiba berkisar antara 30-45 menit setelah konfirmasi pesanan.",
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
    private static function bodetabekClusterProfile(string $citySlug, ?string $district): array
    {
        $loc = $district ?: 'Bodetabek';
        $cityName = match ($citySlug) {
            'depok-cinere' => 'Depok & Cinere',
            'bekasi-cikarang' => 'Bekasi & Cikarang',
            'tangerang-selatan' => 'Tangerang Selatan',
            'tangerang-kota' => 'Tangerang Kota',
            'bogor' => 'Bogor',
            default => 'Bodetabek',
        };

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
            'characteristics' => "Kawasan penyangga metropolitan dengan ribuan klaster perumahan modern, townhouse keluarga muda, serta sentra ruko komersial.",
            'challenges' => "Instalasi pipa PVC perumahan klaster baru dengan kemiringan (slope) landai, timbunan lemak minyak dapur cuci piring, talang atap tersumbat daun/lumut, dan sedimentasi bak kontrol bawah garasi carport.",
            'building_focus' => "Rumah klaster perumahan, ruko kuliner & kafe, perumahan subsidi/komersial, dan sentra industri pergudangan.",
            'technical_solution' => "Kabel baja rotary Ridgid berkecepatan 400 RPM menembus lekukan pipa panjang di bawah carport tanpa perlu membongkar lantai keramik atau garasi paving.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Armada resmi Drainusantara siaga melayani seluruh klaster hunian dan area ruko di {$loc}, {$cityName}. Menuntaskan masalah wastafel dapur, kloset toilet, dan floor drain dengan metode non-destruktif bergaransi tertulis 30 hari.",
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
    private static function jakartaMetropolitanProfile(string $citySlug, ?string $district): array
    {
        $loc = $district ?: 'Jakarta';
        $prominent = ['Kawasan Residensial Padat', 'Sentra Ruko Kuliner & Kafe', 'Jalur Protokol & Arteri', 'Perumahan & Townhouse', 'Apartemen & Gedung Vertikal'];

        return [
            'zone' => 'jakarta_metropolitan',
            'zone_name' => 'Metropolitan Ibukota, Residensial Padat & Sentra Komersial Jakarta',
            'characteristics' => "Pusat hunian metropolitan dengan kepadatan bangunan tinggi, apartemen, perumahan padat, dan ribuan gerai kuliner F&B.",
            'challenges' => "Akumulasi lemak masakan jenuh pada pipa gantung bawah lantai, sumbatan leher angsa wastafel apartemen/townhouse, serta endapan got pembuangan di bawah lantai bangunan padat.",
            'building_focus' => "Townhouse perkotaan, apartemen, ruko F&B / restoran, rumah tinggal padat, dan gedung kantor.",
            'technical_solution' => "Mesin spiral rotary elektrik dan kamera endoskopi IP68 menuntaskan sumbatan secara higienis dan cepat tanpa mengotori ruangan hunian.",
            'prominent_areas' => $prominent,
            'presence_prose' => "Drainusantara hadir siaga 24 jam melayani wilayah {$loc}. Menangani keluhan wastafel tumpat, toilet mampet, dan pipa got pembuangan secara higienis dan bersih tanpa membongkar keramik lantai hunian Anda.",
            'advantages_focus' => "Peralatan modern berstandar K3 dengan proteksi cover shoes dan sanitasi bersih khusus hunian perkotaan Jakarta.",
            'local_faqs' => [
                [
                    'question' => "Apakah pengerjaan pipa mampet di {$loc} aman untuk apartemen dan townhouse?",
                    'answer' => "Sangat aman. Pengerjaan dilakukan dari lubang pipa eksisting tanpa suara benturan keras, tanpa getaran merusak struktur beton, dan tanpa menggunakan bahan kimia korosif berbahaya.",
                ],
                [
                    'question' => "Berapa lama teknisi Drainusantara tiba di area {$loc}?",
                    'answer' => "Armada mobile posko siaga kami tersebar di wilayah Jakarta, siap menuju lokasi Anda dalam estimasi 30-45 menit tergantung kondisi lalu lintas.",
                ],
                [
                    'question' => "Bagaimana komitmen sistem No Cure No Pay di {$loc}?",
                    'answer' => "Jika tim kami gagal melancarkan saluran air Anda hingga mengalir normal, Anda tidak dikenakan biaya jasa pengerjaan sama sekali. Bebas risiko dan transparan.",
                ],
            ],
        ];
    }
}

