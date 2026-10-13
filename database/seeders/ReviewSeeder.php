<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wastafelService = Service::where('slug', 'wastafel-cuci-piring-mampet')->first();
        $toiletService = Service::where('slug', 'kloset-wc-mampet')->first();
        $cctvService = Service::where('slug', 'inspeksi-kamera-cctv-pipa')->first();

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
            Review::updateOrCreate([
                'customer_name' => $review['customer_name'],
                'customer_role_or_location' => $review['customer_role_or_location'],
            ], $review);
        }
    }
}
