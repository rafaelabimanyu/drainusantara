<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class HyperLocalTaxonomy
{
    /**
     * Typology definitions with rich contextual technical plumbing profiles.
     */
    public const TYPOLOGIES = [
        'kuliner_komersial' => [
            'label' => 'Sentra Kuliner, Kafe & Ruko Komersial F&B',
            'dominant_buildings' => 'Restoran & Bistro, Kafe Modern, Ruko Kuliner, Warung Makan & Cloud Kitchen',
            'problem_desc' => 'Tingginya aktivitas pengolahan makanan dan pencucian perlengkapan dapur di sentra kuliner [KECAMATAN], [KOTA] memicu penumpukan minyak jenuh dan lemak hewani di dalam pipa wastafel (kitchen sink). Lemak yang mendingin mengeras membentuk kerak lilin padat di sambungan leher angsa sifon dan bak kontrol grease trap.',
            'problem_detail' => 'Upaya pembersihan mandiri menggunakan air panas atau zat kimia kaustik sering kali hanya mendorong gumpalan lemak beku ke pipa utama yang lebih dalam, hingga akhirnya memadat menjadi sumbatan total yang meluap ke lantai dapur operasional.',
            'dispatch_desc' => 'Posko teknisi siaga di koridor [KOTA] meluncur dalam estimasi 25–40 menit dengan perlengkapan lengkap, siap merespons panggilan darurat sebelum jam operasional atau saat puncak layanan resto.',
            'solution_desc' => 'Unit mesin spiral rooter rotary berkecepatan 400 RPM dengan mata pisau pemotong lemak baja (grease cutter auger) melumat dan mengikis kerak lemak hingga dinding pipa PVC bersih tuntas tanpa zat kimia korosif.',
            'solution_detail' => 'Pengerjaan 100% bebas bongkar ubin/keramik lantai. Disertai uji debit aliran air penuh dan garansi resmi tertulis 30 hari kalender.',
            'faqs' => [
                [
                    'question' => 'Mengapa saluran wastafel dapur di ruko/rumah area [KECAMATAN] sangat mudah tersumbat lemak membatu?',
                    'answer' => 'Sisa minyak goreng, kuah makanan bersantan, dan lemak hewani mudah mengkristal saat bersentuhan dengan dinding pipa PVC yang dingin di bawah lantai. Endapan ini mengeras menyerupai batu lilin yang menyempitkan diameter pipa hingga aliran air macet total.',
                ],
                [
                    'question' => 'Apakah penanganan saluran grease trap dan wastafel di [KECAMATAN] bisa dilakukan tanpa mengganggu pelanggan resto?',
                    'answer' => 'Bisa. Teknisi kami bekerja cepat dan rapi menggunakan mesin spiral elektrik yang senyap (low noise) tanpa palu atau bobok keramik. Kami juga melayani jadwal penanganan di luar jam operasional resto.',
                ],
                [
                    'question' => 'Berapa biaya pelancaran pipa lemak dapur di [KECAMATAN], [KOTA]?',
                    'answer' => 'Biaya transparan mulai dari [HARGA] dengan prinsip No Cure No Pay. Jika saluran air dapur gagal mengalir plong lancar, Anda bebas dari biaya jasa pengerjaan.',
                ],
            ],
        ],
        'residensial_klaster' => [
            'label' => 'Kawasan Perumahan Klaster Modern & Townhouse',
            'dominant_buildings' => 'Rumah Klaster Modern, Townhouse 2-3 Lantai, Residensial Real Estate & Hunian Pribadi',
            'problem_desc' => 'Instalasi pipa air kotor di klaster perumahan modern [KECAMATAN], [KOTA] umumnya memiliki banyak belokan siku (elbow 90 derajat) tertanam di bawah lantai carport beton atau taman depan. Aliran buangan wastafel dan kamar mandi kerap terperangkap oleh gumpalan serat rambut dan residu deterjen/sabun yang mengendap sebelum mencapai bak kontrol.',
            'problem_detail' => 'Banyak penghuni klaster mencoba menuangkan soda api yang justru bereaksi eksotermik membakar sambungan fitting PVC dan mengeras seperti semen cor di dalam pipa bawah carport yang sulit dibongkar.',
            'dispatch_desc' => 'Armada teknisi bergerak cepat melalui akses jalan utama menuju seluruh perumahan dan klaster di [KECAMATAN] dengan estimasi tiba 30–45 menit pasca pemesanan via WhatsApp.',
            'dispatch_detail' => 'Teknisi bersepatu pelindung (cover shoes) dan menggunakan alas kerja steril agar lantai carport dan interior hunian klaster tetap bersih higienis.',
            'solution_desc' => 'Kabel spiral baja elastis Ridgid USA berkemampuan meliuk melewati 4-5 sambungan siku pipa PVC hingga jarak 30 meter, membebaskan sumbatan tanpa merusak keramik lantai atau membobok carport beton.',
            'solution_detail' => 'Pembersihan mekanis non-destruktif berstandar modern bergaransi 30 hari kalender, memberikan ketenangan jangka panjang bagi keluarga Anda.',
            'faqs' => [
                [
                    'question' => 'Apakah pipa saluran mampet di bawah carport cor klaster [KECAMATAN] harus dibongkar?',
                    'answer' => 'Sama sekali tidak perlu dibongkar. Kabel spiral fleksibel kami dirancang khusus untuk meliuk melewati belokan pipa PVC di bawah lantai beton dan carport tanpa merusak struktur lantai hunian klaster Anda.',
                ],
                [
                    'question' => 'Bagaimana jika saluran pipa mampet kembali dalam masa garansi di [KECAMATAN]?',
                    'answer' => 'Setiap pengerjaan dilindungi nota digital garansi resmi 30 hari kalender. Jika terjadi kendala berulang pada titik pengerjaan yang sama, teknisi kami meluncur kembali untuk perbaikan tuntas tanpa biaya tambahan.',
                ],
                [
                    'question' => 'Berapa lama teknisi tiba di perumahan area [KECAMATAN], [KOTA]?',
                    'answer' => 'Teknisi posko armada siaga [KOTA] meluncur ke alamat Anda dengan estimasi tiba 30–45 menit setelah konfirmasi via chat WhatsApp.',
                ],
            ],
        ],
        'pemukiman_padat' => [
            'label' => 'Pemukiman Padat Penduduk & Perkotaan Terpadu',
            'dominant_buildings' => 'Rumah Tinggal Perkampungan Kota, Ruko Warung, Rumah Kos & Hunian Tradisional',
            'problem_desc' => 'Jalur pembuangan sanitasi di pemukiman padat [KECAMATAN], [KOTA] sering kali memiliki elevasi kemiringan (slope) pipa yang sangat landai atau menyatu dengan saluran pembuangan bersama. Kondisi ini membuat endapan pasir saluran, kerak sabun kamar mandi, dan kotoran rumah tangga mudah mengendap dan memicu luapan air kotor ke lantai rumah saat debit tinggi.',
            'problem_detail' => 'Ruang gerak yang terbatas di gang pemukiman menyulitkan alat berat konvensional. Penanganan membutuhkan mesin portabel berkecepatan tinggi yang dapat beroperasi fleksibel di ruang sempit.',
            'dispatch_desc' => 'Teknisi siaga armada roda dua dan unit mobile gesit siap bermanuver ke gang-gang pemukiman di seluruh kelurahan [KECAMATAN] dalam 20–35 menit.',
            'dispatch_detail' => 'Peralatan ringkas namun bertenaga rotary tinggi, mampu menembus titik sumbatan pipa dari lubang kontrol terkecil di teras atau kamar mandi rumah.',
            'solution_desc' => 'Mata spiral rotary baja memutar dan mendorong gumpalan kotoran serta serat kain/rambut keluar ke saluran umum tanpa perlu membongkar lantai teras atau kamar mandi.',
            'solution_detail' => 'Sistem pembiayaan transparan No Cure No Pay: apabila air kotor gagal mengalir plong, pemilik rumah tidak dikenakan biaya jasa.',
            'faqs' => [
                [
                    'question' => 'Apakah teknisi Drainusantara bisa menjangkau rumah di gang sempit pemukiman [KECAMATAN]?',
                    'answer' => 'Tentu bisa. Teknisi armada kami dibekali unit mesin spiral elektrik portabel yang sangat fleksibel menjangkau pemukiman padat dan rumah di dalam gang tanpa kendala mobilitas.',
                ],
                [
                    'question' => 'Bagaimana jika kloset atau saluran pembuangan di [KECAMATAN] sudah mampet berhari-hari?',
                    'answer' => 'Segera hubungi tim kami. Mesin rotary kami memiliki daya putar 400 RPM berdaya tembus tinggi yang mampu melancarkan sumbatan menahun dalam waktu 30–45 menit pengerjaan.',
                ],
                [
                    'question' => 'Apakah aman menggunakan soda api untuk saluran mampet di [KECAMATAN]?',
                    'answer' => 'Kami sangat tidak menyarankan soda api karena panas kimianya dapat melunakkan dan membengkokkan sambungan pipa PVC tipis, serta berisiko membeku menyerupai batu jika mengendap.',
                ],
            ],
        ],
        'bisnis_perkantoran' => [
            'label' => 'Kawasan Pusat Bisnis, Perkantoran & Gedung Komersial',
            'dominant_buildings' => 'Gedung Kantor, Co-Working Space, Apartemen Vertikal, Ruko Perbankan & Sentra Niaga',
            'problem_desc' => 'Aktivitas sanitasi dengan volume pemakaian sangat tinggi di kawasan niaga dan perkantoran [KECAMATAN], [KOTA] memicu penumpukan kerak asam urin (uric acid), puntung rokok, dan gumpalan tisu basah di saluran urinoir dan kloset gedung. Pada jalur pipa tegak (stack pipe) vertikal, kerak endapan mempersempit debit buangan antar lantai.',
            'problem_detail' => 'Masalah pipa di properti komersial membutuhkan standar penanganan profesional yang cepat, senyap, higienis, dan tidak mencemari aroma area kerja karyawan maupun lobi gedung.',
            'dispatch_desc' => 'Armada servis siaga prioritas siap tiba di lobi perkantoran atau ruko bisnis [KECAMATAN] dalam 20–35 menit dengan SOP berpakaian rapi dan mengenakan APD higienis.',
            'dispatch_detail' => 'Dukungan administrasi korporat lengkap: invoice resmi, faktur pajak PT Jawa Jaya Rooter, dan nota garansi tertulis.',
            'solution_desc' => 'Kombinasi kamera inspeksi CCTV IP68 endoskopi 30 meter untuk memetakan titik sumbatan pipa vertikal dan horizontal, disusul rotasi spiral baja torsi tinggi untuk merontokkan kerak tanpa merusak porselen urinoir.',
            'solution_detail' => 'Penanganan higienis steril tanpa bau bahan kimia menyengat, menjaga kenyamanan operasional bisnis dan citra profesional perusahaan.',
            'faqs' => [
                [
                    'question' => 'Apakah Drainusantara melayani perawatan saluran pipa berkala untuk kantor dan ruko di [KECAMATAN]?',
                    'answer' => 'Ya, kami melayani kemitraan B2B untuk pembersihan saluran pipa preventif berkala gedung perkantoran, perbankan, dan restoran komersial dengan kontrak SLA terukur.',
                ],
                [
                    'question' => 'Apakah pengerjaan di kawasan perkantoran [KECAMATAN] dilengkapi invoice dan dokumen legalitas resmi?',
                    'answer' => 'Pasti. Setiap order komersial didukung invoice resmi, kwitansi perusahaan, dan laporan teknis berbadan hukum resmi PT Jawa Jaya Rooter.',
                ],
                [
                    'question' => 'Berapa lama pengerjaan pipa urinoir atau kloset kantor yang mampet di [KECAMATAN]?',
                    'answer' => 'Rata-rata pengerjaan tuntas dalam 30–50 menit menggunakan mesin spiral mekanis modern tanpa membongkar lantai keramik atau dinding shaft pipa.',
                ],
            ],
        ],
        'industri_pesisir' => [
            'label' => 'Kawasan Industri, Pergudangan & Koridor Pesisir Arteri',
            'dominant_buildings' => 'Pabrik Manufaktur, Kompleks Pergudangan Logistik, Depo Transportasi & Ruko Arteri Pantura',
            'problem_desc' => 'Karakteristik tanah dan lingkungan di koridor industri dan pesisir [KECAMATAN], [KOTA] menghadirkan tantangan intrusi sedimen lumpur pasang rob, endapan pasir dak beton, serta residu minyak/pelumas mesin yang masuk ke saluran pembuangan utama. Sedimen padat ini menumpuk di bak kontrol primer dan memperlambat pembuangan air limbah operasional.',
            'problem_detail' => 'Saluran limbah berdiameter besar (3 hingga 6 inch) memerlukan peralatan heavy-duty bertorsi tinggi yang sanggup mendorong endapan lumpur pekat keluar menuju saluran primer luar kawasan.',
            'dispatch_desc' => 'Unit armada mobil operasional dengan mesin heavy-duty bergerak langsung melalui akses tol arteri menuju kawasan pergudangan dan pabrik di [KECAMATAN] dalam 30–45 menit.',
            'dispatch_detail' => 'Teknisi tersertifikasi dibekali perlengkapan APD standar K3 industri: helm safety, rompi reflektor, sarung tangan khusus, dan sepatu boot.',
            'solution_desc' => 'Unit mesin spiral rotary heavy-duty Ridgid K-6200 bermata auger cakar baja memecah dan mengeruk sedimentasi lumpur, kerak pasir, dan gumpalan limbah padat tanpa membobok lantai beton pabrik.',
            'solution_detail' => 'Menghindarkan terhentinya operasional produksi pabrik (zero downtime), aman bagi pipa PVC maupun cor bertulang, dan bergaransi resmi 30 hari.',
            'faqs' => [
                [
                    'question' => 'Apakah mesin Drainusantara mampu membersihkan pipa diameter besar di pabrik atau gudang [KECAMATAN]?',
                    'answer' => 'Sangat mampu. Kami memiliki armada unit heavy-duty Ridgid berdiameter kabel spiral hingga 3/4 inch yang dirancang melancarkan pipa pembuangan utama 3 hingga 6 inch sejauh 30 meter.',
                ],
                [
                    'question' => 'Apakah pengerjaan di [KECAMATAN] memenuhi standar kepatuhan K3 keselamatan kerja industri?',
                    'answer' => 'Ya, seluruh teknisi kami bekerja berpedoman pada SOP K3 ketat menggunakan perlengkapan APD lengkap dan alat mekanis non-destruktif berisolasi listrik aman.',
                ],
                [
                    'question' => 'Bagaimana mengatasi saluran pipa mampet akibat endapan pasir lumpur pasang rob di [KECAMATAN]?',
                    'answer' => 'Mata spiral bulb auger khusus kami bekerja memecah partikel pasir dan lumpur yang memadat di dasar pipa sehingga dapat terbilas keluar menuju saluran pembuangan kota.',
                ],
            ],
        ],
    ];

    /**
     * Dictionary of authentic landmarks, kelurahan, and prominent streets per district.
     *
     * @var array<string, array<int, string>>
     */
    public static array $districtLandmarks = [
        // --- JAKARTA SELATAN ---
        'tebet' => ['Tebet Barat', 'Tebet Timur', 'Kebon Baru', 'Bukit Duri', 'Manggarai Selatan', 'Menteng Dalam', 'Jl. Tebet Raya', 'Kawasan Kuliner Tebet Eco Park'],
        'kebayoran-baru' => ['Senopati & Suryo', 'Blok M & Melawai', 'Gunawarman & Wolter Monginsidi', 'Gandaria Utara & Selatan', 'Pulo & Petogogan', 'Kramat Pela', 'Selong', 'Rawa Barat'],
        'kebayoran-lama' => ['Pondok Pinang', 'Cipulir', 'Grogol Utara & Selatan', 'Kebayoran Lama Utara & Selatan', 'Gandaria City Area', 'Jl. Arteri Pondok Indah'],
        'cilandak' => ['Cilandak Barat & Timur', 'Cipete Selatan', 'Gandaria Selatan', 'Lebak Bulus', 'Kawasan Cilandak Town Square', 'Jl. TB Simatupang'],
        'pasar-minggu' => ['Pejaten Barat & Timur', 'Pasar Minggu', 'Kebagusan', 'Jati Padang', 'Ragunan', 'Cilandak Timur', 'Kawasan Ampera & Kemang Timur'],
        'mampang-prapatan' => ['Bangka & Kemang', 'Pela Mampang', 'Tegal Parang', 'Mampang Prapatan', 'Kuningan Barat', 'Jl. Kemang Raya & Bangka Raya'],
        'pancoran' => ['Kalibata', 'Rawa Jati', 'Duren Tiga', 'Cikoko', 'Pengadegan', 'Pancoran', 'Kawasan Apartemen Kalibata City'],
        'jagakarsa' => ['Tanjung Barat', 'Lenteng Agung', 'Jagakarsa', 'Ciganjur', 'Srengseng Sawah', 'Cipedak', 'Jl. Moh. Kahfi I & II'],
        'pesanggrahan' => ['Petukangan Utara & Selatan', 'Ulujami', 'Pesanggrahan', 'Bintaro Sektor Jakarta', 'Jl. Ciledug Raya'],
        'setiabudi' => ['Karet & Semanggi', 'Karet Kuningan', 'Kuningan Timur', 'Menteng Atas', 'Pasar Manggis', 'Guntur', 'Rasuna Said Corridor'],

        // --- JAKARTA BARAT ---
        'kebon-jeruk' => ['Kebon Jeruk', 'Kedoya Utara & Selatan', 'Duri Kepa', 'Sukabumi Utara & Selatan', 'Kelapa Dua', 'Jl. Panjang Arteri'],
        'kembangan' => ['Kembangan Utara & Selatan', 'Meruya Utara & Selatan', 'Srengseng', 'Joglo', 'Puri Indah & Lippo Mall Puri'],
        'palmerah' => ['Slipi', 'Kota Bambu Utara & Selatan', 'Jatipulo', 'Palmerah', 'Kemanggisan', 'Kawasan Kampus Binus Anggrek'],
        'grogol-petamburan' => ['Tomang', 'Grogol', 'Jelambar & Jelambar Baru', 'Wijaya Kusuma', 'Tanjung Duren Utara & Selatan', 'Kawasan Central Park & Neo Soho'],
        'cengkareng' => ['Kedaung Kali Angke', 'Kapuk', 'Cengkareng Barat & Timur', 'Rawa Buaya', 'Duri Kosambi', 'Taman Palem & Green Lake City'],
        'kalideres' => ['Kamal', 'Pegadungan', 'Kalideres', 'Semanan', 'Tegal Alur', 'Citra Garden City Area'],
        'tambora' => ['Tanah Sereal', 'Roa Malaka', 'Pekojan', 'Jembatan Lima', 'Krendang', 'Duri Utara & Selatan', 'Angke'],
        'taman-sari' => ['Pinangsia', 'Glodok', 'Keagungan', 'Krukut', 'Maphar', 'Tangki', 'Mangga Besar & Hayam Wuruk'],

        // --- JAKARTA TIMUR ---
        'duren-sawit' => ['Duren Sawit', 'Pondok Kelapa', 'Pondok Kopi', 'Malaka Jaya', 'Malaka Sari', 'Klender', 'Kawasan Banjir Kanal Timur (BKT)'],
        'jatinegara' => ['Bali Mester', 'Kampung Melayu', 'Bidara Cina', 'Cipinang Cempedak', 'Rawa Bunga', 'Cipinang Besar & Muara'],
        'pulo-gadung' => ['Rawamangun', 'Pisangan Timur', 'Cipinang', 'Jatinegara Kaum', 'Jati', 'Kayu Putih', 'Kawasan Pacuan Kuda Pulomas'],
        'rawamangun' => ['Jl. Pemuda', 'Jl. Balai Pustaka', 'Kawasan Arion Mall', 'Velodrome Rawamangun', 'Kayu Putih Timur'],
        'cakung' => ['Cakung Barat & Timur', 'Rawa Terate', 'Jatinegara Cakung', 'Penggilingan', 'Pulo Gebang', 'Ujung Menteng', 'Jakarta Garden City'],
        'kramat-jati' => ['Kramat Jati', 'Batu Ampar', 'Balekambang', 'Kampung Tengah', 'Dukuh', 'Cawang', 'Cililitan & PGC'],
        'matraman' => ['Pisangan Baru', 'Utan Kayu Utara & Selatan', 'Kayu Manis', 'Pal Miam', 'Kebon Manggis', 'Jl. Matraman Raya'],
        'pasar-rebo' => ['Pekayon', 'Kampung Gedong', 'Cijantung', 'Kampung Baru', 'Kalisari', 'Jl. Raya Bogor KM 26-28'],
        'ciracas' => ['Cibubur', 'Kelapa Dua Wetan', 'Ciracas', 'Susukan', 'Rambutan', 'Kawasan Cibubur Junction'],
        'cipayung' => ['Lubang Buaya', 'Ceger', 'Cipayung', 'Munjul', 'Pondok Ranggon', 'Cilangkap', 'Setu & Bambu Apus'],
        'makasar' => ['Pinang Ranti', 'Makasar', 'Halim Perdanakusuma', 'Cipinang Melayu', 'Kebon Pala', 'Bandara Halim Area'],

        // --- JAKARTA PUSAT ---
        'menteng' => ['Menteng', 'Pegangsaan', 'Cikini', 'Gondangdia', 'Kebon Sirih', 'Jl. Teuku Umar & Imam Bonjol'],
        'tanah-abang' => ['Bendungan Hilir (Benhil)', 'Karet Tengsin', 'Kebon Melati', 'Kebon Kacang', 'Kampung Bali', 'Petamburan', 'Gelora & GBK Area'],
        'kemayoran' => ['Gunung Sahari Selatan', 'Kemayoran', 'Kebon Kosong', 'Harapan Mulya', 'Cempaka Baru', 'Utan Panjang', 'Kawasan PRJ JIExpo'],
        'senen' => ['Senen', 'Kwitang', 'Kenari', 'Paseban', 'Kramat', 'Bungur', 'Jl. Kramat Raya'],
        'cempaka-putih' => ['Cempaka Putih Timur & Barat', 'Rawasari', 'Jl. Letjen Suprapto', 'Kawasan RS Islam'],
        'johar-baru' => ['Johar Baru', 'Kampung Rawa', 'Galur', 'Tanah Tinggi', 'Kawasan Percetakan Negara'],
        'gambir' => ['Gambir', 'Kebon Kelapa', 'Petojo Utara & Selatan', 'Duri Pulo', 'Cideng', 'Kawasan Monas & Harmoni'],
        'sawah-besar' => ['Pasar Baru', 'Gunung Sahari Utara', 'Mangga Dua Selatan', 'Karang Anyar', 'Kartini', 'Kawasan Pasar Baru & Golden Truly'],

        // --- JAKARTA UTARA ---
        'kelapa-gading' => ['Kelapa Gading Barat & Timur', 'Pegangsaan Dua', 'Boulevard Raya', 'Kelapa Kopyor & Hibrida', 'Mall Kelapa Gading & MOI'],
        'tanjung-priok' => ['Tanjung Priok', 'Kebon Bawang', 'Sungai Bambu', 'Papanggo', 'Warakas', 'Sunter Agung & Sunter Jaya', 'Danau Sunter'],
        'penjaringan' => ['Penjaringan', 'Pluit', 'Pejagalan', 'Kapuk Muara', 'Kamal Muara', 'Pantai Indah Kapuk (PIK 1 & 2)'],
        'koja' => ['Koja', 'Rawa Badak Utara & Selatan', 'Tugu Utara & Selatan', 'Lagoa', 'Jl. Jampea & Sindang'],
        'cilincing' => ['Cilincing', 'Semper Barat & Timur', 'Sukapura', 'Rorotan', 'Marunda', 'Kawasan KBN Marunda'],
        'pademangan' => ['Pademangan Barat & Timur', 'Ancol', 'Kawasan Taman Impian Jaya Ancol', 'Jl. Lodan Raya'],

        // --- TANGERANG & TANGSEL ---
        'serpong' => ['BSD City Sektor 1-14', 'Lengkong Gudang & Wetan', 'Rawa Buntu', 'Ciater', 'Buaran', 'Kawasan The Breeze & AEON'],
        'serpong-utara' => ['Pakulonan', 'Pondok Jagung & Timur', 'Jelupang', 'Lengkong Karya', 'Alam Sutera & Flavor Bliss'],
        'ciputat' => ['Ciputat', 'Cipayung', 'Sawah Baru & Lama', 'Jombang', 'Sarua & Sarua Indah', 'Kawasan Kampus UIN'],
        'ciputat-timur' => ['Rengas', 'Rempoa', 'Cireundeu', 'Pondok Ranji', 'Pisangan', 'Kawasan Situ Gintung'],
        'pamulang' => ['Pondok Benda', 'Benda Baru', 'Kedaung', 'Pondok Cabe Udik & Ilir', 'Pamulang Barat & Timur', 'Jl. Siliwangi Raya'],
        'pondok-aren' => ['Bintaro Sektor 1-9', 'Pondok Jaya', 'Pondok Betung', 'Jurang Mangu Barat & Timur', 'Pondok Kacang Barat & Timur', 'Bintaro Jaya Xchange'],
        'karawaci' => ['Lippo Village Karawaci', 'Bojong Jaya', 'Cimone & Cimone Jaya', 'Pabuaran & Pabuaran Tumpeng', 'Gerendeng'],
        'ciledug' => ['Sudimara Barat & Timur', 'Sudimara Selatan & Jaya', 'Paninggilan & Utara', 'Parung Serab', 'CBD Ciledug'],
        'cipondoh' => ['Cipondoh & Cipondoh Indah', 'Kenanga', 'Gondrong', 'Petir', 'Poris Plawad & Indah', 'Danau Cipondoh'],

        // --- DEPOK ---
        'cinere' => ['Cinere', 'Gandul', 'Pangkalan Jati & Baru', 'Kawasan Megapolitan Cinere', 'Bukit Cinere Indah'],
        'beji' => ['Beji & Beji Timur', 'Kemiri Muka', 'Pondok Cina', 'Kukusan', 'Tanah Baru', 'Kawasan Kampus UI & Margonda'],
        'pancoran-mas' => ['Pancoran Mas', 'Depok & Depok Jaya', 'Mampang', 'Rangkapan Jaya & Baru', 'Jl. Nusantara & Sawangan Raya'],
        'sukmajaya' => ['Sukmajaya', 'Mekar Jaya', 'Baktijaya', 'Abadijaya', 'Tirtajaya', 'Cisalak', 'Kawasan Grand Depok City (GDC)'],
        'sawangan' => ['Sawangan & Sawangan Baru', 'Kedaung', 'Cinangka', 'Bedahan', 'Pasir Putih', 'Pengasinan', 'Bojongsari'],
        'cimanggis' => ['Curug', 'Harjamukti', 'Cisalak Pasar', 'Mekarsari', 'Tugu', 'Pasir Gunung Selatan', 'Kawasan Cibubur Radar AURI'],

        // --- BEKASI ---
        'bekasi-barat' => ['Kota Baru', 'Bintara & Bintara Jaya', 'Jakasampurna', 'Kranji', 'Kawasan Metropolitan Mall & Grand Metropolitan'],
        'bekasi-selatan' => ['Pekayon Jaya', 'Jaka Mulya', 'Jaka Setia', 'Kayuringin Jaya', 'Marga Jaya', 'Summarecon Mall Bekasi & Galaxy'],
        'bekasi-timur' => ['Aren Jaya', 'Bekasi Jaya', 'Duren Jaya', 'Margahayu', 'Jl. Ir. H. Juanda & Stasiun Bekasi Timur'],
        'bekasi-utara' => ['Harapan Baru', 'Harapan Jaya', 'Kaliabang Tengah', 'Perwira', 'Teluk Pucung', 'Kawasan Summarecon Bekasi'],
        'medansatria' => ['Pejuang', 'Medan Satria', 'Kali Baru', 'Harapan Mulya', 'Kawasan Kota Harapan Indah'],
        'rawalumbu' => ['Sepanjang Jaya', 'Pengasinan', 'Bojong Rawalumbu', 'Bojong Menteng', 'Kemang Pratama Area'],

        // --- BOGOR ---
        'bogor-timur' => ['Baranangsiang', 'Katulampa', 'Sindangrasa', 'Sindangbarang', 'Tajur', 'Sukasari', 'Kawasan Pajajaran'],
        'bogor-tengah' => ['Babakan', 'Babakan Pasar', 'Cibogor', 'Ciwaringin', 'Gudang', 'Kebon Kelapa', 'Paledang', 'Panaragan', 'Kebun Raya Area'],
        'bogor-selatan' => ['Batutulis', 'Bondongan', 'Cikaret', 'Cipaku', 'Empang', 'Genteng', 'Harjasari', 'Kertamaya', 'Ranggamekar'],
        'bogor-utara' => ['Bantarjati', 'Cibuluh', 'Ciluar', 'Cimahpar', 'Kedunghalang', 'Tanah Baru', 'Tegal Gundil'],
        'bogor-barat' => ['Balungbangjaya', 'Bubulak', 'Cilendek Barat & Timur', 'Curug & Curugmekar', 'Gunungbatu', 'Loji', 'Menteng', 'Pasirmulya'],
        'cibinong' => ['Cirimekar', 'Ciriung', 'Harapan Jaya', 'Karadenan', 'Nanggewer & Mekar', 'Pabuaran & Mekar', 'Pakansari & Stadion Pakansari'],

        // --- BANDUNG & CIMAHI ---
        'coblong' => ['Dago', 'Dipatiukur', 'Lebakgede', 'Lebaksiliwangi', 'Sadang Serang', 'Sekeloa', 'Kawasan Simpang Dago'],
        'sukajadi' => ['Pasteur', 'Cipedes', 'Sukagalih', 'Sukawarna', 'Sukarasa', 'Kawasan Paris Van Java (PVJ)'],
        'buahbatu' => ['Cijawura', 'Jatisari', 'Margasari', 'Sekejati', 'Margacinta', 'Kawasan Ciwastra'],
        'lengkong' => ['Burangrang', 'Cijagra', 'Cikawao', 'Lingkar Selatan', 'Malabar', 'Paledang', 'Turangga'],
        'antapani' => ['Antapani Kidul', 'Antapani Kulon', 'Antapani Tengah', 'Antapani Wetan', 'Kawasan Gasibu & Terusan Jakarta'],
        'cimahi-tengah' => ['Baros', 'Cigugur Tengah', 'Karangmekar', 'Padasuka', 'Setiamanah', 'Kawasan Alun-alun Cimahi'],

        // --- BALI ---
        'kuta' => ['Kuta Pantai', 'Legian', 'Seminyak', 'Tuban', 'Kedonganan', 'Jalan Raya Kuta & Dewi Sri'],
        'kuta-utara' => ['Canggu', 'Berawa', 'Kerobokan & Kerobokan Kelod', 'Tibubeneng', 'Batu Bolong & Echo Beach'],
        'kuta-selatan' => ['Jimbaran', 'Kedonganan Pesisir', 'Pecatu & Uluwatu', 'Ungasan', 'Benoa & Nusa Dua'],
        'denpasar-selatan' => ['Sanur & Sanur Kaja', 'Renon & Pusat Pemerintahan', 'Panjer', 'Sesetan', 'Sidakarya', 'Serangan'],
        'denpasar-barat' => ['Padangsambian & Klod', 'Pemecutan & Klod', 'Dauh Puri & Kangin', 'Teuku Umar & Mahendradatta'],
        'ubud' => ['Ubud Kelod', 'Petulu', 'Sayan', 'Singakerta', 'Kedewatan', 'Tegallalang Perbatasan'],

        // --- LAMPUNG ---
        'kedaton' => ['Kedaton', 'Kampung Baru', 'Sidodadi', 'Sukamenanti', 'Surabaya', 'Penengahan', 'Kawasan Mall Boemi Kedaton (MBK)'],
        'tanjung-karang-pusat' => ['Palapa', 'Durian Payung', 'Gotong Royong', 'Kaliawi', 'Kelapa Tiga', 'Pasar Baru & Kartini'],
        'way-halim' => ['Way Halim Permai', 'Gunung Sulah', 'Jagabaya I-III', 'Perumnas Way Halim'],
        'sukarame' => ['Sukarame & Baru', 'Harapan Jaya', 'Korpri Jaya & Raya', 'Kawasan Kampus Itera & UIN Raden Intan'],
    ];

    /**
     * Determine typology for a given district deterministically.
     */
    public static function resolveTypology(string $citySlug, string $districtSlug): string
    {
        $d = strtolower($districtSlug);
        $c = strtolower($citySlug);

        // 1. Explicit Commercial / Food / Lifestyle districts
        if (in_array($d, [
            'tebet', 'kebayoran-baru', 'kelapa-gading', 'grogol-petamburan', 'kuta', 'kuta-utara', 'ubud',
            'coblong', 'sukajadi', 'rawamangun', 'serpong-utara', 'kedaton', 'way-halim', 'bandung-wetan',
        ], true)) {
            return 'kuliner_komersial';
        }

        // 2. Explicit Modern Residential Cluster districts
        if (in_array($d, [
            'serpong', 'pondok-aren', 'duren-sawit', 'jagakarsa', 'cilandak', 'pesanggrahan', 'kembangan',
            'cengkareng', 'kalideres', 'cinere', 'sawangan', 'bekasi-selatan', 'bekasi-utara', 'cibinong',
            'buahbatu', 'antapani', 'arcamanik', 'banyumanik', 'tembalang', 'kuta-selatan',
        ], true)) {
            return 'residensial_klaster';
        }

        // 3. Explicit Dense Urban / Heritage districts
        if (in_array($d, [
            'tambora', 'taman-sari', 'johar-baru', 'senen', 'matraman', 'jatinegara', 'beji', 'pancoran-mas',
            'bekasi-timur', 'bogor-tengah', 'cimahi-tengah', 'denpasar-barat', 'semarang-tengah', 'tanjung-karang-pusat',
        ], true)) {
            return 'pemukiman_padat';
        }

        // 4. Explicit Business / Office districts
        if (in_array($d, [
            'setiabudi', 'tanah-abang', 'menteng', 'gambir', 'mampang-prapatan', 'pancoran', 'kebayoran-lama',
            'bekasi-barat', 'denpasar-selatan', 'sukajadi', 'candisari', 'gajahmungkur',
        ], true)) {
            return 'bisnis_perkantoran';
        }

        // 5. Explicit Industrial / Port / Coastal districts
        if (in_array($d, [
            'penjaringan', 'tanjung-priok', 'cilincing', 'cakung', 'medansatria', 'cikarang-barat', 'cikarang-utara',
            'genuk', 'tugu', 'semarang-utara', 'demak', 'sayung',
        ], true)) {
            return 'industri_pesisir';
        }

        // Fallback: Deterministic CRC32 Hash to one of the 5 archetypes
        $keys = array_keys(self::TYPOLOGIES);
        $index = abs(crc32($c . '-' . $d)) % count($keys);

        return $keys[$index];
    }

    /**
     * Get authentic landmarks / kelurahan for a district.
     *
     * @return array<int, string>
     */
    public static function resolveLandmarks(string $citySlug, string $districtSlug, string $districtName, string $cityName): array
    {
        $d = strtolower($districtSlug);

        if (isset(self::$districtLandmarks[$d])) {
            return self::$districtLandmarks[$d];
        }

        // Algorithmic authentic-sounding landmarks for unlisted districts
        $cleanDistrict = trim(str_ireplace(['kecamatan', 'kabupaten', 'kota'], '', $districtName));

        return [
            "Kelurahan {$cleanDistrict} Kota",
            "Kelurahan {$cleanDistrict} Barat",
            "Kelurahan {$cleanDistrict} Timur",
            "Area Perumahan & Residensial {$cleanDistrict}",
            "Kawasan Sentra Niaga & Ruko {$cleanDistrict}",
            "Jalan Raya Utama {$cleanDistrict}",
            "Posko Armada Siaga Sekitar {$cleanDistrict}",
        ];
    }

    /**
     * Get complete hyper-local profile for a district.
     *
     * @return array{
     *     typology: string,
     *     typology_label: string,
     *     dominant_buildings: string,
     *     landmarks: array<int, string>,
     *     problem_desc: string,
     *     problem_detail: string,
     *     dispatch_desc: string,
     *     solution_desc: string,
     *     solution_detail: string,
     *     faqs: array<int, array{question: string, answer: string}>
     * }
     */
    public static function getDistrictProfile(string $citySlug, string $district, string $cityName, int $price = 400000): array
    {
        $districtSlug = Str::slug($district);
        $typologyKey = self::resolveTypology($citySlug, $districtSlug);
        $typo = self::TYPOLOGIES[$typologyKey];

        $landmarks = self::resolveLandmarks($citySlug, $districtSlug, $district, $cityName);
        $priceFormatted = 'Rp ' . number_format($price, 0, ',', '.');

        $replacements = [
            '[KECAMATAN]' => $district,
            '[KOTA]' => $cityName,
            '[HARGA]' => $priceFormatted,
        ];

        $sanitize = static function (string $text) use ($replacements): string {
            return str_replace(array_keys($replacements), array_values($replacements), $text);
        };

        $faqs = array_map(static function (array $faq) use ($sanitize): array {
            return [
                'question' => $sanitize($faq['question']),
                'answer' => $sanitize($faq['answer']),
            ];
        }, $typo['faqs']);

        return [
            'typology' => $typologyKey,
            'typology_label' => $typo['label'],
            'dominant_buildings' => $typo['dominant_buildings'],
            'landmarks' => $landmarks,
            'problem_desc' => $sanitize($typo['problem_desc']),
            'problem_detail' => $sanitize($typo['problem_detail']),
            'dispatch_desc' => $sanitize($typo['dispatch_desc']),
            'solution_desc' => $sanitize($typo['solution_desc']),
            'solution_detail' => $sanitize($typo['solution_detail']),
            'faqs' => $faqs,
        ];
    }

    /**
     * Generate localized SEO keywords for a district.
     *
     * @return array<int, string>
     */
    public static function getKeywords(string $district, string $cityName, array $landmarks = []): array
    {
        $d = trim($district);
        $c = trim($cityName);

        $keywords = [
            "jasa saluran pipa mampet {$d}",
            "jasa pipa mampet {$d}",
            "tukang pipa mampet {$d}",
            "tukang saluran mampet {$d}",
            "jasa wc mampet {$d}",
            "jasa wastafel mampet {$d}",
            "pelancar pipa mampet {$d}",
            "jasa kuras grease trap {$d}",
            "saluran air kamar mandi mampet {$d}",
            "biaya tukang pipa mampet {$d}",
            "tukang pipa terdekat {$d}",
            "pelancar pipa tanpa bongkar {$d}",
            "jasa pipa mampet {$d} {$c}",
            "tukang saluran mampet {$c}",
        ];

        foreach (array_slice($landmarks, 0, 4) as $lm) {
            $keywords[] = "jasa saluran mampet {$lm}";
        }

        return array_unique($keywords);
    }
}
