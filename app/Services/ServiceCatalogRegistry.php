<?php

declare(strict_types=1);

namespace App\Services;

class ServiceCatalogRegistry
{
    /**
     * Permanent 301 alias redirect map to canonical target slugs.
     *
     * @var array<string, string>
     */
    public const SLUG_ALIASES = [
        'wastafel-cuci-piring' => 'jasa-wastafel-dan-cucian-piring-mampet',
        'wastafel-cuci-piring-mampet' => 'jasa-wastafel-dan-cucian-piring-mampet',
        'jasa-wastafel-mampet' => 'jasa-wastafel-dan-cucian-piring-mampet',
        'kloset-wc' => 'jasa-wc-dan-kloset-mampet',
        'kloset-wc-mampet' => 'jasa-wc-dan-kloset-mampet',
        'jasa-wc-mampet' => 'jasa-wc-dan-kloset-mampet',
        'floor-drain' => 'jasa-kamar-mandi-dan-floor-drain-mampet',
        'floor-drain-kamar-mandi' => 'jasa-kamar-mandi-dan-floor-drain-mampet',
        'kuras-grease-trap-lemak' => 'jasa-hydro-jetting-dan-rooter-pipa',
        'hydro-jetting' => 'jasa-hydro-jetting-dan-rooter-pipa',
        'inspeksi-cctv-pipa' => 'jasa-inspeksi-kamera-cctv-pipa',
        'inspeksi-kamera-cctv-pipa' => 'jasa-inspeksi-kamera-cctv-pipa',
        'talang-rooftop-pipa-atap' => 'jasa-talang-air-dan-saluran-utama-mampet',
        'pelancaran-bak-kontrol-mampet' => 'jasa-talang-air-dan-saluran-utama-mampet',
    ];

    /**
     * Get all 6 canonical transactional services definitions.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            'jasa-wastafel-dan-cucian-piring-mampet' => [
                'name' => 'Jasa Wastafel & Bak Cuci Piring Mampet',
                'slug' => 'jasa-wastafel-dan-cucian-piring-mampet',
                'h1' => 'Jasa Pelancaran Wastafel & Bak Cuci Piring Mampet Tanpa Bongkar',
                'meta_title' => 'Jasa Wastafel Mampet & Bak Cuci Piring Tersumbat Lemak | Drainusantara',
                'meta_description' => 'Jasa pelancaran wastafel mampet dan bak cuci piring dapur tersumbat kerak lemak beku tanpa bongkar keramik. Garansi 30 hari & No Cure No Pay. Siaga 24 jam!',
                'price_starting_from' => 400000,
                'badge' => 'Dapur & Kitchen Sink',
                'icon' => 'sink',
                'image' => '/images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'target_keywords' => ['jasa wastafel mampet', 'bak cuci piring mampet', 'lemak beku dapur', 'pelancar wastafel dapur', 'saluran kitchen sink mampet', 'tukang wastafel mampet'],
                'hero_excerpt' => 'Spesialis pelancaran saluran pipa kitchen sink wastafel dapur yang tersumbat gumpalan minyak beku, sisa makanan, dan kerak lemak membatu tanpa zat kimia berbahaya dan tanpa merusak lantai keramik.',
                'symptoms' => [
                    'Air di bak cuci piring mengalir sangat lambat (gurgling) dan mengeluarkan bau busuk',
                    'Air kotor berbusa meluap balik dari leher angsa sifon wastafel ke lantai dapur',
                    'Soda api yang dituangkan justru membeku keras seperti semen di belokan pipa PVC',
                    'Genangan air cucian piring tidak kunjung surut meski sudah disedot plunger karet',
                ],
                'causes' => [
                    'Kristalisasi sisa minyak goreng, mentega, dan santan pada dinding pipa PVC yang dingin',
                    'Penumpukan remah makanan kecil dan ampas kopi yang tersangkut di lekukan leher angsa sifon',
                    'Slope atau kemiringan pipa buangan dapur yang terlalu landai sebelum masuk ke pipa utama',
                    'Residu sabun pencuci piring yang bereaksi dengan partikel lemak membentuk gumpalan keras',
                ],
                'methods' => [
                    'Pembersihan mekanis non-destruktif menggunakan mesin spiral rotary Ridgid USA 400 RPM',
                    'Penggunaan mata auger grease cutter baja yang melumat dan mengikis kerak lilin lemak',
                    'Flushing debit tinggi untuk membilas sisa partikel lemak keluar menuju bak kontrol',
                    'Pemberian nota garansi resmi 30 hari kalender demi jaminan kelancaran jangka panjang',
                ],
                'faqs' => [
                    [
                        'question' => 'Mengapa wastafel cuci piring bisa mampet padahal sudah sering disiram air panas?',
                        'answer' => 'Air panas hanya melunakkan lemak di permukaan leher angsa atas. Saat minyak terbawa beberapa meter ke pipa bawah lantai yang dingin, lemak tersebut membeku kembali dan menempel semakin tebal membentuk sumbatan padat.',
                    ],
                    [
                        'question' => 'Apakah penanganan wastafel dapur ini merusak pipa sifon plastik di bawah sink?',
                        'answer' => 'Tidak. Kabel spiral baja lentur kami memiliki fleksibilitas tinggi yang mampu melewati lengkungan leher angsa sifon plastik PVC tanpa merusak ulir sambungan pipa.',
                    ],
                    [
                        'question' => 'Berapa biaya jasa pelancaran wastafel mampet di Drainusantara?',
                        'answer' => 'Tarif jasa transparan mulai dari Rp 400.000 dengan garansi No Cure No Pay. Jika saluran air gagal mengalir lancar, Anda bebas dari biaya jasa pengerjaan.',
                    ],
                    [
                        'question' => 'Apakah melayani panggilan darurat malam hari untuk resto atau rumah tinggal?',
                        'answer' => 'Ya, tim teknisi kami siaga 24 jam nonstop untuk panggilan perumahan maupun restoran komersial yang membutuhkan penanganan sebelum jam operasional.',
                    ],
                ],
            ],
            'jasa-wc-dan-kloset-mampet' => [
                'name' => 'Jasa WC & Kloset Duduk/Jongkok Mampet',
                'slug' => 'jasa-wc-dan-kloset-mampet',
                'h1' => 'Jasa Pelancaran Kloset & WC Mampet Tanpa Sedot & Tanpa Bongkar',
                'meta_title' => 'Jasa WC Mampet & Kloset Duduk Tersumbat Tanpa Sedot WC | Drainusantara',
                'meta_description' => 'Jasa pelancaran kloset dan WC mampet meluap tanpa sedot tinja dan tanpa bongkar kloset porselen. Pakai spiral baja rotary Ridgid bergaransi resmi 30 hari!',
                'price_starting_from' => 450000,
                'badge' => 'Toilet & Kloset',
                'icon' => 'toilet',
                'image' => '/images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'target_keywords' => ['jasa wc mampet', 'kloset mampet tanpa bongkar', 'jasa wc mampet tanpa sedot', 'toilet duduk mampet', 'kloset jongkok meluap', 'pelancar wc tersumbat'],
                'hero_excerpt' => 'Solusi tuntas kloset duduk dan WC jongkok tersumbat benda asing, pembalut, tisu basah, atau mainan tanpa merusak porselen dan tanpa perlu sedot septic tank.',
                'symptoms' => [
                    'Air di mangkuk kloset naik hampir meluap saat disiram (flush) dan surut sangat lambat',
                    'Terdengar suara letupan udara (gurgling) saat kloset atau kran air dinyalakan',
                    'Bau gas septic tank tercium masuk ke kamar mandi karena leher angsa trap kehilangan air',
                    'Porselen kloset bergoyang atau rembes air di sekeliling lantai dasar kloset duduk',
                ],
                'causes' => [
                    'Benda asing yang tersangkut di trap leher angsa porselen (pembalut, popok, tisu basah tebal, mainan)',
                    'Endapan kerak kapur air tanah dan asam urin yang menyempitkan lubang leher angsa',
                    'Ventilasi pipa hawa septic tank buntu sehingga terjadi tekanan balik udara ke kloset',
                    'Sumbatan di jalur pipa penghubung antara kloset menuju tangki septic tank',
                ],
                'methods' => [
                    'Penetrasi spiral rotary Ridgid khusus kloset (toilet auger) berselubung pelindung vinil porselen',
                    'Mata kait spiral baja (retrieving auger) untuk menarik keluar pembalut, kain, atau mainan',
                    'Pembersihan pipa pembuangan 3-4 inch hingga ke bak kontrol tanpa membongkar baut kloset',
                    'Uji siram debit ganda untuk memastikan daya hisap sifonik kloset kembali sempurna',
                ],
                'faqs' => [
                    [
                        'question' => 'Kapan harus panggil jasa pelancar pipa dibanding panggil mobil sedot WC?',
                        'answer' => 'Jika septic tank Anda belum penuh namun air kloset tidak mau turun, masalahnya terletak pada sumbatan pipa atau trap kloset. Sedot WC tidak menyelesaikan pipa yang tersumbat benda asing atau kerak; Anda membutuhkan jasa mekanis rooter spiral Drainusantara.',
                    ],
                    [
                        'question' => 'Apakah pengerjaan kloset mampet akan menggores porselen kloset duduk?',
                        'answer' => 'Tidak. Kami menggunakan unit toilet auger berpelindung karet/vinil tebal yang menjaga permukaan keramik porselen kloset mewah Anda tetap mulus tanpa goresan.',
                    ],
                    [
                        'question' => 'Berapa tarif pelancaran kloset mampet di Drainusantara?',
                        'answer' => 'Biaya penanganan mulai dari Rp 450.000 dengan sistem No Cure No Pay dan nota garansi 30 hari kalender.',
                    ],
                ],
            ],
            'jasa-kamar-mandi-dan-floor-drain-mampet' => [
                'name' => 'Jasa Kamar Mandi & Floor Drain Mampet',
                'slug' => 'jasa-kamar-mandi-dan-floor-drain-mampet',
                'h1' => 'Jasa Pelancaran Saluran Pembuangan Kamar Mandi & Floor Drain Mampet',
                'meta_title' => 'Jasa Floor Drain Kamar Mandi Mampet & Saluran Menggenang | Drainusantara',
                'meta_description' => 'Jasa pelancaran floor drain kamar mandi mampet akibat rambut dan kerak sabun tanpa bongkar keramik. Respons cepat 24 jam dengan garansi resmi 30 hari!',
                'price_starting_from' => 400000,
                'badge' => 'Kamar Mandi & Lantai',
                'icon' => 'shower',
                'image' => '/images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'target_keywords' => ['saluran pembuangan kamar mandi mampet', 'floor drain menggenang', 'jasa kamar mandi mampet', 'tukang saluran air mandi', 'rambut mampet floor drain'],
                'hero_excerpt' => 'Atasi genangan air sabun di lantai kamar mandi akibat jalinan serat rambut, buih sabun membatu, dan kotoran di leher angsa pipa pembuangan 2 inch.',
                'symptoms' => [
                    'Air mandi menggenang setinggi mata kaki dan butuh waktu berjam-jam untuk surut',
                    'Muncul cacing cacing kecil atau serangga got dari saringan floor drain',
                    'Aroma apek dan bau got menyengat keluar dari lubang pembuangan kamar mandi',
                    'Air buangan kamar mandi meluap keluar ke area kering atau kamar tidur',
                ],
                'causes' => [
                    'Jalinan serat rambut yang mengikat residu sabun mandi dan kondisioner hingga memadat',
                    'Endapan pasir semen sisa renovasi atau tanah yang tersapu ke lubang floor drain',
                    'Sambungan leher angsa trap bawah lantai yang tersumbat kotoran tanpa lubang kontrol',
                    'Kerak kapur kalsium dari air tanah yang mengendap mempersempit diameter pipa 2 inch',
                ],
                'methods' => [
                    'Pemasukan kabel spiral baja lentur berkecepatan 400 RPM langsung dari saringan floor drain',
                    'Mata spiral pancing menarik jalinan rambut dan melumat kerak sabun sampai ke pipa primer',
                    'Pembersihan higienis tanpa menggunakan asam cuka pekat atau soda api korosif',
                    'Garansi resmi 30 hari kalender dan tes kelancaran semprotan air debit maksimal',
                ],
                'faqs' => [
                    [
                        'question' => 'Mengapa rambut di floor drain kamar mandi bisa menjadi sumbatan yang sangat keras?',
                        'answer' => 'Rambut manusia tidak dapat larut oleh air. Ketika rambut bercampur dengan lemak sabun, deterjen, dan mineral air tanah, terbentuk gumpalan keras seperti jaring yang menyumbat seluruh rongga pipa PVC.',
                    ],
                    [
                        'question' => 'Apakah lantai keramik kamar mandi perlu dibobok untuk melancarkan saluran?',
                        'answer' => 'Sama sekali tidak. Teknisi kami bekerja langsung dari lubang saringan floor drain eksisting dengan kabel spiral lentur berdiameter presisi.',
                    ],
                    [
                        'question' => 'Berapa biaya jasa pelancaran saluran kamar mandi mampet?',
                        'answer' => 'Tarif penanganan mulai dari Rp 400.000 dengan jaminan No Cure No Pay.',
                    ],
                ],
            ],
            'jasa-hydro-jetting-dan-rooter-pipa' => [
                'name' => 'Jasa Hydro Jetting & Rooter Pipa',
                'slug' => 'jasa-hydro-jetting-dan-rooter-pipa',
                'h1' => 'Jasa Hydro Jetting Tekanan Tinggi & Rooter Pipa Skala Komersial',
                'meta_title' => 'Jasa Hydro Jetting Pipa & Rooter Kuras Kerak Lemak Resto B2B | Drainusantara',
                'meta_description' => 'Layanan hydro jetting air bertekanan tinggi 200-300 bar dan mesin spiral rooter heavy duty untuk kuras kerak minyak restoran, pabrik, dan gedung komersial.',
                'price_starting_from' => 650000,
                'badge' => 'Komersial B2B & Heavy Duty',
                'icon' => 'jet',
                'image' => '/images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'target_keywords' => ['jasa hydro jetting pipa', 'mesin spiral rooter', 'kuras kerak pipa b2b', 'pembersihan pipa restoran', 'cuci pipa tekanan tinggi', 'hydro jetting jakarta'],
                'hero_excerpt' => 'Teknologi semburan air ultra bertekanan tinggi (Hydro Jetting) hingga 300 bar dan mesin rooter spiral baja industri untuk mengikis kerak lemak jenuh, semen, dan sedimen pipa komersial.',
                'symptoms' => [
                    'Pipa pembuangan restoran atau pabrik sering mampet berulang setiap 1-2 minggu',
                    'Kerak minyak beku di dinding pipa sudah menebal menyerupai pipa batu kapur',
                    'Bak kontrol grease trap komersial meluap dan menghambat operasional jam sibuk',
                    'Diameter pipa 4-8 inch tersumbat lumpur padat, pasir, atau residu limbah produksi',
                ],
                'causes' => [
                    'Volume pembuangan minyak goreng dan kuah berlemak skala masif pada restoran/katering',
                    'Sedimen lumpur dan residu kimia limbah industri yang mengering di dasar pipa',
                    'Pipa lama berdiameter besar yang tidak pernah dilakukan deep cleaning selama bertahun-tahun',
                    'Akar pohon liar yang menerobos masuk melalui celah sambungan pipa pembuangan luar gedung',
                ],
                'methods' => [
                    'Penyemprotan nozzle hydro jetting bertekanan 200-300 bar yang membersihkan 360 derajat dinding pipa',
                    'Penghancuran gumpalan lemak membatu menjadi serpihan mikro yang terbilas tuntas ke saluran umum',
                    'Kombinasi mesin spiral rooter Ridgid K-6200 heavy-duty untuk sumbatan akar pohon dan sedimen',
                    'Inspeksi CCTV pipa IP68 sebelum dan sesudah pengerjaan (before-after quality proof)',
                ],
                'faqs' => [
                    [
                        'question' => 'Apa perbedaan metode spiral mekanis rooter dengan hydro jetting?',
                        'answer' => 'Mesin spiral rooter bekerja menusuk dan memotong sumbatan di titik tertentu, sangat efektif untuk rumah tinggal. Sedangkan Hydro Jetting menggunakan air bertekanan ratusan bar yang menyapu bersih seluruh dinding pipa 360 derajat layaknya pipa baru, ideal untuk restoran, hotel, dan pipa industri.',
                    ],
                    [
                        'question' => 'Apakah semprotan hydro jetting berisiko memecahkan pipa PVC?',
                        'answer' => 'Tidak, teknisi kami mengatur tingkat tekanan semburan sesuai spesifikasi ketebalan pipa (AW / D) dan menggunakan nozzle pemutar khusus yang aman bagi struktur pipa PVC.',
                    ],
                    [
                        'question' => 'Apakah melayani program pemeliharaan saluran rutin (maintenance contract)?',
                        'answer' => 'Ya, kami menyediakan paket kontrak servis berkala (bulanan/triwulanan) untuk restoran F&B, hotel, rumah sakit, dan mal komersial dengan SLA prioritas.',
                    ],
                ],
            ],
            'jasa-inspeksi-kamera-cctv-pipa' => [
                'name' => 'Jasa Inspeksi Kamera CCTV Pipa',
                'slug' => 'jasa-inspeksi-kamera-cctv-pipa',
                'h1' => 'Jasa Inspeksi Kamera CCTV Pipa IP68 Deteksi Titik Mampet & Bocor',
                'meta_title' => 'Jasa Inspeksi Kamera CCTV Pipa IP68 Tanpa Bobok Dinding | Drainusantara',
                'meta_description' => 'Layanan inspeksi visual kamera endoskopi pipa CCTV IP68 hingga panjang 30 meter. Temukan titik pipa pecah, sambungan lepas, atau sumbatan akar secara akurat!',
                'price_starting_from' => 500000,
                'badge' => 'Diagnostik Digital IP68',
                'icon' => 'camera',
                'image' => '/images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'target_keywords' => ['inspeksi kamera pipa cctv ip68', 'deteksi pipa bocor mampet', 'kamera endoskopi pipa', 'jasa cctv saluran pipa', 'cek pipa mampet dengan kamera'],
                'hero_excerpt' => 'Pemeriksaan visual real-time kondisi dalam pipa menggunakan kamera endoskopi tahan air IP68 berlampu LED super terang. Menemukan titik masalah perpipaan secara presisi tanpa membobok sembarangan.',
                'symptoms' => [
                    'Saluran pipa mampet berulang kali di titik yang sama meski sudah sering dilancarkan',
                    'Dugaan pipa PVC pecah, amblas karena pergeseran tanah, atau kemasukan akar tanaman',
                    'Terjadi rembesan air misterius pada dinding atau plafon lantai bawah tanpa tahu sumbernya',
                    'Membutuhkan bukti video visual kondisi pipa sebelum serah terima proyek bangunan / renovasi',
                ],
                'causes' => [
                    'Retakan fisik atau sambungan elbow pipa lepas di bawah struktur lantai beton',
                    'Intrusi akar pohon tropis yang tumbuh menembus celah sambungan pipa PVC luar ruangan',
                    'Kemiringan (slope) pipa yang salah arah atau tertekan tanah amblas sehingga air tertahan',
                    'Benda padat keras (semen, batu koral, alat pertukangan) yang terjepit di tengah pipa',
                ],
                'methods' => [
                    'Pemasukan kabel kamera tahan air IP68 berkepala safir anti-gores hingga jangkauan 30 meter',
                    'Visualisasi layar monitor HD 7 inch untuk melihat langsung kondisi dinding dalam pipa',
                    'Fitur meter counter digital untuk mengukur kedalaman titik masalah dari lubang masuk secara presisi',
                    'Penyimpanan rekaman video teknis dan foto kondisi pipa untuk diserahkan kepada pemilik properti',
                ],
                'faqs' => [
                    [
                        'question' => 'Berapa diameter pipa minimum yang bisa dimasuki kamera CCTV Drainusantara?',
                        'answer' => 'Kamera endoskopi kami dapat bermanuver pada pipa pembuangan berdiameter mulai dari 1.5 inch hingga 8 inch.',
                    ],
                    [
                        'question' => 'Apakah pelanggan akan mendapatkan rekaman video hasil inspeksi kamera pipa?',
                        'answer' => 'Ya, kami menyediakan softcopy file rekaman video resolusi tinggi serta dokumentasi foto titik masalah pipa yang dikirimkan langsung via WhatsApp atau email.',
                    ],
                    [
                        'question' => 'Kapan inspeksi CCTV pipa sangat disarankan?',
                        'answer' => 'Sangat disarankan jika saluran Anda sering mampet kambuh dalam hitungan hari, atau jika ada indikasi kebocoran rembesan air di bawah cor lantai yang sulit dilacak posisinya.',
                    ],
                ],
            ],
            'jasa-talang-air-dan-saluran-utama-mampet' => [
                'name' => 'Jasa Talang Air & Saluran Utama Mampet',
                'slug' => 'jasa-talang-air-dan-saluran-utama-mampet',
                'h1' => 'Jasa Pelancaran Talang Air Atap, Bak Kontrol & Saluran Utama Mampet',
                'meta_title' => 'Jasa Talang Air Mampet, Bak Kontrol & Got Saluran Utama | Drainusantara',
                'meta_description' => 'Jasa pelancaran talang air hujan rooftop, bak kontrol tersumbat, dan saluran pembuangan utama got tanpa bongkar keramik. Garansi resmi 30 hari kalender!',
                'price_starting_from' => 450000,
                'badge' => 'Talang Atap & Bak Kontrol',
                'icon' => 'roof',
                'image' => '/images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'target_keywords' => ['jasa talang air mampet', 'bak kontrol got mampet', 'saluran utama mampet', 'talang rooftop tersumbat', 'pipa vertikal talang air', 'pelancar talang hujan'],
                'hero_excerpt' => 'Cegah luapan air hujan dari plafon dan genangan air kotor di halaman dengan pembersihan tuntas talang rooftop, bak kontrol pembuangan, dan got utama dari daun, lumut, dan sedimen.',
                'symptoms' => [
                    'Air hujan meluap dari talang atap dan merembes menjebol plafon gypsum rumah saat hujan deras',
                    'Bak kontrol di carport atau halaman rumah meluap mengeluarkan air kotor dan bau busuk',
                    'Pipa buangan air vertikal dari rooftop mengalir sangat lambat terdengar bunyi gemuruh',
                    'Saluran got utama komplek tersumbat tumpukan sampah dedaunan dan lumpur tebal',
                ],
                'causes' => [
                    'Gumpalan daun kering, lumut tebal, dan kotoran burung yang terseret air hujan ke corong talang',
                    'Sedimen pasir semen sisa dak atap beton yang mengendap di sambungan belokan pipa vertikal',
                    'Pipa pembuangan horizontal bawah carport amblas atau tertutup cor semen tanpa lubang kontrol',
                    'Intrusi akar tanaman pagar yang menyusup ke sela-sela dinding bak kontrol semen bata',
                ],
                'methods' => [
                    'Penyisiran pipa vertikal talang dari lubang rooftop menggunakan kabel spiral baja lentur',
                    'Mata pengeruk spiral bulb auger menghancurkan sedimen lumut dan mengeluarkan dedaunan busuk',
                    'Pembersihan bak kontrol dan saluran primer got hingga aliran air mengalir deras tanpa hambatan',
                    'Pemberian nota garansi resmi 30 hari kalender pasca uji guyur debit air deras',
                ],
                'faqs' => [
                    [
                        'question' => 'Mengapa talang air hujan rooftop sering kali tersumbat saat hujan deras pertama musim hujan?',
                        'answer' => 'Selama musim kemarau, debu, daun gugur, dan kotoran burung mengering dan menumpuk di permukaan atap. Saat hujan lebat tiba, seluruh kotoran tersebut tersapu serentak ke corong talang dan menyumbat sambungan belokan pertama.',
                    ],
                    [
                        'question' => 'Apakah teknisi bersedia naik ke atap atau dak lantai 2/3 untuk membersihkan talang?',
                        'answer' => 'Ya, teknisi kami dibekali peralatan keselamatan kerja tangga dan pengaman ketinggian untuk mengakses dak rooftop dan membersihkan saluran talang air.',
                    ],
                    [
                        'question' => 'Berapa biaya jasa pelancaran talang air dan saluran utama di Drainusantara?',
                        'answer' => 'Tarif penanganan mulai dari Rp 450.000 dengan jaminan No Cure No Pay dan nota garansi 30 hari.',
                    ],
                ],
            ],
        ];
    }

    /**
     * Resolve service by slug, checking aliases if needed.
     *
     * @return array{service: ?array<string, mixed>, canonical_slug: ?string, should_redirect: bool}
     */
    public static function resolve(string $slug): array
    {
        $all = self::all();

        // 1. Exact match on canonical slug
        if (isset($all[$slug])) {
            return [
                'service' => $all[$slug],
                'canonical_slug' => $slug,
                'should_redirect' => false,
            ];
        }

        // 2. Check alias map
        if (isset(self::SLUG_ALIASES[$slug])) {
            $target = self::SLUG_ALIASES[$slug];
            return [
                'service' => $all[$target] ?? null,
                'canonical_slug' => $target,
                'should_redirect' => true,
            ];
        }

        return [
            'service' => null,
            'canonical_slug' => null,
            'should_redirect' => false,
        ];
    }
}
