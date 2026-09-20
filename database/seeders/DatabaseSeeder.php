<?php
use App\Models\User;
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
        // Seed Admin User for CMS
        \App\Models\User::updateOrCreate(
            ['name' => 'Drainusantara@admin'],
            [
                'name' => 'Drainusantara@admin',
                'email' => 'Drainusantara@admin',
                'password' => \Illuminate\Support\Facades\Hash::make('Drainusantara123'),
                'email_verified_at' => now(),
            ]
        );

        // Seed Services
        $servicesData = [
            [
                'name' => 'Wastafel & Cuci Piring',
                'slug' => 'wastafel-cuci-piring-mampet',
                'short_description' => 'Pelancaran saluran bak cuci piring tersumbat lemak beku dan sisa makanan tanpa bongkar meja dapur.',
                'description' => 'Saluran bak cuci piring (kitchen sink) seringkali tersumbat akibat penumpukan lemak sisa masakan, minyak, dan partikel makanan yang mengeras di dinding pipa. Kami menggunakan mesin spiral fleksibel berkecepatan tinggi untuk mengeruk dan menghancurkan kerak lemak hingga bersih tanpa merusak pipa sifon.',
                'icon' => 'sink',
                'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Wastafel+Mampet',
                'price_starting_from' => 400000,
                'features' => [
                    'Pembersihan kerak lemak membandel',
                    'Kabel spiral baja lentur khusus',
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
                'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Toilet+Kloset+Mampet',
                'price_starting_from' => 400000,
                'features' => [
                    'Tanpa bongkar kloset & keramik',
                    'Daya dorong & pemecah sumbatan kuat',
                    'Teknisi higienis ber-APD steril',
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
                'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Floor+Drain+Mampet',
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
                'name' => 'Inspeksi Kamera CCTV Pipa',
                'slug' => 'inspeksi-kamera-cctv-pipa',
                'short_description' => 'Deteksi akurat titik sumbatan, retakan pipa, patahan, atau sambungan lepas dengan kamera resolusi tinggi hingga 30 meter.',
                'description' => 'Menggunakan teknologi endoscopic pipe camera industri beresolusi tinggi dengan lampu LED penerang dan jangkauan kabel 30 meter. Memungkinkan inspeksi visual kondisi internal pipa secara realtime dengan rekaman video dan foto.',
                'icon' => 'cctv',
                'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Inspeksi+CCTV+Pipa',
                'price_starting_from' => 400000,
                'features' => [
                    'Jangkauan kabel push-rod 30 meter',
                    'Kamera tahan air IP68 dengan LED',
                    'Dokumentasi rekaman video & foto',
                    'Diagnosis masalah tepat sasaran'
                ],
                'is_active' => true,
                'order' => 4,
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
                'service_id' => $sinkService?->id,
                'before_image' => 'https://placehold.co/600x400/334155/ffffff?text=Sebelum:+Kerak+Lemak+Penuh',
                'after_image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Sesudah:+Pipa+Bersih+Lancar',
                'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Wastafel+Dapur+Restoran',
                'description' => 'Pembersihan pipa pembuangan sink dapur sepanjang 12 meter dari endapan minyak beku menggunakan mesin rooter spiral baja tanpa membongkar keramik lantai.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Ekstraksi Benda Asing dari Kloset Duduk',
                'service_id' => $toiletService?->id,
                'before_image' => 'https://placehold.co/600x400/334155/ffffff?text=Sebelum:+Toilet+Meluap',
                'after_image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Sesudah:+Siram+Kencang',
                'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Ekstraksi+Toilet+Duduk',
                'description' => 'Pengambilan mainan dan gumpalan tisu yang menyumbat leher angsa toilet duduk rumah tinggal di Jakarta Selatan dalam 35 menit tanpa melepas kloset.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Pelancaran Floor Drain Kamar Mandi Utama',
                'service_id' => $floorDrainService?->id,
                'before_image' => 'https://placehold.co/600x400/334155/ffffff?text=Sebelum:+Genangan+Buih+Sabun',
                'after_image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Sesudah:+Air+Surut+Cepat',
                'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Floor+Drain+Lancar',
                'description' => 'Penanganan saluran buang kamar mandi tersumbat gumpalan rambut dan kerak busa sabun tebal di apartemen BSD.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Inspeksi Kamera CCTV Pipa Pembuangan Bawah Tanah',
                'service_id' => $cctvService?->id,
                'before_image' => 'https://placehold.co/600x400/334155/ffffff?text=Inspeksi+CCTV:+Titik+Patah',
                'after_image' => 'https://placehold.co/600x400/0284c7/ffffff?text=CCTV:+Pipa+Sesudah+Dibersihkan',
                'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Inspeksi+Kamera+Pipa',
                'description' => 'Deteksi visual pipa saluran air kotor sepanjang 20 meter di ruko perkantoran Semarang. Ditemukan akar pohon menembus sambungan pipa.',
                'order' => 4,
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
    }
}

