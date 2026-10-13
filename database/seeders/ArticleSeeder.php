<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articlesData = [
            [
                'title' => 'Bahaya Menggunakan Soda Api untuk Saluran Mampet',
                'slug' => 'bahaya-menggunakan-soda-api-saluran-mampet',
                'thumbnail' => '/images/articles/bahaya-menuang-soda-api-pada-pipa-pvc-mampet.webp',
                'category' => 'Tips & Edukasi',
                'excerpt' => 'Banyak orang tergoda menuang soda api saat wastafel mampet. Padahal, reaksi eksotermik kimianya berisiko melelehkan pipa PVC dan mengeraskan lemak menjadi gips.',
                'content' => "Soda api (*Natrium Hidroksida* / NaOH) kerap dianggap sebagai jalan pintas murah ketika saluran pembuangan air di rumah tersumbat. Namun, dalam standar instalasi plumbing modern, soda api adalah salah satu faktor perusak utama sistem perpipaan PVC hunian.

## Mengapa Soda Api Sangat Berbahaya untuk Instalasi Rumah?

Penggunaan bahan kimia korosif sering kali memperparah kondisi sumbatan alih-alih menyelesaikannya. Berikut adalah fakta teknis di balik bahaya reaksi soda api di dalam pipa air:

### 1. Suhu Panas Ekstrem Melelehkan Pipa PVC
Reaksi eksotermik antara kristal soda api dan air menghasilkan pelepasan panas luar biasa yang suhunya dapat melampaui **100°C**. Pipa paralon PVC standar kelas D maupun AW rumah tangga hanya dirancang menahan batas suhu maksimal sekitar **60°C**. Akibatnya:
- Dinding pipa melunak dan melengkung (*deformasi fisik*).
- Lem perekat sambungan (*fitting solvent cement*) mencair, memicu kebocoran tersembunyi di bawah dak beton atau dinding rumah.
- Pipa rentan pecah seketika akibat tekanan uap tertahan.

### 2. Lemak Malah Membatu (Reaksi Safonifikasi)
Ketika soda api bertemu dengan endapan minyak jelantah di pipa dapur, terjadi reaksi safonifikasi (proses pembuatan sabun tradisional). Lemak cair tidak larut, melainkan bermutasi menjadi gumpalan sabun padat yang mengeras seperti **batu kapur atau semen putih**. Setelah membatu, sumbatan menjadi mustahil ditembus oleh air mengalir atau bahan pelarut biasa.

### 3. Risiko Percikan Kimia & Gas Beracun
Proses pelarutan soda api memicu reaksi mendidih yang menyembur keluar (*blowback*). Percikan cairan basa kuat ini dapat menyebabkan luka bakar kimia tingkat tinggi pada kulit serta kerusakan mata permanen. Selain itu, uap panas yang terhirup berisiko mengiritasi saluran pernapasan penghuni rumah.

## Solusi Mekanis Profesional Tanpa Resiko Kimia

Metode yang aman dan direkomendasikan secara internasional adalah **pembersihan mekanik menggunakan mesin spiral baja rotary (rooter)**. Keunggulannya:
- **100% Bebas Bahan Kimia:** Tidak merusak struktur dinding pipa PVC maupun fitting leher angsa.
- **Mengeruk Hingga Bersih:** Mata pisau khusus berputar fleksibel mengikis kerak lemak dan menarik rambut hingga ke dinding pipa terluar.
- **Tuntas Bergaransi:** Saluran diuji alir langsung di lokasi pengerjaan dengan jaminan garansi resmi 30 hari.",
                'meta_title' => 'Bahaya Menggunakan Soda Api untuk Saluran Mampet - Edukasi Drainusantara',
                'meta_description' => 'Ketahui risiko fatal soda api pada pipa PVC rumah: pipa melengkung, bocor ke dak lantai, dan lemak membatu. Gunakan mesin mekanis spiral yang aman.',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => '5 Kebiasaan Sepele Penyebab Utama Bak Cuci Piring Tersumbat',
                'slug' => '5-kebiasaan-penyebab-bak-cuci-piring-tersumbat',
                'thumbnail' => '/images/articles/kebiasaan-sepele-penyebab-bak-cuci-piring-kitchen-sink-mampet.webp',
                'category' => 'Perawatan Rumah',
                'excerpt' => 'Minyak jelantah hingga ampas kopi sering dianggap sepele saat dibuang ke sink dapur. Simak cara merawat saluran wastafel agar bebas mampet bertahun-tahun.',
                'content' => "Bak cuci piring (*kitchen sink*) adalah titik instalasi sanitasi dengan beban kerja terberat di rumah dan tempat usaha kuliner. Setiap hari, berbagai residu sisa pengolahan makanan mengalir melalui leher angsa sifon. Tanpa disadari, kebiasaan sehari-hari menjadi pemicu penumpukan endapan kronis.

## 5 Kebiasaan Harian yang Menyumbat Saluran Dapur

Memahami sumber masalah adalah langkah pertama mencegah pengeluaran biaya perbaikan darurat. Berikut kebiasaan yang paling sering merusak aliran air:

### 1. Menuang Minyak Jelantah Cair ke Saringan Sink
Minyak goreng bekas tampak encer saat panas, namun akan segera membeku dan menempel begitu terkena air dingin di dalam pipa bawah tanah. Lapisan lemak ini menumpuk dari hari ke hari seperti plak kolesterol, mempersempit diameter pipa dari 2 inci menjadi seukuran sedotan.

### 2. Membuang Ampas Kopi & Ampas Teh
Butiran bubuk kopi tidak dapat larut dalam air dan memiliki massa jenis padat. Saat mengalir ke lekukan leher angsa sifon (*P-trap*), ampas kopi akan mengendap di dasar lekukan dan merekat kuat bersama sisa minyak goreng.

### 3. Membilas Sisa Nasi, Adonan Tepung, & Mi
Bahan makanan berkarbohidrat tinggi menyerap air dan mengembang berkali-kali lipat di dalam saluran. Adonan tepung basah berubah menjadi pasta lengket yang memerangkap serpihan tulang kecil dan kotoran lain.

### 4. Mengabaikan Lemak Mentega & Margarin
Banyak orang mengira membilas wajan berlemak dengan air keran biasa sudah cukup. Lemak susu dan margarin memiliki titik beku rendah, sehingga cepat membentuk kerak lilin putih tebal di sepanjang jalur pipa pembuangan.

### 5. Tidak Memasang Strainer Kawat Halus
Saringan bawaan wastafel sering kali memiliki lubang terlalu besar. Tanpa saringan jaring tambahan, potongan sayur dan sisa nasi langsung meluncur bebas ke sistem pipa utama.

## Tips Perawatan Preventif Mingguan

1. **Bilas Air Panas Berkala:** Tuangkan 2 liter air panas bersuhu 60-70°C (bukan mendidih) seminggu sekali untuk meluruhkan lapisan minyak tipis di sifon.
2. **Kumpulkan Minyak Bekas:** Tampung jelantah dalam botol atau kaleng bekas sebelum dibuang ke tempat sampah kering.
3. **Pembersihan Rutin Sifon:** Buka wadah leher angsa di bawah meja dapur setiap 3 bulan sekali untuk mengeluarkan endapan pasir dan kerak sisa makanan.",
                'meta_title' => '5 Penyebab Bak Cuci Piring Tersumbat & Solusinya - Drainusantara',
                'meta_description' => 'Panduan praktis merawat wastafel dapur bebas mampet. Hindari minyak jelantah dan ampas kopi agar saluran pipa tetap lancar mengalir.',
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Kapan Saluran Pipa Membutuhkan Inspeksi Kamera CCTV?',
                'slug' => 'kapan-saluran-pipa-butuh-inspeksi-kamera-cctv',
                'thumbnail' => '/images/articles/kapan-saluran-pipa-membutuhkan-inspeksi-kamera-cctv.webp',
                'category' => 'Teknologi Plumbing',
                'excerpt' => 'Jika saluran pipa Anda mampet berulang kali meski sudah sering dibersihkan, kemungkinan ada patahan, amblas tanah, atau akar pohon di dalam pipa.',
                'content' => "Masalah pipa mampet yang kambuh setiap 2 hingga 3 minggu adalah tanda peringatan bahwa persoalannya bukan lagi sekadar sumbatan kotoran biasa, melainkan adanya anomali struktural pada instalasi pipa bawah tanah.

## Mengapa Endoskopi Kamera Pipa Diperlukan?

Metode lama mengharuskan pemilik bangunan membongkar lantai keramik atau halaman rumah secara membabi buta untuk mencari letak kebocoran. Dengan **Inspeksi Kamera CCTV Pipa Industri**, diagnosis dilakukan secara visual dan presisi:

### 1. Deteksi Titik Amblas & Pipa Pecah
Pergeseran kontur tanah atau beban kendaraan berat di atas lantai garasi sering mematahkan pipa PVC. Kamera dengan transmitter jarak dapat menentukan titik meteran persis di mana pipa mengalami retak, pecah, atau tersumbat total.

### 2. Penetrasi Akar Pohon ke Sambungan Pipa
Akar pohon mencari sumber kelembapan dan mampu merayap menembus pori-pori sambungan lem pipa atau bak kontrol semen. Begitu masuk, akar tumbuh menjadi jaring laba-laba tebal yang memerangkap seluruh limbah rumah tangga.

### 3. Deteksi Pipa Terbalik (*Backslope*)
Kemiringan (*slope*) pipa yang salah (kurang dari 1-2%) membuat air limbah menggenang dan pasir semen mengendap permanen. Kamera CCTV mampu memperlihatkan genangan air statis di dalam jalur pipa horizontal.

## Keunggulan Unit CCTV Inspeksi Drainusantara

- **Kamera IP68 Tahan Air & LED Sorot:** Menghasilkan citra resolusi tinggi di dalam pipa gelap berdiameter 2 hingga 10 inci.
- **Kabel Push-Rod 30 Meter:** Menjangkau dari bak kontrol depan hingga saluran pembuangan utama kota.
- **Laporan Digital Video & Foto:** Pemilik rumah atau manajemen gedung menerima rekaman visual utuh sebagai bukti otentik sebelum tindakan perbaikan diambil.",
                'meta_title' => 'Kapan Saluran Pipa Butuh Inspeksi Kamera CCTV? - Drainusantara',
                'meta_description' => 'Deteksi masalah saluran pipa mampet kronis dengan endoscopic pipe camera resolusi tinggi hingga 30 meter tanpa tebak-tebak.',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Panduan Perawatan & Kuras Grease Trap Dapur Restoran',
                'slug' => 'panduan-perawatan-grease-trap-dapur-restoran',
                'thumbnail' => '/images/articles/panduan-membersihkan-grease-trap-dapur-restoran.webp',
                'category' => 'Perawatan Rumah',
                'excerpt' => 'Bak penangkap lemak (grease trap) yang diabaikan dapat memicu bau busuk di area makan tamu dan denda regulasi sanitasi. Pelajari SOP kuras lemak profesional.',
                'content' => "Bagi pengelola restoran, kafe, katering, dan hotel, unit **Grease Trap** (perangkap lemak) adalah benteng pertahanan utama agar limbah minyak tidak mencemari saluran got umum dan lingkungan sekitar.

## Cara Kerja Baffle Plate pada Grease Trap

Grease trap bekerja berdasarkan prinsip perbedaan berat jenis antara minyak/lemak dengan air:
1. Air limbah berminyak masuk ke kompartemen pertama yang dilengkapi keranjang penyaring kotoran padat (*solid basket*).
2. Di kompartemen kedua, minyak yang lebih ringan mengapung ke permukaan dan terhalang oleh sekat pemisah (*baffle plate*).
3. Air yang telah terpisah dari lemak keluar melalui pipa buang di kompartemen terakhir menuju saluran kota.

## Mengapa Grease Trap Wajib Dikuras Rutin?

- **Mencegah Luapan ke Dapur Operasional:** Jika lapisan lemak di atas melebihi batas 25% kapasitas volume, lemak akan lolos ke pipa hilir dan membeku di saluran utama.
- **Menghilangkan Bau Busuk H2S:** Lemak yang membusuk menghasilkan gas hidrogen sulfida yang menyengat dan mengganggu kenyamanan pelanggan restoran.
- **Kepatuhan Regulasi Lingkungan:** Dinas Lingkungan Hidup mewajibkan pelaku usaha kuliner menjaga baku mutu air limbah sebelum dialirkan ke badan air publik.

## Frekuensi Ideal Pembersihan

- **Dapur Ramai (Resto Cepat Saji/Komersial):** Pengambilan lapisan lemak padat setiap 1-2 hari sekali, dan pembersihan total kerak baffle setiap 2 minggu.
- **Kafe / Kedai Kopi:** Pengurasan komprehensif minimal 1 bulan sekali.",
                'meta_title' => 'Panduan Perawatan & Kuras Grease Trap Dapur Restoran - Drainusantara',
                'meta_description' => 'SOP lengkap pembersihan grease trap dapur komersial dan kafe. Hindari bau busuk dan luapan lemak dengan perawatan berkala terstandar.',
                'is_published' => true,
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Bahaya Menggunakan Kawat Gantungan Manual pada Pipa Belokan',
                'slug' => 'bahaya-kawat-manual-saluran-pipa-mampet',
                'thumbnail' => '/images/articles/bahaya-kawat-manual-saluran-pipa-mampet.webp',
                'category' => 'Tips & Edukasi',
                'excerpt' => 'Mencoba melancarkan kloset atau wastafel dengan kawat jemuran yang ditekuk sering berujung petaka: kawat tersangkut patah di leher angsa atau menusuk pipa PVC.',
                'content' => "Banyak pemilik rumah berinisiatif meluruskan gantungan baju kawat (*wire coat hanger*) ketika menghadapi saluran pembuangan air yang tersumbat. Meskipun terlihat sederhana dan hemat, metode darurat ini memiliki tingkat kegagalan tinggi dan risiko kerusakan fisik yang fatal.

## Risiko Penggunaan Kawat Manual Rakitan

### 1. Kawat Tersangkut & Terkunci di Belokan P-Trap
Pipa sifon wastafel dan kloset memiliki kelokan tajam berbentuk huruf P atau S (*leher angsa*). Kawat jemuran biasa memiliki sifat kaku dan tidak fleksibel. Saat didorong paksa, ujung kawat dapat melipat dan mengunci diri di dalam pipa, sehingga kawat tidak bisa ditarik maju maupun mundur.

### 2. Menusuk Dinding Pipa PVC yang Tipis
Ujung kawat gantungan yang dipotong memiliki sudut tajam runcing. Pada pipa paralon tipis (tipe D), dorongan kawat dapat melubangi dinding pipa dan menyebabkan kebocoran air kotor merembes ke dinding semen rumah.

### 3. Menggores Lapisan Glazur Keramik Kloset
Bahan baja kawat jemuran yang bergesekan dengan porselen kloset akan meninggalkan bekas goresan hitam permanen yang merusak estetika dan memudahkan kuman bersarang.

## Mengapa Kabel Spiral Khusus Jauh Lebih Aman?

Kabel pembersih saluran profesional (*drain snake / rooter*) dibuat dari **baja karbon pegas fleksibel dengan inti lentur**. Kabel ini dirancang khusus untuk:
- Meliuk bebas 90 hingga 180 derajat mengikuti lekukan pipa tanpa merusak dinding dalam.
- Berputar pada porosnya sendiri (*rotary motion*) untuk melilit rambut dan menghancurkan kerak lemak tanpa menusuk.
- Dilengkapi kepala modular yang aman bagi porselen toilet duduk maupun jongkok.",
                'meta_title' => 'Bahaya Menggunakan Kawat Manual untuk Pipa Mampet - Drainusantara',
                'meta_description' => 'Hindari kawat jemuran untuk melancarkan saluran pipa wastafel dan kloset. Pelajari risiko kawat tersangkut dan solusi mesin spiral lentur.',
                'is_published' => true,
                'published_at' => now()->subDays(18),
            ],
        ];

        foreach ($articlesData as $art) {
            Article::updateOrCreate(['slug' => $art['slug']], $art);
        }
    }
}
