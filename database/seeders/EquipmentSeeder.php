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
                'category' => 'Mesin Utama',
                'badge' => '100% Mekanis',
                'image' => '/assets/TOOLKIT/mesin-spiral-rotary.webp',
                'short_description' => 'Kabel spiral lentur berinti baja karbon berputar 400 RPM untuk meluncur di leher angsa dan mengikis endapan tanpa merusak pipa.',
                'specs' => [
                    'Jangkauan: Hingga 30 meter sambung modular',
                    'Diameter Pipa: Efektif untuk pipa 1.5 sampai 6 inci',
                    'Aksi Kerja: Mengikis lemak padat, menarik rambut, dan memotong akar',
                    'Tenaga: Motor Listrik 220V 400 RPM Standard Industri',
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
                    'Ketahanan: IP68 Submersible Tahan Tekanan Air',
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
                    'Metode: 100% Eco-Friendly tanpa bahan kimia korosif',
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
                    'Root Cutter: Gigi gergaji melingkar pemotong akar pohon',
                ],
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($equipmentsData as $equip) {
            Equipment::updateOrCreate(['name' => $equip['name']], $equip);
        }
    }
}
