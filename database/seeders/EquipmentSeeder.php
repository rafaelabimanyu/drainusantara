<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipmentsData = [
            [
                'name' => 'Mesin Drain Rooter Spiral Baja Rotary Ridgid K-50 & K-60',
                'slug' => 'mesin-drain-rooter-spiral-baja-rotary-ridgid-k-50-k-60',
                'category' => 'Mesin Utama',
                'badge' => '100% Mekanis',
                'image' => '/assets/TOOLKIT/mesin-spiral-rotary.webp',
                'short_description' => 'Kabel spiral lentur berinti baja karbon berputar 400 RPM untuk meluncur di leher angsa dan mengikis endapan tanpa merusak pipa.',
                'description' => "Mesin drain cleaner Ridgid K-50 & K-60 merupakan tulang punggung armada Drainusantara untuk penanganan saluran pipa mampet residensial dan komersial. Beroperasi secara mekanis murni tanpa bahan kimia soda api, mesin ini memutar kabel spiral baja karbon berkecepatan 400 RPM dengan torsi adaptif.\n\nKabel spiral lentur mampu meluncur mulus melewati sambungan belokan leher angsa (sifon P-trap) dan elbow 90 derajat tanpa mengikis atau melubangi dinding pipa PVC. Putaran spiral efektif mengikis kerak lemak beku, merajut dan menarik keluar gumpalan rambut, serta menghancurkan endapan sisa makanan hingga diameter pipa kembali ke kapasitas aliran optimal 100%.",
                'specs' => [
                    'Jangkauan: Hingga 30 meter sambung modular',
                    'Diameter Pipa: Efektif untuk pipa 1.5 sampai 6 inci',
                    'Aksi Kerja: Mengikis lemak padat, menarik rambut, dan memotong akar',
                    'Tenaga: Motor Listrik 220V 400 RPM Standard Industri',
                ],
                'features' => [
                    'Motor penggerak elektrik 220V bertenaga tinggi dengan putaran stabil 400 RPM',
                    'Kabel spiral baja karbon tempa modular ukuran 16mm dan 22mm anti-kinking',
                    'Sistem kopling aksi instan: kabel berhenti berputar begitu tuas dilepas untuk keamanan pipa',
                    'Jangkauan modular fleksibel hingga 30 meter menembus pipa bawah lantai dan dak beton',
                    'Dapat dipasangi berbagai mata pisau pemotong (Bulb Auger, Grease Cutter, Spade Cutter)',
                ],
                'applications' => [
                    'Saluran pembuangan wastafel & bak cuci piring dapur (sink) mampet minyak',
                    'Kloset duduk & jongkok tersumbat tisu basah, pembalut, atau benda lunak',
                    'Floor drain kamar mandi menggenang akibat jeratan rambut rontok dan buih sabun',
                    'Saluran pipa talang hujan vertikal dan pipa pembuangan dak rooftop',
                    'Pipa instalasi saluran air kotor ruko, restoran, kafe, dan perkantoran',
                ],
                'safety_k3' => 'Teknisi Drainusantara wajib mengenakan sarung tangan kulit khusus anti-lilit spiral, kacamata pelindung (goggles), dan cover sepatu higienis. Mesin dilengkapi kabel grounding pengaman kelistrikan untuk mencegah kebocoran arus di area basah.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Kamera CCTV Endoskopi Pipa IP68 30 Meter',
                'slug' => 'kamera-cctv-endoskopi-pipa-ip68-30-meter',
                'category' => 'Diagnosis Visual',
                'badge' => 'Diagnosis Visual',
                'image' => '/assets/TOOLKIT/kamera-cctv-pipa.webp',
                'short_description' => 'Unit kamera industri tahan air beresolusi tinggi dengan lampu LED sorot adjustable dan kabel dorong fleksibel kaku untuk melihat langsung kondisi dalam pipa.',
                'description' => "Kamera Endoskopi CCTV Pipa IP68 30M adalah instrumen diagnostik visual presisi tinggi milik Drainusantara untuk menginvestigasi saluran pipa air kotor yang sering mampet berulang tanpa harus menebak titik kerusakan.\n\nKepala kamera berukuran ringkas dilengkapi sensor HD 1080P, lensa safir anti-gores, dan 12 titik LED sorot tahan air. Terhubung ke kabel dorong fiberglass 30 meter yang kaku namun lentur, kamera ini mampu masuk ke dalam pipa diameter 2 hingga 8 inci dan menampilkan rekaman realtime pada monitor kontrol LCD.",
                'specs' => [
                    'Jangkauan Inspeksi: Kabel push-rod fiberglass 30 meter',
                    'Pencahayaan: 12 LED ultra-bright dengan lensa safir anti-gores',
                    'Dokumentasi: Rekaman video MP4 & foto resolusi tinggi untuk klien',
                    'Ketahanan: IP68 Submersible Tahan Tekanan Air',
                ],
                'features' => [
                    'Kepala kamera kedap air standar IP68 Submersible tahan tekanan lumpur dan genangan',
                    'Lensa safir optik kristal anti-gores dengan 12 lampu LED sorot adjustable brightness',
                    'Kabel dorong push-rod fiberglass tahan tekuk sepanjang 30 meter berpenghitung meter digital',
                    'Layar monitor display digital HD dengan fitur perekaman video inspeksi MP4 dan foto',
                    'Memverifikasi titik pipa pecah, sambungan lepas, kemiringan kurang (back-slope), atau akar pohon',
                ],
                'applications' => [
                    'Investigasi saluran pipa tertanam di bawah lantai rumah yang sering mampet berulang',
                    'Pemeriksaan titik kebocoran pipa buangan yang merembes ke dinding atau plafon tetangga',
                    'Deteksi intrusi akar pohon yang menembus sambungan pipa drainase luar ruangan',
                    'Dokumentasi pra-kerja dan pasca-kerja untuk verifikasi kebersihan saluran pipa klien B2B',
                ],
                'safety_k3' => 'Unit kamera selalu disterilkan dan didesinfeksi sebelum dan sesudah masuk ke pipa pembuangan. Seluruh koneksi kabel sinyal memiliki pelindung ganda kedap air berstandar IP68.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Unit Pembersih Saluran High Pressure Hydro Jetting',
                'slug' => 'unit-pembersih-saluran-high-pressure-hydro-jetting',
                'category' => 'Hydro Jetting',
                'badge' => 'Tekanan Tinggi',
                'image' => '/assets/TOOLKIT/hydro-jetting.webp',
                'short_description' => 'Semburan air bertekanan tinggi 100-200 bar untuk mengikis dan membilas tumpukan minyak beku, kerak lumpur, dan lemak pada restoran dan industri.',
                'description' => "Unit High-Pressure Hydro Jetting Drainusantara dirancang khusus untuk pencucian saluran pipa berskala berat pada restoran, food court, ruko, dan pabrik pengolahan makanan. Menggunakan prinsip semburan air mikro bertekanan variabel 100 hingga 200 bar.\n\nNozel jetting khusus memiliki semburan maju untuk menembus sumbatan dan semburan mundur berkecepatan tinggi yang mendorong selang maju sekaligus membilas bersih kerak lemak padat, lumpur semen, dan residu kimiawi hingga ke dinding pipa PVC.",
                'specs' => [
                    'Tekanan Air: 100 - 200 Bar nozel multifungsi',
                    'Target Masalah: Grease trap, pipa dapur resto, sedimentasi pasir',
                    'Hasil: Dinding pipa bersih total seperti baru dipasang',
                    'Metode: 100% Eco-Friendly tanpa bahan kimia korosif',
                ],
                'features' => [
                    'Tekanan air bertenaga tinggi 100 sampai 200 Bar dengan pompa triplex plunger heavy-duty',
                    'Nozel putar rotary jetter dan nozel retro-jet dengan daya dorong mandiri',
                    'Membersihkan minyak jenuh dan kerak minyak goreng beku hingga 100% tuntas',
                    'Metode 100% ramah lingkungan (eco-friendly) murni tekanan air tanpa zat kimia korosif',
                    'Panjang selang termoplastik tahan gesek hingga 50 meter',
                ],
                'applications' => [
                    'Pipa pembuangan dapur utama restoran cepat saji, hotel, kafe, dan katering',
                    'Saluran grease trap menuju bak kontrol akhir yang mengalami pengendapan lemak beku',
                    'Pipa got tertutup komplek hunian yang dipenuhi sedimen pasir dak dan lumpur padat',
                    'Pembersihan preventif berkala (kontrak perawatan) industri F&B dan komersial',
                ],
                'safety_k3' => 'Wajib dioperasikan oleh 2 teknisi bersertifikat dengan APD lengkap: face shield, sarung tangan anti-slip tebal, dan sepatu boots tahan tekanan tinggi.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Set 4 Jenis Mata Pemotong Spiral Baja Modular',
                'slug' => 'set-4-jenis-mata-pemotong-spiral-baja-modular',
                'category' => 'Mata Cutter',
                'badge' => '4 Tipe Cutter',
                'image' => '/assets/TOOLKIT/cutter-mata-spiral.webp',
                'short_description' => '4 mata cutter baja karbon tempa khusus: Bulb Auger (rambut/tisu), Grease Cutter (lemak), Spade Cutter (kerak lumpur), dan Sawtooth Root Cutter (akar).',
                'description' => "Set Mata Pemotong Spiral Baja Modular Drainusantara terdiri dari 4 varian kepala cutter baja karbon tempa berdesain khusus. Setiap kepala pisau memiliki geometri unik untuk menghadapi jenis sumbatan spesifik tanpa risiko merusak dinding bagian dalam pipa paralon.\n\nDipasang pada ujung kabel spiral Ridgid dengan sistem pengunci quick-connect berpegas ganda, mata pisau berputar dengan kecepatan tinggi untuk melilit rambut, mengikis lemak membandel, meratakan semen lunak, hingga memotong akar pohon yang menerobos ke dalam pipa.",
                'specs' => [
                    'Bulb Auger: Fleksibel meliuk leher angsa wastafel & kloset',
                    'Grease Cutter: Mata pisau pengikis kerak minyak jenuh',
                    'Spade Cutter: Pisau pipih mengikis semen, pasir & lumpur',
                    'Root Cutter: Gigi gergaji melingkar pemotong akar pohon',
                ],
                'features' => [
                    'Bulb Auger: Kepala spiral bulat fleksibel meliuk di leher angsa kloset & sifon',
                    'Grease Cutter: Bilah ganda bergerigi khusus memecah dan mengikis kerak lemak beku',
                    'Spade Cutter: Pisau pipih lebar untuk mengikis kerak endapan lumpur padat dan pasir',
                    'Sawtooth Root Cutter: Gigi gergaji melingkar baja keras untuk memotong serat akar pohon',
                    'Sistem pengunci pasak pegas anti-lepas di dalam pipa saat rotasi bolak-balik',
                ],
                'applications' => [
                    'Mengangkat gumpalan rambut kusut dan sisa sabun mandi di floor drain',
                    'Menghancurkan kerak lemak membatu pada bak cuci piring dan leher angsa wastafel',
                    'Memotong akar pohon yang masuk melalui celah sambungan pipa bawah tanah pekarangan',
                    'Membersihkan sisa mortar semen atau kotoran pasca renovasi bangunan',
                ],
                'safety_k3' => 'Pengecekan integritas pasak pengunci sebelum masuk ke lubang saluran untuk memastikan mata pisau tidak tertinggal di dalam instalasi pipa.',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($equipmentsData as $equip) {
            Equipment::updateOrCreate(['name' => $equip['name']], $equip);
        }
    }
}
