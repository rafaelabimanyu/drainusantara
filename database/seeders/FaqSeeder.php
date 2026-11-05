<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // --- KATEGORI: TEKNIS & METODE PIPA ---
            [
                'category' => 'teknis',
                'question' => 'Apakah proses pelancaran pipa benar-benar 100% tanpa membongkar keramik lantai?',
                'answer' => 'Benar 100%. Teknisi Drainusantara menggunakan unit mesin spiral rotary Ridgid Amerika dengan kabel baja lentur berkecepatan putar terukur serta nozel Hydro-Jetting bertekanan air. Akses pengerjaan langsung melalui lubang afur wastafel, floor drain, kloset, atau bak kontrol eksisting sehingga ubin keramik, marmer, dan struktur dinding Anda tetap utuh tanpa risiko pembongkaran.',
                'order' => 1,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'teknis',
                'question' => 'Mengapa pemakaian soda api sangat dilarang keras untuk pipa pembuangan PVC?',
                'answer' => 'Soda api (Natrium Hidroksida / NaOH) memicu reaksi eksotermik panas ekstrem hingga di atas 90°C saat bereaksi dengan air. Suhu ini langsung melunakkan pipa PVC dan merusak sambungan lem elbow pipa. Selain itu, bila soda api gagal melarutkan gumpalan minyak, residunya akan mengalami proses saponifikasi dan mengeras menjadi kerak kapur padat seperti batu semen yang jauh lebih sulit ditembus.',
                'order' => 2,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'teknis',
                'question' => 'Apa perbedaan metode spiral rotary mekanis dibanding kawat manual biasa?',
                'answer' => 'Kawat manual biasa hanya mampu menusuk satu lubang kecil di tengah sumbatan dan rentan tersangkut di belokan pipa 90 derajat. Sebaliknya, mesin spiral rotary mekanis menggunakan per baja elastis berputar dengan torsi stabil yang mengikis dinding pipa secara melingkar (360 derajat), mencacah lemak membatu, dan menarik gumpalan rambut atau kain keluar.',
                'order' => 3,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'teknis',
                'question' => 'Kapan saluran pipa membutuhkan inspeksi kamera CCTV endoskopi?',
                'answer' => 'Inspeksi kamera CCTV drain IP68 sangat direkomendasikan jika saluran pipa sering mampet berulang dalam waktu singkat, dicurigai terjadi pipa pecah atau amblas akibat pergeseran tanah, kemasukan akar pohon liar, atau untuk memeriksa kebersihan saluran lemak restoran pasca tindakan.',
                'order' => 4,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'teknis',
                'question' => 'Apakah spiral baja dapat merusak leher angsa porselen kloset atau wastafel?',
                'answer' => 'Tidak. Tim teknisi Drainusantara menggunakan kabel spiral khusus dengan selubung pelindung fleksibel (guide hose) yang mencegah gesekan langsung antara spiral baja dengan glasur keramik kloset duduk maupun porselen wastafel Anda.',
                'order' => 5,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'teknis',
                'question' => 'Apa itu metode Hydro-Jetting dan untuk kasus apa metode ini digunakan?',
                'answer' => 'Hydro-Jetting adalah metode pembersihan saluran pipa menggunakan semprotan air bertekanan tinggi terkalibrasi dengan nozel putar multi-arah. Metode ini ideal untuk membersihkan kerak minyak padat pada saluran dapur komersial, grease trap restoran, dan pipa berdiameter besar (4 inci ke atas) hingga bersih menyerupai pipa baru.',
                'order' => 6,
                'is_active' => true,
                'is_featured' => false,
            ],

            // --- KATEGORI: ESTIMASI WAKTU & DURASI ---
            [
                'category' => 'durasi',
                'question' => 'Berapa lama rata-rata durasi pengerjaan pelancaran saluran pipa?',
                'answer' => config('service_facts.duration_answer') ?: 'Pengerjaan pelancaran pipa standar membutuhkan waktu rata-rata 30 hingga 45 menit. Untuk kasus sumbatan kompleks kerak lemak membatu atau akar pohon, proses tindakan membutuhkan waktu 1 hingga 2 jam hingga aliran air teruji lancar tuntas.',
                'order' => 7,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'durasi',
                'question' => 'Berapa lama estimasi armada teknisi tiba di lokasi pemesan?',
                'answer' => 'Waktu kedatangan teknisi rata-rata berkisar antara 30 hingga 60 menit setelah konfirmasi pesanan, bergantung pada jarak posko armada terdekat di kota Anda dan kondisi lalu lintas jalan raya.',
                'order' => 8,
                'is_active' => true,
                'is_featured' => false,
            ],

            // --- KATEGORI: BIAYA & TARIF TRANSPARAN ---
            [
                'category' => 'biaya',
                'question' => 'Bagaimana sistem penentuan biaya jasa dan apakah ada risiko biaya tersembunyi?',
                'answer' => 'Drainusantara menerapkan sistem harga transparan. Estimasi biaya jasa disepakati di awal sebelum teknisi memulai tindakan fisik. Biaya dihitung berdasarkan titik saluran (wastafel, kloset, talang, atau pipa utama) dan tingkat kesulitan tanpa biaya tersembunyi di akhir pengerjaan.',
                'order' => 9,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'biaya',
                'question' => 'Apa yang dimaksud dengan sistem No Cure No Pay?',
                'answer' => 'No Cure No Pay adalah komitmen garansi kepuasan kami: Jika saluran pipa air kotor Anda tidak berhasil kami lancarkan tuntas (air tetap menggenang atau meluap), Anda tidak dikenakan biaya jasa pelancaran sepeserpun.',
                'order' => 10,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'biaya',
                'question' => 'Metode pembayaran apa saja yang diterima?',
                'answer' => 'Kami menerima pembayaran tunai (cash) langsung kepada teknisi di lokasi, transfer bank antar-rekening perusahaan resmi, scan QRIS dinamis, serta faktur termin khusus bagi mitra korporat dan restoran B2B.',
                'order' => 11,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'biaya',
                'question' => 'Apakah ada biaya tambahan untuk panggilan teknisi pada malam hari atau hari libur?',
                'answer' => 'Layanan hotline dispatch kami beroperasi 24 jam nonstop setiap hari termasuk hari Minggu dan libur nasional. Konfirmasi estimasi biaya malam hari akan diinformasikan secara transparan oleh admin WhatsApp sebelum teknisi diberangkatkan.',
                'order' => 12,
                'is_active' => true,
                'is_featured' => false,
            ],

            // --- KATEGORI: GARANSI & JAMINAN ---
            [
                'category' => 'garansi',
                'question' => 'Bagaimana ketentuan dan masa berlaku Garansi 30 Hari Drainusantara?',
                'answer' => 'Setiap pengerjaan pelancaran pipa dilindungi garansi resmi selama 30 hari kalender sejak tanggal pengerjaan yang tercantum pada nota digital. Jika titik saluran yang sama mengalami mampet kembali dalam masa garansi, teknisi datang melancarkan ulang 100% gratis tanpa biaya jasa maupun transportasi.',
                'order' => 13,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'garansi',
                'question' => 'Bagaimana alur prosedur klaim garansi jika saluran mampet kembali?',
                'answer' => 'Klaim garansi sangat mudah: cukup hubungi WhatsApp Customer Service Drainusantara dengan melampirkan foto nota digital atau menyebutkan nomor telepon saat pengerjaan awal. Tim admin langsung memverifikasi data dan menjadwalkan kunjungan teknisi prioritas.',
                'order' => 14,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'garansi',
                'question' => 'Apakah garansi tetap berlaku jika saluran mampet akibat sampah baru yang masuk?',
                'answer' => 'Garansi 30 hari melindungi kelancaran saluran dari residu sumbatan lama. Apabila ditemukan benda asing baru yang sengaja dimasukkan pasca pengerjaan (seperti mainan anak, kain pel utuh, atau adukan semen renovasi baru), teknisi akan memberikan edukasi dan penanganan sesuai kondisi lapangan.',
                'order' => 15,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'garansi',
                'question' => 'Apakah nota garansi diterbitkan dalam bentuk fisik atau digital?',
                'answer' => 'Kami menerbitkan nota digital resmi berstempel perusahaan yang dikirimkan langsung ke nomor WhatsApp pemesan, serta nota fisik cetak rangkap yang diserahkan oleh teknisi di lokasi pengerjaan.',
                'order' => 16,
                'is_active' => true,
                'is_featured' => false,
            ],

            // --- KATEGORI: JANGKAUAN WILAYAH & DISPATCH ---
            [
                'category' => 'wilayah',
                'question' => 'Wilayah mana saja yang dijangkau oleh posko armada Drainusantara?',
                'answer' => 'Drainusantara saat ini memiliki posko armada siaga di 4 zona operasional utama: Jabodetabek (Jakarta, Bogor, Depok, Tangerang, Bekasi, Sentul & Cikarang), Bandung Raya & Cimahi, Jawa Tengah (Kota Semarang, Kab. Semarang, Kab. Demak), serta Bandar Lampung di Pulau Sumatera.',
                'order' => 17,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'wilayah',
                'question' => 'Apakah posko Bandung Raya melayani wilayah Kabupaten Bandung dan Cimahi?',
                'answer' => 'Ya, kami melayani seluruh 30 kecamatan Kota Bandung, 31 kecamatan Kabupaten Bandung (Soreang, Baleendah, Majalaya, Ciwidey, Cicalengka, Banjaran, dll.), serta 3 kecamatan Kota Cimahi (Cimahi Selatan, Tengah, Utara).',
                'order' => 18,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'wilayah',
                'question' => 'Apakah layanan Drainusantara mencakup seluruh kecamatan di Kabupaten Demak?',
                'answer' => 'Benar. Armada posko kami menjangkau seluruh 14 kecamatan di Kabupaten Demak, meliputi Sayung, Mranggen, Karangtengah, Demak Kota, Bonang, Wedung, Dempet, Gajah, Karanganyar, Karangawen, Kebonagung, Mijen, Wonosalam, dan Guntur.',
                'order' => 19,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'wilayah',
                'question' => 'Bagaimana armada teknisi menjangkau lokasi di dalam gang sempit atau perumahan padat?',
                'answer' => 'Sebagian besar armada teknisi Drainusantara menggunakan unit sepeda motor siaga yang telah dimodifikasi khusus untuk membawa mesin rotary elektrik, modul kabel spiral, dan peralatan keselamatan sehingga dapat gesit menjangkau gang pemukiman sempit.',
                'order' => 20,
                'is_active' => true,
                'is_featured' => false,
            ],

            // --- KATEGORI: LAYANAN KOMERSIAL & B2B / F&B ---
            [
                'category' => 'layanan',
                'question' => 'Apakah Drainusantara melayani pengerjaan shift malam (after-hours) untuk restoran mall & hotel?',
                'answer' => 'Ya, kami menyediakan layanan shift malam khusus bagi mitra restoran, food court, kafe, dan hotel. Pengerjaan pelancaran pipa lemak dapur (kitchen sink) dan grease trap dapat dijadwalkan setelah jam operasional tutup mall agar tidak mengganggu operasional bisnis dan pengunjung.',
                'order' => 21,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'layanan',
                'question' => 'Apakah tersedia paket kontrak perawatan rutin berkala (SLA) untuk pengelola gedung & F&B?',
                'answer' => 'Tentu. Kami menyediakan skema Service Level Agreement (SLA) untuk kontrak pemeliharaan saluran pipa rutin bulanan atau triwulanan bagi jaringan resto, ruko bisnis, apartemen, rumah sakit, dan pabrik industri dengan tarif khusus mitra.',
                'order' => 22,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'layanan',
                'question' => 'Bagaimana penanganan saluran pipa stack vertikal pada unit apartemen atau kondominium?',
                'answer' => 'Teknisi kami berpengalaman menangani instalasi pipa plumbing apartemen. Pengerjaan dilakukan hati-hati melalui jalur shaft atau pipa pembuangan unit hunian tanpa merusak pipa tetangga lantai bawah dan tetap mematuhi izin kerja (work permit) building management.',
                'order' => 23,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'layanan',
                'question' => 'Apakah melayani pembersihan saluran air limbah industri pabrik?',
                'answer' => 'Ya, kami melayani pembersihan pipa buangan utilitas pabrik, saluran bak kontrol industri, serta jalur drainase air kotor dengan mesin kapasitas industri berdiameter pipa besar.',
                'order' => 24,
                'is_active' => true,
                'is_featured' => false,
            ],

            // --- KATEGORI: PERALATAN & MESIN ---
            [
                'category' => 'peralatan',
                'question' => 'Peralatan apa saja yang dibawa oleh teknisi saat kunjungan ke lokasi?',
                'answer' => 'Setiap armada dilengkapi mesin drain rooter Ridgid spiral rotary, beberapa jenis modul spiral baja (16mm & 22mm), aneka mata bor (cutter lemak, hook pengait, pemotong akar), selang uji alir debit, pelindung lantai kerja, APD sarung tangan nitril, dan shoe cover steril.',
                'order' => 25,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'peralatan',
                'question' => 'Berapa meter daya jangkau maksimal kabel spiral mesin Drainusantara?',
                'answer' => 'Kabel spiral modular kami dapat disambung hingga jangkauan lebih dari 30 sampai 45 meter, memungkinkan pembersihan titik sumbatan yang berada jauh di tengah instalasi pipa tanam bawah lantai atau di luar pagar rumah.',
                'order' => 26,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'peralatan',
                'question' => 'Apakah mesin rotary membutuhkan daya listrik besar dari rumah pelanggan?',
                'answer' => 'Tidak. Mesin rotary elektrik drain cleaner kami menggunakan motor induksi efisien dengan konsumsi daya berkisar antara 250 hingga 550 Watt sehingga aman digunakan pada rumah berdaya listrik 900 VA sekalipun tanpa risiko jeglek (trip).',
                'order' => 27,
                'is_active' => true,
                'is_featured' => false,
            ],

            // --- KATEGORI: KEADAAN DARURAT & PENANGANAN PERTAMA ---
            [
                'category' => 'darurat',
                'question' => 'Apa yang harus dilakukan pemilik rumah saat air kloset atau wastafel mulai meluap?',
                'answer' => 'Langkah pertama: segera hentikan penggelontoran air (flush) atau penggunaan kran. Jangan menyiram air mendidih atau menuangkan bahan kimia soda api. Keringkan genangan di sekitar lantai untuk mencegah resapan ke dinding, lalu segera hubungi hotline WhatsApp Drainusantara.',
                'order' => 28,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'darurat',
                'question' => 'Mengapa air kotor dari floor drain bisa berbalik naik saat hujan lebat?',
                'answer' => 'Kondisi ini umumnya terjadi karena bak kontrol luar penuh atau saluran talang atap tersambung langsung ke pipa pembuangan air kotor bawah tanpa katup satu arah (backflow valve), atau pipa buangan utama terhambat gumpalan lemak padat sehingga debit air hujan memicu air limbah berbalik.',
                'order' => 29,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'darurat',
                'question' => 'Apakah teknisi siap menangani luapan darurat di tengah malam?',
                'answer' => 'Ya, kami menyediakan piket teknisi darurat 24 jam untuk menangani situasi kritis seperti kloset meluap di hotel/rumah sakit atau saluran kitchen restoran yang mampet saat persiapan jam buka.',
                'order' => 30,
                'is_active' => true,
                'is_featured' => false,
            ],

            // --- KATEGORI: LEGALITAS & ADMINISTRASI ---
            [
                'category' => 'administrasi',
                'question' => 'Apakah Drainusantara dapat menerbitkan e-Faktur Pajak PPN 11% dan invoice resmi?',
                'answer' => 'Tentu. Sebagai unit usaha resmi berbadan hukum di bawah naungan PT Jawa Jaya Rooter dengan NIB dan status Pengusaha Kena Pajak (PKP), kami siap menerbitkan invoice penagihan resmi, e-Faktur PPN 11%, dan Berita Acara Penyelesaian Pekerjaan (BAPP).',
                'order' => 31,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'administrasi',
                'question' => 'Bagaimana prosedur pemesanan layanan untuk instansi pemerintah atau BUMN?',
                'answer' => 'Kami melayani pengadaan korporat, BUMN, dan instansi pemerintah dengan kelengkapan dokumen administrasi lengkap: Surat Penawaran Resmi, Surat Perintah Kerja (SPK), NPWP perusahaan, rekening koran korporat, dan bukti serah terima pengerjaan berstempel resmi.',
                'order' => 32,
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($faqs as $item) {
            Faq::updateOrCreate(
                ['question' => $item['question']],
                $item
            );
        }
    }
}

