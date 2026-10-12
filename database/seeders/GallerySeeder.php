<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Database\Seeder;

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
            Gallery::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
