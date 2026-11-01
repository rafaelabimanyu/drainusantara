<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sinkService = Service::where('slug', 'wastafel-cuci-piring-mampet')->first();
        $toiletService = Service::where('slug', 'kloset-wc-mampet')->first();
        $floorDrainService = Service::where('slug', 'floor-drain-kamar-mandi')->first();
        $cctvService = Service::where('slug', 'inspeksi-kamera-cctv-pipa')->first();

        $galleriesData = [
            [
                'title' => 'Pelancaran Pipa Wastafel Dapur Restoran',
                'slug' => 'pelancaran-pipa-wastafel-dapur-restoran',
                'category' => 'fnb',
                'location' => 'Kelapa Gading, Jakarta Utara',
                'property_type' => ['Restoran & Kafe', 'Dapur Komersial'],
                'problem_type' => ['Endapan Lemak Jenuh', 'Sisa Makanan Beku'],
                'severity' => 'berat',
                'duration' => '45 Menit',
                'price' => 450000,
                'method' => 'Mesin Spiral Rotary Ridgid K-50 dengan Cutter Lemak',
                'drain_type' => 'Pipa Wastafel Cuci Piring 2 Inch (12 Meter)',
                'diagnosis' => 'Penumpukan endapan minyak beku tebal sepanjang 12 meter pada jalur buang sink dapur menuju bak kontrol utama.',
                'service_id' => $sinkService?->id,
                'before_image' => '/images/dokumentasi/pelancar-saluran-gutter-resto-jakarta.webp',
                'after_image' => '/images/dokumentasi/pembersihan-grease-trap-restoran.webp',
                'image' => '/images/dokumentasi/pelancar-saluran-gutter-resto-jakarta.webp',
                'description' => 'Pembersihan pipa pembuangan sink dapur sepanjang 12 meter dari endapan minyak beku menggunakan mesin rooter spiral baja tanpa membongkar keramik lantai.',
                'content' => "Tim teknisi Drainusantara dipanggil ke lokasi restoran di area Kelapa Gading karena bak cuci piring (sink kitchen) meluap setiap kali jam operasional sibuk.\n\nSetelah dilakukan pengecekan, pipa PVC 2 inch tersumbat kerak minyak jenuh yang mengeras akibat bertahun-tahun dipakai tanpa grease trap berkala. Menggunakan unit Ridgid K-50 kabel spiral lentur dengan mata pisau bulb auger dan spade cutter, teknisi berhasil menghancurkan kerak lemak beku hingga pipa kembali plong 100% tanpa merusak struktur lantai dapur.",
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Ekstraksi Benda Asing dari Kloset Duduk Hunian',
                'slug' => 'ekstraksi-benda-asing-dari-kloset-duduk-hunian',
                'category' => 'rumahan',
                'location' => 'Kebayoran Baru, Jakarta Selatan',
                'property_type' => ['Rumah Tinggal', 'Hunian Residensial'],
                'problem_type' => ['Sumbatan Benda Asing', 'Kloset Meluap'],
                'severity' => 'sedang',
                'duration' => '35 Menit',
                'price' => 350000,
                'method' => 'Mesin Spiral Fleksibel Hook Retriever Tanpa Bongkar Kloset',
                'drain_type' => 'Kloset Duduk Leher Angsa (S-Trap 4 Inch)',
                'diagnosis' => 'Gumpalan tisu basah dan mainan plastik kecil tersangkut di lekukan leher angsa sifon kloset duduk.',
                'service_id' => $toiletService?->id,
                'before_image' => null,
                'after_image' => null,
                'image' => '/images/dokumentasi/pelancar-saluran-kloset-toilet-mampet.webp',
                'description' => 'Penarikan mainan dan gumpalan tisu yang menyumbat leher angsa toilet duduk rumah tinggal di Jakarta Selatan dalam 35 menit tanpa melepas kloset.',
                'content' => "Kloset duduk di lantai 2 hunian di Jakarta Selatan meluap airnya saat disiram (flushing). Pemilik rumah sempat mencoba cairan kimia namun air tetap menggenang.\n\nTeknisi Drainusantara menggunakan kabel spiral khusus toilet retriever yang dilapisi pelindung agar mangkuk keramik porselen kloset tidak lecet. Benda asing berhasil ditarik keluar dengan aman dalam tempo 35 menit tanpa perlu membongkar baut dinabolt dudukan kloset.",
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Pelancaran Floor Drain Kamar Mandi Utama',
                'slug' => 'pelancaran-floor-drain-kamar-mandi-utama',
                'category' => 'rumahan',
                'location' => 'BSD City, Tangerang Selatan',
                'property_type' => ['Rumah Tinggal', 'Kamar Mandi Utama'],
                'problem_type' => ['Gumpalan Rambut', 'Kerak Busa Sabun'],
                'severity' => 'ringan',
                'duration' => '30 Menit',
                'price' => 300000,
                'method' => 'Spiral Baja Mekanis Rotary Ridgid K-50',
                'drain_type' => 'Floor Drain Kamar Mandi Pipa 2.5 Inch',
                'diagnosis' => 'Anyaman rambut panjang menggumpal dengan residu sabun mandi dan shampoo pada siku sambungan elbow pipa.',
                'service_id' => $floorDrainService?->id,
                'before_image' => '/images/dokumentasi/pelancar-mesin-ridgid-floor-drain-kamar-mandi.webp',
                'after_image' => '/images/dokumentasi/pelancar-bak-kontrol-perumahan-warga.webp',
                'image' => '/images/dokumentasi/pelancar-mesin-ridgid-floor-drain-kamar-mandi.webp',
                'description' => 'Penanganan saluran buang kamar mandi tersumbat gumpalan rambut dan kerak busa sabun tebal di perumahan BSD Tangerang Selatan.',
                'content' => "Genangan air setinggi mata kaki kerap terjadi saat penghuni mandi di kamar mandi utama. Hal ini sangat mengganggu kenyamanan dan memicu lumut licin.\n\nDengan penetrasi spiral baja lentur Ridgid, gumpalan rambut yang membentuk sumbat jaring di dalam elbow pipa berhasil dikait keluar. Saluran dibilas dengan debit air penuh dan terbukti lancar seketika.",
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Inspeksi Kamera CCTV Pipa Bawah Tanah Ruko Kantor',
                'slug' => 'inspeksi-kamera-cctv-pipa-bawah-tanah-ruko-kantor',
                'category' => 'ruko',
                'location' => 'Simpang Lima, Kota Semarang',
                'property_type' => ['Ruko 3 Lantai', 'Perkantoran Bisnis'],
                'problem_type' => ['Intrusi Akar Pohon', 'Pipa Retak'],
                'severity' => 'berat',
                'duration' => '1.5 Jam',
                'price' => 650000,
                'method' => 'Inspeksi Digital Kamera Endoskopi CCTV IP68 30 Meter & Rooter Heavy Duty',
                'drain_type' => 'Saluran Utama Air Kotor Bawah Tanah 4 Inch',
                'diagnosis' => 'Akar pohon bintaro menembus sambungan pipa bawah tanah pada jarak 8.5 meter dari bak kontrol ruko.',
                'service_id' => $cctvService?->id,
                'before_image' => null,
                'after_image' => null,
                'image' => '/images/dokumentasi/inspeksi-kamera-cctv-pipa-tersumbat.webp',
                'description' => 'Deteksi visual pipa saluran air kotor sepanjang 20 meter di ruko perkantoran Semarang. Ditemukan akar pohon menembus sambungan pipa.',
                'content' => "Manajemen gedung ruko mengeluhkan saluran buang yang berulang kali mampet meski sudah disiram air panas berkali-kali. Pihak penyewa curiga ada pipa pecah di bawah pondasi.\n\nKamera inspeksi IP68 berkabel serat kaku dimasukkan sepanjang pipa. Monitor warna secara presisi memperlihatkan serabut akar tanaman yang menjalar di sambungan lem. Setelah titik lokasi dan kedalaman dipastikan akurat, teknisi menggunakan pemotong akar spiral khusus untuk membersihkan saluran tuntas.",
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Kuras Grease Trap & Sedot Lemak Kafe Komersial',
                'slug' => 'kuras-grease-trap-dan-sedot-lemak-kafe-komersial',
                'category' => 'fnb',
                'location' => 'Senopati, Jakarta Selatan',
                'property_type' => ['Kafe & Resto Modern', 'F&B Komersial'],
                'problem_type' => ['Grease Trap Meluap', 'Bau Saluran Menyengat'],
                'severity' => 'sedang',
                'duration' => '1 Jam',
                'price' => 500000,
                'method' => 'Penyedotan Lemak Mekanis & Pembersihan Sekat Baffle Grease Trap',
                'drain_type' => 'Perangkap Lemak Stainless 60 Liter & Jalur Buang Gutter',
                'diagnosis' => 'Sekat baffle perangkap lemak penuh gumpalan minyak jenuh dan kerak ampas kopi yang mengendap.',
                'service_id' => $sinkService?->id,
                'before_image' => '/images/dokumentasi/pembersihan-grease-trap-restoran.webp',
                'after_image' => '/images/dokumentasi/pelancar-saluran-gutter-resto-jakarta.webp',
                'image' => '/images/dokumentasi/pembersihan-grease-trap-restoran.webp',
                'description' => 'Pembersihan kerak minyak jenuh dan lumpur sisa olahan makanan pada bak perangkap lemak dapur kafe komersial di Kelapa Gading.',
                'content' => "Pembersihan berkala bak grease trap dapur kafe di kawasan Senopati guna mencegah bau tak sedap dan kepatuhan standar sanitasi dinas lingkungan hidup. Lemak beku diangkat total dan pipa buang dibilas hingga bersih.",
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Pelancaran Pipa Talang Air Hujan Rooftop Hunian',
                'slug' => 'pelancaran-pipa-talang-air-hujan-rooftop-hunian',
                'category' => 'rumahan',
                'location' => 'Tebet, Jakarta Selatan',
                'property_type' => ['Rumah Tinggal 2 Lantai', 'Rooftop & Talang'],
                'problem_type' => ['Endapan Dedaunan Kering', 'Lumut & Lumpur Pasir'],
                'severity' => 'sedang',
                'duration' => '40 Menit',
                'price' => 350000,
                'method' => 'Spiral Baja Lentur 22mm Mesin Ridgid K-60',
                'drain_type' => 'Pipa Talang Vertikal 3 Inch Menuju Got Luar',
                'diagnosis' => 'Akumulasi lumpur lapuk dedaunan pohon mangga yang menyumbat belokan elbow bawah pipa talang.',
                'service_id' => $floorDrainService?->id,
                'before_image' => null,
                'after_image' => null,
                'image' => '/images/dokumentasi/pelancar-bak-kontrol-perumahan-warga.webp',
                'description' => 'Penembusan kabel spiral baja lentur 22mm pada pipa talang tegak rumah tinggal yang tersumbat endapan lumut dan dedaunan kering di Tebet.',
                'content' => "Saat hujan lebat, rooftop rumah tinggal meluap hingga air merembes ke plafon kamar lantai dua. Hal ini disebabkan pipa talang tegak 3 inch buntu total.\n\nKabel spiral 22mm dimasukkan dari atap hingga menembus elbow lantai dasar. Seluruh sampah daun kering dan endapan lumpur tersapu keluar ke parit depan rumah.",
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($galleriesData as $item) {
            Gallery::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
