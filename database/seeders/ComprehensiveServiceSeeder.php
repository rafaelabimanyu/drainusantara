<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ComprehensiveServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Hanya menambahkan katalog Layanan baru (Draft / Tidak Tampil Publik: is_active = false)
     * tanpa penambahan data galeri dokumentasi.
     */
    public function run(): void
    {
        $newServices = [
            [
                'name' => 'Hydro Jetting Saluran Utama (High Pressure)',
                'slug' => 'hydro-jetting-saluran-utama',
                'short_description' => 'Pembersihan pipa diameter besar menggunakan tembakan air bertekanan hingga 300 bar untuk merontokkan kerak semen dan endapan lumpur padat.',
                'description' => 'Layanan pembersihan jalur pipa induk (main drain line) berdiameter 4 hingga 12 inch menggunakan mesin Hydro Jetter bertekanan ultra tinggi. Nozzle semprot khusus berputar 360 derajat membilas dinding pipa dari kerak kapur, lumpur keras, endapan kimia industri, dan lemak tebal hingga pipa kembali ke diameter aslinya.',
                'icon' => 'hydro-jet',
                'image' => '/images/services/pelancar-bak-kontrol-perumahan-warga.webp',
                'price_starting_from' => 1200000,
                'order' => 8,
                'is_active' => false,
                'features' => [
                    'Tekanan air stabil hingga 250 - 300 Bar',
                    'Mengikis tuntas kerak semen & lumpur membatu',
                    'Aman untuk pipa beton cor maupun PVC industri',
                    'Panjang selang jangkauan hingga 50 meter',
                    'Termasuk pembilasan total bebas residu',
                ],
            ],
            [
                'name' => 'Perbaikan Pipa Tersumbat Akar Pohon (Root Cutter)',
                'slug' => 'perbaikan-pipa-tersumbat-akar-pohon',
                'short_description' => 'Pemotongan jaringan akar pohon liar yang menerobos sambungan pipa bawah tanah menggunakan spiral bermata pisau gergaji baja khusus.',
                'description' => 'Akar tanaman keras seringkali menyusup melalui celah sambungan pipa bawah tanah dan membentuk jaring sumbatan masif. Menggunakan mesin mekanis Ridgid Heavy-Duty dengan mata pemotong akar gergaji rotary (Sawtooth Root Cutter), akar pohon dipotong dan dicacah habis dari dalam pipa tanpa perlu menggali taman atau membongkar lantai halaman.',
                'icon' => 'root-cutter',
                'image' => '/images/services/teknisi-apd-lengkap-sink-pabrik-makanan.webp',
                'price_starting_from' => 750000,
                'order' => 9,
                'is_active' => false,
                'features' => [
                    'Mata pisau Sawtooth Root Cutter baja tempered',
                    'Mencacah akar pohon tanpa penggalian tanah/taman',
                    'Menjangkau pipa hingga kedalaman 3 meter di bawah tanah',
                    'Inspeksi visual CCTV untuk memastikan akar bersih',
                    'Garansi 30 hari pengerjaan tuntas',
                ],
            ],
            [
                'name' => 'Deteksi Kebocoran Pipa Akustik (Leak Detection)',
                'slug' => 'deteksi-kebocoran-pipa-akustik',
                'short_description' => 'Pencarian titik pipa bocor di dalam dinding atau bawah lantai keramik menggunakan sensor ultrasonik akustik tanpa merusak ubin.',
                'description' => 'Tagihan air PDAM melonjak drastis atau pompa booster menyala terus-menerus? Layanan deteksi kebocoran pipa tersembunyi menggunakan perangkat sensor frekuensi akustik ultrasonik dan pressure test gauge digital. Titik bocor dapat ditentukan dengan presisi tinggi hingga radius 20 cm tanpa perlu membongkar keramik secara membabi buta.',
                'icon' => 'leak-detection',
                'image' => '/images/services/inspeksi-kamera-cctv-pipa-tersumbat.webp',
                'price_starting_from' => 850000,
                'order' => 10,
                'is_active' => false,
                'features' => [
                    'Sensor akustik pendengar frekuensi desisan air bertekanan',
                    'Uji tekanan pipa (Hydrostatic Pressure Testing)',
                    'Menentukan titik bocor pipa tanpa bongkar lantai luas',
                    'Laporan titik kebocoran akurat bergaransi',
                    'Mencegah pemborosan tagihan air bulanan',
                ],
            ],
            [
                'name' => 'Kuras Toren Air & Ground Tank Steril',
                'slug' => 'kuras-toren-air-ground-tank-steril',
                'short_description' => 'Pembersihan dan desinfeksi lumut, endapan lumpur, dan jentik nyamuk pada tangki penampungan air atas dan bawah tanah.',
                'description' => 'Tangki penampungan air (toren rooftop dan ground water tank beton) rentan menjadi sarang lumut tebal, endapan sedimen karat, dan bakteri. Tim kami menguras, menyikat, dan mensterilkan dinding tandon air menggunakan water jetter dan zat sanitasi food-grade tanpa meninggalkan bau kaporit yang mengganggu.',
                'icon' => 'water-tank',
                'image' => '/images/services/pelancar-saluran-bio-tank-bogor-jabar.webp',
                'price_starting_from' => 350000,
                'order' => 11,
                'is_active' => false,
                'features' => [
                    'Pembersihan lumpur sedimen, lumut & karat air',
                    'Desinfektan antiseptik aman food-grade',
                    'Pengecekan pelampung otomatis & radar pompa',
                    'Melayani toren fiberglass, stainless steel & beton',
                    'Air kembali jernih, higienis & bebas bau',
                ],
            ],
            [
                'name' => 'Pelancaran Saluran Drainase SPBU, Bengkel & Cuci Mobil',
                'slug' => 'pelancaran-saluran-drainase-spbu-bengkel-cuci-mobil',
                'short_description' => 'Spesialis saluran limbah minyak, pasir lumpur tebal, dan oli bekas pada oil trap komersial tanpa mencemari lingkungan.',
                'description' => 'Saluran limbah fasilitas SPBU, bengkel otomotif, dan tempat cuci mobil (car wash) memiliki karakteristik sumbatan berat berupa kombinasi oli bekas pekat, lumpur tanah, dan pasir silika. Kami membersihkan kompartemen oil separator, sand trap, dan gorong-gorong tertutup menggunakan peralatan mekanis spiral baja dan pompa vakum lumpur.',
                'icon' => 'spbu-drain',
                'image' => '/images/services/servis-ridgid-gutter-resto-mampet.webp',
                'price_starting_from' => 1500000,
                'order' => 12,
                'is_active' => false,
                'features' => [
                    'Mengatasi sumbatan lumpur pasir bercampur oli & minyak',
                    'Pembersihan kompartemen Oil Separator & Sand Trap',
                    'Peralatan explosion-proof aman untuk area SPBU',
                    'Teknisi berpengalaman bersertifikasi standar K3',
                    'Dokumen pengerjaan resmi untuk kepatuhan AMDAL',
                ],
            ],
            [
                'name' => 'Pelancaran Saluran Limbah Pabrik & Kawasan Industri',
                'slug' => 'pelancaran-saluran-limbah-pabrik-industri',
                'short_description' => 'Penanganan pipa saluran limbah cair non-B3 pabrik makanan, farmasi, tekstil, dan kimia ringan berskala debit besar.',
                'description' => 'Jalur perpipaan industri rentan tersumbat oleh residu serat sintetis, endapan bahan baku produksi, dan gumpalan residu organik. Layanan kami dirancang untuk menangani pipa proses pabrik berdiameter 3 hingga 10 inch dengan perlengkapan spiral bermata auger ganda berjangkauan panjang tanpa menghentikan jadwal produksi harian.',
                'icon' => 'factory-drain',
                'image' => '/images/services/pelancaran-kloset-mampet-pabrik-industri.webp',
                'price_starting_from' => 1800000,
                'order' => 13,
                'is_active' => false,
                'features' => [
                    'Armada siaga pengerjaan jadwal shift malam / hari libur',
                    'Rooter heavy-duty kabel tebal anti-puntir 32mm',
                    'Penanganan pipa limbah non-B3 hingga panjang 60 meter',
                    'Peralatan steril dengan kepatuhan standar K3 Pabrik',
                    'Penerbitan Berita Acara Serah Terima (BAST) & Faktur Pajak',
                ],
            ],
            [
                'name' => 'Perawatan Saluran Urinoir & Pipa Vertikal Gedung (Stack Pipe)',
                'slug' => 'perawatan-saluran-urinoir-stack-pipe-gedung',
                'short_description' => 'Pembersihan kerak kristal urin (uric acid scale) dan pelancaran pipa vertikal bertingkat pada hotel, kantor, dan mall.',
                'description' => 'Saluran pembuangan urinoir pria seringkali tersumbat total oleh kerak kristal asam urin (uric acid) yang mengeras seperti karang batu di dinding pipa. Kami melakukan pengikisan mekanis menggunakan spiral khusus flex-shaft berkecepatan tinggi yang merontokkan kerak kristal tanpa memecahkan mangkuk keramik urinoir atau sambungan pipa vertikal antar lantai gedung.',
                'icon' => 'urinal-stack',
                'image' => '/images/services/pelancaran-saluran-mall-banjarmasin-mesin-ridgid-2.webp',
                'price_starting_from' => 500000,
                'order' => 14,
                'is_active' => false,
                'features' => [
                    'Mengikis kerak kristal urin (uric acid) yang membatu',
                    'Aman untuk instalasi leher angsa keramik urinoir',
                    'Penanganan pipa tegak vertikal (stack pipe) antar lantai',
                    'Mencegah bau pesing menyengat kembali ke toilet',
                    'Disediakan opsi paket pemeliharaan berkala gedung',
                ],
            ],
        ];

        foreach ($newServices as $serviceData) {
            Service::updateOrCreate(
                ['slug' => $serviceData['slug']],
                $serviceData
            );
        }
    }
}
