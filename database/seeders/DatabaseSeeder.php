<?php

declare(strict_types=1);

use App\Models\User;
use App\Services\CacheService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Services
        $servicesData = [
            [
                'name' => 'Wastafel & Cuci Piring',
                'slug' => 'wastafel-cuci-piring-mampet',
                'short_description' => 'Pelancaran saluran bak cuci piring tersumbat lemak beku dan sisa makanan tanpa bongkar meja dapur.',
                'description' => 'Saluran bak cuci piring (kitchen sink) seringkali tersumbat akibat penumpukan lemak sisa masakan, minyak, dan partikel makanan yang mengeras di dinding pipa. Kami menggunakan mesin spiral fleksibel berkecepatan tinggi untuk mengeruk dan menghancurkan kerak lemak hingga bersih tanpa merusak pipa sifon.',
                'icon' => 'sink',
                'image' => '/images/services/wastafel-cuci-piring-mampet.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Pembersihan kerak lemak membandel',
                    'Kabel spiral baja lentur khusus sifon',
                    'Aman untuk instalasi pipa sifon PVC',
                    'Garansi 30 hari pengerjaan tuntas'
                ],
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Kloset & WC Duduk/Jongkok',
                'slug' => 'kloset-wc-mampet',
                'short_description' => 'Penanganan kloset tersumbat tisu, pembalut, atau benda asing dengan torsi tinggi tanpa melepas kloset.',
                'description' => 'Mengatasi toilet mampet secara cepat dan bersih tanpa harus membongkar lantai keramik atau mencabut kloset. Mesin rooter kami dilengkapi kepala pemotong khusus yang mampu meliuk di lekukan leher angsa kloset dengan aman.',
                'icon' => 'toilet',
                'image' => '/images/services/kloset-wc-mampet.webp',
                'price_starting_from' => 400000,
                'features' => [
                    '100% tanpa bongkar kloset & keramik',
                    'Daya dorong & pemecah sumbatan kuat',
                    'Teknisi higienis ber-APD & cover sepatu',
                    'Garansi 30 hari pengerjaan tuntas'
                ],
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Floor Drain Kamar Mandi',
                'slug' => 'floor-drain-kamar-mandi',
                'short_description' => 'Solusi air menggenang akibat gumpalan rambut, buih sabun, dan kerak kotoran yang menyumbat jalur pembuangan.',
                'description' => 'Air kamar mandi lambat surut atau meluap? Endapan rambut dan buih sabun yang bercampur kotoran seringkali menyumbat saluran pembuangan utama. Kami bersihkan seluruh sumbatan hingga air mengalir lancar seketika.',
                'icon' => 'shower',
                'image' => '/images/services/floor-drain-kamar-mandi.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Menembus endapan rambut & sabun',
                    'Bebas bau got & higienis',
                    'Pengerjaan cepat 30-45 menit',
                    'Garansi 30 hari pengerjaan tuntas'
                ],
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Talang Rooftop & Pipa Atap',
                'slug' => 'talang-rooftop-pipa-atap',
                'short_description' => 'Pipa pembuangan talang atap meluap oleh endapan lumut tebal, pasir dak semen, dan dedaunan kering.',
                'description' => 'Pipa pembuangan talang atap dan dak rooftop tersumbat pasir, lumut, dan dedaunan kering yang memicu rembesan air hujan ke plafon hunian. Kami bersihkan menggunakan spiral jangkauan panjang hingga 30 meter.',
                'icon' => 'roof',
                'image' => '/images/services/talang-rooftop-pipa-atap.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Jangkauan spiral baja hingga 30 meter',
                    'Membersihkan lumpur, lumut & dedaunan',
                    'Mencegah kebocoran plafon rumah',
                    'Garansi 30 hari pengerjaan tuntas'
                ],
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Kuras Grease Trap & Lemak',
                'slug' => 'kuras-grease-trap-lemak',
                'short_description' => 'Pembersihan bak penampung lemak dapur resto, kafe, atau rumah dari kerak minyak padat berbau menyengat.',
                'description' => 'Bak perangkap lemak (grease trap) dapur resto dan ruko cepat penuh kerak minyak padat yang menyumbat saluran buangan komunal. Layanan pengurasan dan pembersihan total siap after-hours dilengkapi faktur pajak dan BAST.',
                'icon' => 'grease',
                'image' => '/images/services/kuras-grease-trap-lemak.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Pembersihan kerak minyak & lemak jenuh',
                    'Layanan after-hours bebas bau menyengat',
                    'Tersedia faktur pajak & dokumen BAST',
                    'Garansi 30 hari pengerjaan tuntas'
                ],
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Inspeksi Kamera CCTV Pipa',
                'slug' => 'inspeksi-kamera-cctv-pipa',
                'short_description' => 'Deteksi akurat titik sumbatan, retakan pipa, patahan, atau sambungan lepas dengan kamera resolusi tinggi hingga 30 meter.',
                'description' => 'Menggunakan teknologi endoscopic pipe camera industri beresolusi tinggi dengan lampu LED penerang dan jangkauan kabel 30 meter. Memungkinkan inspeksi visual kondisi internal pipa secara realtime dengan rekaman video dan foto.',
                'icon' => 'cctv',
                'image' => '/images/services/inspeksi-kamera-cctv-pipa.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Jangkauan kabel push-rod 30 meter',
                    'Kamera tahan air IP68 dengan LED sorot',
                    'Dokumentasi rekaman video & foto MP4',
                    'Diagnosis masalah presisi tanpa tebak'
                ],
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($servicesData as $service) {
            \App\Models\Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        // Seed Reviews
        $wastafelService = \App\Models\Service::where('slug', 'wastafel-cuci-piring-mampet')->first();
        $toiletService = \App\Models\Service::where('slug', 'kloset-wc-mampet')->first();
        $cctvService = \App\Models\Service::where('slug', 'inspeksi-kamera-cctv-pipa')->first();

        $reviewsData = [
            [
                'customer_name' => 'Hendra Gunawan',
                'customer_role_or_location' => 'Kelapa Gading, Jakarta Utara',
                'rating' => 5,
                'comment' => 'Wastafel dapur restoran kami mampet parah pas jam makan siang. Panggil teknisi Drainusantara, 40 menit beres tanpa perlu bongkar keramik kitchen. Air langsung lancar jaya!',
                'service_id' => $wastafelService?->id,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Ibu Ratna Wijaya',
                'customer_role_or_location' => 'BSD City, Tangerang Selatan',
                'rating' => 5,
                'comment' => 'Kloset lantai 2 mampet bikin panik. Teknisi datang tepat waktu, pakai APD rapi, dan mesin spiralnya canggih banget. Sangat profesional dan ada garansi 30 hari resminya.',
                'service_id' => $toiletService?->id,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Budi Santoso',
                'customer_role_or_location' => 'Candisari, Kota Semarang',
                'rating' => 5,
                'comment' => 'Sebelumnya sempat coba pakai soda api malah pipa bunyi kretek dan keluar asap. Untung langsung kontak Drainusantara. Dicek pakai CCTV pipa ketahuan lemaknya mengeras dan langsung dibersihkan tuntas.',
                'service_id' => $cctvService?->id,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Diana Safitri',
                'customer_role_or_location' => 'Kedaton, Bandar Lampung',
                'rating' => 5,
                'comment' => 'Respon WhatsApp super cepat! Teknisi ramah, kerjaan bersih, dan harga transparan sesuai yang diinfokan dari awal. Sangat terbantu!',
                'service_id' => $wastafelService?->id,
                'is_active' => true,
            ],
        ];

        foreach ($reviewsData as $review) {
            \App\Models\Review::updateOrCreate([
                'customer_name' => $review['customer_name'],
                'customer_role_or_location' => $review['customer_role_or_location'],
            ], $review);
        }

        // Seed Coverage Areas (Jabodetabek, Semarang, Bandar Lampung)
        $coverageAreas = [
            // 1. Jakarta Selatan
            [
                'city' => 'Jakarta Selatan',
                'district' => 'Tebet',
                'slug' => 'jakarta-selatan-tebet',
                'postal_code' => '12810',
                'meta_title' => 'Jasa Saluran Mampet di Tebet, Jakarta Selatan - Drainusantara Bergaransi',
                'meta_description' => 'Jasa pelancaran pipa wastafel, toilet, dan floor drain mampet di Tebet, Jakarta Selatan. 100% tanpa bongkar keramik, garansi 30 hari. Teknisi siap meluncur!',
                'content' => 'Layanan darurat penanganan saluran pipa mampet untuk perumahan, apartemen, kafe, dan kantor di area Tebet, Jakarta Selatan dan sekitarnya.',
                'is_active' => true,
            ],
            // 2. Jakarta Timur
            [
                'city' => 'Jakarta Timur',
                'district' => 'Duren Sawit',
                'slug' => 'jakarta-timur-duren-sawit',
                'postal_code' => '13440',
                'meta_title' => 'Jasa Saluran Mampet di Duren Sawit, Jakarta Timur - Drainusantara Bergaransi',
                'meta_description' => 'Solusi saluran pipa mampet di Duren Sawit & Jakarta Timur. Tanpa bongkar lantai, bersih higienis, dan bergaransi resmi 30 hari.',
                'content' => 'Melayani perumahan dan ruko di kawasan Duren Sawit, Jakarta Timur dengan mesin rooter spiral elektrik.',
                'is_active' => true,
            ],
            // 3. Jakarta Utara
            [
                'city' => 'Jakarta Utara',
                'district' => 'Kelapa Gading',
                'slug' => 'jakarta-utara-kelapa-gading',
                'postal_code' => '14240',
                'meta_title' => 'Jasa Saluran Mampet di Kelapa Gading, Jakarta Utara - Drainusantara Bergaransi',
                'meta_description' => 'Spesialis saluran wastafel resto & kloset mampet di Kelapa Gading, Jakarta Utara. Menggunakan mesin spiral & CCTV pipa 30 meter.',
                'content' => 'Layanan cepat untuk perumahan elit dan kawasan kuliner di Kelapa Gading, Jakarta Utara.',
                'is_active' => true,
            ],
            // 4. Jakarta Pusat
            [
                'city' => 'Jakarta Pusat',
                'district' => 'Kemayoran',
                'slug' => 'jakarta-pusat-kemayoran',
                'postal_code' => '10620',
                'meta_title' => 'Jasa Saluran Mampet di Kemayoran, Jakarta Pusat - Drainusantara Bergaransi',
                'meta_description' => 'Jasa saluran pipa tersumbat di Kemayoran & Jakarta Pusat. Tanpa bongkar keramik, teknisi ber-APD, garansi 30 hari.',
                'content' => 'Penanganan pipa apartemen, gedung perkantoran, dan perumahan di kawasan Kemayoran, Jakarta Pusat.',
                'is_active' => true,
            ],
            // 5. Jakarta Barat
            [
                'city' => 'Jakarta Barat',
                'district' => 'Kebon Jeruk',
                'slug' => 'jakarta-barat-kebon-jeruk',
                'postal_code' => '11530',
                'meta_title' => 'Jasa Saluran Mampet di Kebon Jeruk, Jakarta Barat - Drainusantara Bergaransi',
                'meta_description' => 'Pelancaran saluran pipa kitchen sink, kloset, dan floor drain di Kebon Jeruk, Jakarta Barat. Tuntas bergaransi 30 hari.',
                'content' => 'Armada teknisi siaga di area Kebon Jeruk, Puri Kembangan, dan Jakarta Barat.',
                'is_active' => true,
            ],
            // 6. Bogor
            [
                'city' => 'Bogor',
                'district' => 'Cibinong',
                'slug' => 'bogor-cibinong',
                'postal_code' => '16911',
                'meta_title' => 'Jasa Saluran Mampet di Cibinong, Bogor - Drainusantara Bergaransi',
                'meta_description' => 'Jasa pipa mampet profesional di Cibinong & Kota/Kabupaten Bogor. 100% tanpa bongkar keramik, garansi 30 hari.',
                'content' => 'Melayani wilayah Cibinong, Sentul, dan seluruh area Bogor dengan respon cepat.',
                'is_active' => true,
            ],
            // 7. Depok & Cinere
            [
                'city' => 'Depok & Cinere',
                'district' => 'Cinere',
                'slug' => 'depok-cinere-cinere',
                'postal_code' => '16514',
                'meta_title' => 'Jasa Saluran Mampet di Cinere, Depok & Cinere - Drainusantara Bergaransi',
                'meta_description' => 'Solusi ahli pipa wastafel & kloset tersumbat di kawasan Cinere, Margonda, dan seluruh Depok. Bergaransi 30 hari.',
                'content' => 'Penanganan saluran pipa mampet untuk perumahan di Cinere dan Depok.',
                'is_active' => true,
            ],
            // 8. Tangerang Kota
            [
                'city' => 'Tangerang Kota',
                'district' => 'Cipondoh',
                'slug' => 'tangerang-kota-cipondoh',
                'postal_code' => '15148',
                'meta_title' => 'Jasa Saluran Mampet di Cipondoh, Tangerang Kota - Drainusantara Bergaransi',
                'meta_description' => 'Teknisi rooter pipa mampet di Cipondoh, Karawaci, Ciledug, Tangerang Kota. Tanpa bongkar, garansi 30 hari.',
                'content' => 'Layanan pelancaran saluran air kotor dan pembuangan di wilayah Tangerang Kota.',
                'is_active' => true,
            ],
            // 9. Tangerang Selatan
            [
                'city' => 'Tangerang Selatan',
                'district' => 'Serpong',
                'slug' => 'tangerang-selatan-serpong',
                'postal_code' => '15310',
                'meta_title' => 'Jasa Saluran Mampet di Serpong, Tangerang Selatan - Drainusantara Bergaransi',
                'meta_description' => 'Teknisi ahli saluran pipa mampet di Serpong, BSD City, Bintaro, Tangerang Selatan. Tanpa bongkar lantai, bergaransi resmi 30 hari.',
                'content' => 'Layanan pelancaran pipa got, wastafel, dan WC di perumahan Serpong, BSD City, dan Tangerang Selatan.',
                'is_active' => true,
            ],
            // 10. Bekasi & Cikarang
            [
                'city' => 'Bekasi & Cikarang',
                'district' => 'Cikarang Selatan',
                'slug' => 'bekasi-cikarang-cikarang-selatan',
                'postal_code' => '17530',
                'meta_title' => 'Jasa Saluran Mampet di Cikarang Selatan, Bekasi & Cikarang - Drainusantara Bergaransi',
                'meta_description' => 'Jasa pelancaran pipa saluran mampet perumahan dan kawasan industri di Cikarang & Bekasi. Garansi 30 hari.',
                'content' => 'Armada teknisi siaga di Bekasi Barat, Tambun, dan Cikarang.',
                'is_active' => true,
            ],
            // 11. Kota Semarang
            [
                'city' => 'Kota Semarang',
                'district' => 'Candisari',
                'slug' => 'kota-semarang-candisari',
                'postal_code' => '50257',
                'meta_title' => 'Jasa Saluran Mampet di Candisari, Kota Semarang - Drainusantara Bergaransi',
                'meta_description' => 'Jasa pipa mampet profesional di Candisari, Kota Semarang. Tanpa soda api, tanpa bongkar keramik, garansi 30 hari.',
                'content' => 'Armada teknisi siaga di area Candisari, Banyumanik, dan seluruh Kota Semarang.',
                'is_active' => true,
            ],
            // 12. Bandar Lampung
            [
                'city' => 'Bandar Lampung',
                'district' => 'Kedaton',
                'slug' => 'bandar-lampung-kedaton',
                'postal_code' => '35141',
                'meta_title' => 'Jasa Saluran Mampet di Kedaton, Bandar Lampung - Drainusantara Bergaransi',
                'meta_description' => 'Spesialis saluran wastafel dan WC mampet di Kedaton, Bandar Lampung. Pengerjaan mekanis spiral bergaransi 30 hari.',
                'content' => 'Solusi tuntas pipa mampet untuk perumahan, ruko, dan tempat usaha di kawasan Kedaton dan Kota Bandar Lampung.',
                'is_active' => true,
            ],
        ];

        foreach ($coverageAreas as $area) {
            \App\Models\CoverageArea::updateOrCreate(['slug' => $area['slug']], $area);
        }

        // Seed Galleries / Portfolios
        $sinkService = \App\Models\Service::where('slug', 'wastafel-cuci-piring-mampet')->first();
        $toiletService = \App\Models\Service::where('slug', 'kloset-wc-mampet')->first();
        $floorDrainService = \App\Models\Service::where('slug', 'floor-drain-kamar-mandi')->first();
        $cctvService = \App\Models\Service::where('slug', 'inspeksi-kamera-cctv-pipa')->first();

        $galleriesData = [
            [
                'title' => 'Pelancaran Pipa Wastafel Dapur Restoran',
                'category' => 'b2b',
                'service_id' => $sinkService?->id,
                'image' => '/images/dokumentasi/pelancar-saluran-gutter-resto-jakarta.webp',
                'description' => 'Pembersihan pipa pembuangan sink dapur sepanjang 12 meter dari endapan minyak beku menggunakan mesin rooter spiral baja tanpa membongkar keramik lantai.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Ekstraksi Benda Asing dari Kloset Duduk Hunian',
                'category' => 'rumahan',
                'service_id' => $toiletService?->id,
                'image' => '/images/dokumentasi/pelancar-saluran-kloset-toilet-mampet.webp',
                'description' => 'Penarikan mainan dan gumpalan tisu yang menyumbat leher angsa toilet duduk rumah tinggal di Jakarta Selatan dalam 35 menit tanpa melepas kloset.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Pelancaran Floor Drain Kamar Mandi Utama',
                'category' => 'rumahan',
                'service_id' => $floorDrainService?->id,
                'image' => '/images/dokumentasi/pelancar-mesin-ridgid-floor-drain-kamar-mandi.webp',
                'description' => 'Penanganan saluran buang kamar mandi tersumbat gumpalan rambut dan kerak busa sabun tebal di perumahan BSD Tangerang Selatan.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Inspeksi Kamera CCTV Pipa Bawah Tanah Ruko Kantor',
                'category' => 'b2b',
                'service_id' => $cctvService?->id,
                'image' => '/images/dokumentasi/inspeksi-kamera-cctv-pipa-tersumbat.webp',
                'description' => 'Deteksi visual pipa saluran air kotor sepanjang 20 meter di ruko perkantoran Semarang. Ditemukan akar pohon menembus sambungan pipa.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Kuras Grease Trap & Sedot Lemak Kafe Komersial',
                'category' => 'b2b',
                'service_id' => $sinkService?->id,
                'image' => '/images/dokumentasi/pembersihan-grease-trap-restoran.webp',
                'description' => 'Pembersihan kerak minyak jenuh dan lumpur sisa olahan makanan pada bak perangkap lemak dapur kafe komersial di Kelapa Gading.',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Pelancaran Pipa Talang Air Hujan Rooftop Hunian',
                'category' => 'rumahan',
                'service_id' => $floorDrainService?->id,
                'image' => '/images/dokumentasi/pelancar-bak-kontrol-perumahan-warga.webp',
                'description' => 'Penembusan kabel spiral baja lentur 22mm pada pipa talang tegak rumah tinggal yang tersumbat endapan lumut dan dedaunan kering di Tebet.',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($galleriesData as $item) {
            \App\Models\Gallery::updateOrCreate(['title' => $item['title']], $item);
        }

        // Seed Articles / Education
        $articlesData = [
            [
                'title' => 'Bahaya Menggunakan Soda Api untuk Saluran Mampet',
                'slug' => 'bahaya-menggunakan-soda-api-saluran-mampet',
                'thumbnail' => 'https://placehold.co/800x500/0369a1/ffffff?text=Bahaya+Soda+Api',
                'category' => 'Tips & Edukasi',
                'excerpt' => 'Banyak orang tergoda menuang soda api saat wastafel mampet. Padahal, reaksi kimianya berisiko melelehkan pipa PVC dan mengeraskan lemak menjadi gips.',
                'content' => "Soda api (Natrium Hidroksida / NaOH) kerap dianggap sebagai solusi instan murah ketika saluran pembuangan air tersumbat. Namun, dalam dunia perpipaan profesional, soda api adalah salah satu musuh terbesar instalasi pipa modern.\n\n### 1. Suhu Panas Ekstrem Melelehkan Pipa PVC\nReaksi eksotermik antara soda api dan air menghasilkan suhu sangat tinggi (mencapai lebih dari 100°C). Pipa PVC standar rumah tangga tidak dirancang menahan suhu setinggi ini, sehingga dinding pipa bisa melengkung, retak, atau sambungan lemnya meleleh bocor ke bawah lantai.\n\n### 2. Lemak Malah Membatu (Saponifikasi)\nKetika soda api bereaksi dengan minyak dan lemak goreng di dalam pipa dapur, proses safonifikasi mengubah lemak menjadi gumpalan sabun keras seperti batu kapur. Bukannya lancar, sumbatan justru menjadi keras seperti beton dan mustahil dilarutkan air biasa.\n\n### 3. Risiko Ledakan Kimia & Bahaya Fisik\nUap soda api beracun bagi pernapasan dan percikan air panasnya dapat menyebabkan luka bakar kimia permanen pada kulit serta kebutaan jika mengenai mata teknisi atau pemilik rumah.\n\n### Solusi yang Benar\nGunakan pembersihan mekanik seperti kabel spiral (drain auger / rooter) yang bekerja secara mekanis mengikis kotoran tanpa bahan kimia perusak pipa.",
                'meta_title' => 'Bahaya Menggunakan Soda Api untuk Saluran Mampet - Edukasi Drainusantara',
                'meta_description' => 'Ketahui risiko fatal soda api pada pipa PVC rumah: pipa melengkung, bocor, dan lemak membatu. Gunakan mesin mekanis spiral yang aman.',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => '5 Kebiasaan Sepele Penyebab Utama Bak Cuci Piring Tersumbat',
                'slug' => '5-kebiasaan-penyebab-bak-cuci-piring-tersumbat',
                'thumbnail' => 'https://placehold.co/800x500/0284c7/ffffff?text=Penyebab+Sink+Mampet',
                'category' => 'Perawatan Rumah',
                'excerpt' => 'Minyak jelantah hingga ampas kopi sering dianggap sepele saat dibuang ke sink. Simak cara merawat saluran wastafel dapur agar tetap awet bertahun-tahun.',
                'content' => "Dapur adalah jantung dari setiap rumah dan usaha kuliner. Namun, saluran cuci piring adalah yang paling rentan mampet karena intensitas penggunaannya yang tinggi.\n\n### 1. Menuang Minyak Jelantah ke Sink\nMinyak cair saat panas akan membeku saat bertemu dengan air dingin di dalam pipa bawah tanah. Lapisan lemak ini menumpuk lapis demi lapis seperti kolesterol pada pembuluh darah.\n\n### 2. Membuang Ampas Kopi & Teh\nBubuk ampas kopi tidak larut dalam air dan memiliki sifat padat yang mudah tersangkut di lekukan leher angsa pipa sifon.\n\n### 3. Sisa Nasi & Tepung Adonan\nTepung dan nasi akan mengembang saat terendam air dan membentuk pasta lengket yang memerangkap kotoran lain.\n\n### Tips Perawatan Berkala\nSiram wastafel dengan air panas mendidih seminggu sekali dan pasang saringan kawat halus (sink strainer) untuk menangkap kotoran padat sebelum masuk ke saluran utama.",
                'meta_title' => '5 Penyebab Bak Cuci Piring Tersumbat & Solusinya - Drainusantara',
                'meta_description' => 'Panduan merawat wastafel dapur bebas mampet. Hindari minyak jelantah dan ampas kopi agar saluran pipa tetap lancar.',
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Kapan Saluran Pipa Membutuhkan Inspeksi Kamera CCTV?',
                'slug' => 'kapan-saluran-pipa-butuh-inspeksi-kamera-cctv',
                'thumbnail' => 'https://placehold.co/800x500/075985/ffffff?text=Inspeksi+Kamera+CCTV',
                'category' => 'Teknologi Plumbing',
                'excerpt' => 'Jika saluran pipa Anda mampet berulang kali meski sudah berulang kali dibersihkan, kemungkinan ada patahan atau akar pohon di dalam tanah.',
                'content' => "Masalah pipa mampet yang kambuh setiap 2-3 minggu adalah sinyal bahwa ada kerusakan struktural di dalam jalur pipa yang tidak terlihat dari permukaan.\n\n### Manfaat Inspeksi CCTV Pipa:\n- **Melihat Kondisi Nyata di Dalam Pipa:** Kamera resolusi tinggi dengan lampu LED anti-air dapat menjangkau hingga 30 meter di dalam tanah.\n- **Menemukan Titik Patah Pipa:** Mengetahui koordinat tepat pipa pecah atau amblas akibat pergeseran tanah tanpa harus membongkar seluruh lantai keramik rumah.\n- **Mendeteksi Intrusi Akar:** Akar pohon dapat merayap masuk melalui pori-pori sambungan pipa semen/PVC dan berkembang biak di dalamnya.\n\nDrainusantara menyediakan layanan inspeksi endoscopic CCTV pipa lengkap dengan rekaman video dan laporan teknis.",
                'meta_title' => 'Kapan Saluran Pipa Butuh Inspeksi Kamera CCTV? - Drainusantara',
                'meta_description' => 'Deteksi masalah saluran pipa mampet kronis dengan endoscopic pipe camera resolusi tinggi hingga 30 meter.',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($articlesData as $art) {
            \App\Models\Article::updateOrCreate(['slug' => $art['slug']], $art);
        }

        // Seed Standar Equipments
        $equipmentsData = [
            [
                'name' => 'Mesin Drain Rooter Spiral Baja Rotary Ridgid K-50 & K-60',
                'category' => 'Mesin Utama',
                'badge' => '100% Mekanis',
                'image' => '/assets/TOOLKIT/mesin-spiral-rotary.webp',
                'short_description' => 'Kabel spiral lentur berinti baja karbon berputar 400 RPM untuk meluncur di leher angsa dan mengikis endapan tanpa merusak pipa.',
                'specs' => [
                    'Jangkauan: Hingga 30 meter sambung modular',
                    'Diameter Pipa: Efektif untuk pipa 1.5 sampai 6 inci',
                    'Aksi Kerja: Mengikis lemak padat, menarik rambut, dan memotong akar',
                    'Tenaga: Motor Listrik 220V 400 RPM Standard Industri'
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Kamera CCTV Endoskopi Pipa IP68 30 Meter',
                'category' => 'Diagnosis Visual',
                'badge' => 'Diagnosis Visual',
                'image' => '/assets/TOOLKIT/kamera-cctv-pipa.webp',
                'short_description' => 'Unit kamera industri tahan air beresolusi tinggi dengan lampu LED sorot adjustable dan kabel dorong fleksibel kaku untuk melihat langsung kondisi dalam pipa.',
                'specs' => [
                    'Jangkauan Inspeksi: Kabel push-rod fiberglass 30 meter',
                    'Pencahayaan: 12 LED ultra-bright dengan lensa safir anti-gores',
                    'Dokumentasi: Rekaman video MP4 & foto resolusi tinggi untuk klien',
                    'Ketahanan: IP68 Submersible Tahan Tekanan Air'
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Unit Pembersih Saluran High Pressure Hydro Jetting',
                'category' => 'Hydro Jetting',
                'badge' => 'Tekanan Tinggi',
                'image' => '/assets/TOOLKIT/hydro-jetting.webp',
                'short_description' => 'Semburan air bertekanan tinggi 100-200 bar untuk mengikis dan membilas tumpukan minyak beku, kerak lumpur, dan lemak pada restoran dan industri.',
                'specs' => [
                    'Tekanan Air: 100 - 200 Bar nozel multifungsi',
                    'Target Masalah: Grease trap, pipa dapur resto, sedimentasi pasir',
                    'Hasil: Dinding pipa bersih total seperti baru dipasang',
                    'Metode: 100% Eco-Friendly tanpa bahan kimia korosif'
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Set 4 Jenis Mata Pemotong Spiral Baja Modular',
                'category' => 'Mata Cutter',
                'badge' => '4 Tipe Cutter',
                'image' => '/assets/TOOLKIT/cutter-mata-spiral.webp',
                'short_description' => '4 mata cutter baja karbon tempa khusus: Bulb Auger (rambut/tisu), Grease Cutter (lemak), Spade Cutter (kerak lumpur), dan Sawtooth Root Cutter (akar).',
                'specs' => [
                    'Bulb Auger: Fleksibel meliuk leher angsa wastafel & kloset',
                    'Grease Cutter: Mata pisau pengikis kerak minyak jenuh',
                    'Spade Cutter: Pisau pipih mengikis semen, pasir & lumpur',
                    'Root Cutter: Gigi gergaji melingkar pemotong akar pohon'
                ],
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($equipmentsData as $equip) {
            \App\Models\Equipment::updateOrCreate(['name' => $equip['name']], $equip);
        }

        CacheService::clearPublicCache();
    }
}

