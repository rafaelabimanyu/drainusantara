<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class WhatsAppService
{
    /**
     * Get clean international WhatsApp number for wa.me links.
     */
    public static function getNumber(): string
    {
        $raw = (string) config('app.whatsapp_number', '6285609009009');
        $clean = preg_replace('/[^0-9]/', '', $raw);

        return $clean !== '' ? $clean : '6285609009009';
    }

    /**
     * Build full wa.me direct chat link with encoded message.
     */
    public static function buildUrl(string $message): string
    {
        return 'https://wa.me/'.self::getNumber().'?text='.rawurlencode($message);
    }

    /**
     * Determine dynamic contextual opening message based on current route and parameters.
     * All messages start with the brand greeting 'Halo Admin Drainusantara,'.
     */
    public static function getContextualMessage(): string
    {
        $route = request()->route()?->getName();
        $params = request()->route()?->parameters() ?? [];

        switch ($route) {
            case 'area.detail':
                $city = Str::title(str_replace('-', ' ', (string) ($params['city'] ?? '')));
                $district = Str::title(str_replace('-', ' ', (string) ($params['district'] ?? '')));
                return "Halo Admin Drainusantara, saya butuh bantuan darurat teknisi pipa mampet untuk area Kecamatan {$district}, {$city}. Apakah ada jadwal terdekat?";

            case 'area.city':
                $city = Str::title(str_replace('-', ' ', (string) ($params['city'] ?? '')));
                return "Halo Admin Drainusantara, saya butuh penanganan saluran pipa mampet di wilayah {$city}. Mohon info estimasi biaya dan kedatangan teknisi.";

            case 'area.province':
                $province = Str::title(str_replace('-', ' ', (string) ($params['province'] ?? '')));
                return "Halo Admin Drainusantara, saya ingin cek ketersediaan armada teknisi pipa mampet di Provinsi {$province}. Mohon infonya.";

            case 'area.index':
                return "Halo Admin Drainusantara, saya ingin info cakupan posko teknisi pelancar pipa mampet untuk lokasi saya. Terima kasih.";

            case 'equipment.show':
                $slug = (string) ($params['slug'] ?? '');
                $name = Str::title(str_replace('-', ' ', $slug));
                return "Halo Admin Drainusantara, saya ingin konsultasi penanganan saluran menggunakan unit {$name}. Mohon info estimasi biaya dan jadwal kedatangan teknisi.";

            case 'about.equipment':
                return "Halo Admin Drainusantara, saya ingin konsultasi mengenai peralatan mesin spiral baja dan kamera inspeksi CCTV pipa tanpa bongkar keramik.";

            case 'about.warranty':
                return "Halo Admin Drainusantara, saya ingin konsultasi terkait ketentuan garansi resmi pengerjaan saluran 30 hari Drainusantara.";

            case 'about.k3':
                return "Halo Admin Drainusantara, saya ingin info mengenai standar operasional dan SOP K3 teknisi Drainusantara.";

            case 'about.holding':
            case 'about.portfolio':
                return "Halo Admin Drainusantara, kami ingin konsultasi kerja sama pemeliharaan saluran berkala B2B untuk restoran/hotel/perkantoran.";

            case 'articles.show':
                return "Halo Admin Drainusantara, saya sedang membaca panduan teknis saluran pipa mampet dan ingin konsultasi masalah pipa di lokasi saya.";

            case 'case-study.show':
                return "Halo Admin Drainusantara, saya melihat dokumentasi studi kasus pengerjaan pipa mampet dan ingin memesan layanan serupa.";

            case 'partnership.show':
                return "Halo Admin Drainusantara, kami tertarik dengan kerja sama kemitraan B2B seperti yang tertera di portofolio Anda.";

            default:
                return "Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.";
        }
    }
}

