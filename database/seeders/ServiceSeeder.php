<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicesData = [
            [
                'name' => 'Wastafel & Cuci Piring',
                'slug' => 'wastafel-cuci-piring-mampet',
                'short_description' => 'Pelancaran saluran bak cuci piring tersumbat lemak beku dan sisa makanan tanpa bongkar meja dapur.',
                'description' => 'Saluran bak cuci piring (kitchen sink) seringkali tersumbat akibat penumpukan lemak sisa masakan, minyak, dan partikel makanan yang mengeras di dinding pipa. Kami menggunakan mesin spiral fleksibel berkecepatan tinggi untuk mengeruk dan menghancurkan kerak lemak hingga bersih tanpa merusak pipa sifon.',
                'icon' => 'sink',
                'image' => '/images/services/drainusantara-jasa-perbaikan-saluran-wastafel-cuci-piring-mampet.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Pembersihan kerak lemak membandel',
                    'Kabel spiral baja lentur khusus sifon',
                    'Aman untuk instalasi pipa sifon PVC',
                    'Garansi 30 hari pengerjaan tuntas',
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
                'image' => '/images/services/drainusantara-jasa-perbaikan-saluran-kloset-wc-toilet-mampet.webp',
                'price_starting_from' => 400000,
                'features' => [
                    '100% tanpa bongkar kloset & keramik',
                    'Daya dorong & pemecah sumbatan kuat',
                    'Teknisi higienis ber-APD & cover sepatu',
                    'Garansi 30 hari pengerjaan tuntas',
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
                'image' => '/images/services/drainusantara-jasa-perbaikan-saluran-floor-drain-kamar-mandi-mampet.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Menembus endapan rambut & sabun',
                    'Bebas bau got & higienis',
                    'Pengerjaan cepat 30-45 menit',
                    'Garansi 30 hari pengerjaan tuntas',
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
                'image' => '/images/services/drainusantara-jasa-perbaikan-saluran-talang-rooftop-pipa-atap-mampet.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Jangkauan spiral baja hingga 30 meter',
                    'Membersihkan lumpur, lumut & dedaunan',
                    'Mencegah kebocoran plafon rumah',
                    'Garansi 30 hari pengerjaan tuntas',
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
                'image' => '/images/services/drainusantara-jasa-perbaikan-kuras-grease-trap-lemak-restoran.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Pembersihan kerak minyak & lemak jenuh',
                    'Layanan after-hours bebas bau menyengat',
                    'Tersedia faktur pajak & dokumen BAST',
                    'Garansi 30 hari pengerjaan tuntas',
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
                'image' => '/images/services/drainusantara-jasa-inspeksi-kamera-cctv-saluran-pipa-endoskopi.webp',
                'price_starting_from' => 400000,
                'features' => [
                    'Jangkauan kabel push-rod 30 meter',
                    'Kamera tahan air IP68 dengan LED sorot',
                    'Dokumentasi rekaman video & foto MP4',
                    'Diagnosis masalah presisi tanpa tebak',
                ],
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($servicesData as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
