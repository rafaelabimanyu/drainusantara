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
                return "Halo Tim Drainusantara, saya membutuhkan jasa pelancaran pipa mampet di area Kecamatan {$district}, {$city}. Mohon info estimasi biaya dan teknisi terdekat.";

            case 'area.city':
                $city = Str::title(str_replace('-', ' ', (string) ($params['city'] ?? '')));
                return "Halo Tim Drainusantara, saya butuh penanganan saluran pipa mampet di wilayah {$city}. Mohon info armada terdekat.";

            case 'area.province':
                $province = Str::title(str_replace('-', ' ', (string) ($params['province'] ?? '')));
                return "Halo Tim Drainusantara, saya ingin konsultasi layanan saluran pipa mampet untuk wilayah {$province}.";

            case 'area.index':
                return "Halo Tim Drainusantara, saya ingin info cakupan posko teknisi pelancar pipa mampet untuk lokasi saya. Terima kasih.";

            case 'equipment.show':
                $slug = (string) ($params['slug'] ?? '');
                $name = Str::title(str_replace('-', ' ', $slug));
                return "Halo Tim Drainusantara, saya ingin konsultasi penanganan saluran menggunakan unit {$name}. Mohon info estimasi biaya dan jadwal kedatangan teknisi.";

            case 'about.equipment':
                return "Halo Tim Drainusantara, saya ingin konsultasi mengenai peralatan mesin spiral baja dan kamera inspeksi CCTV pipa tanpa bongkar keramik.";

            case 'about.warranty':
                return "Halo Tim Drainusantara, saya ingin konsultasi terkait ketentuan garansi resmi pengerjaan saluran 30 hari Drainusantara.";

            case 'about.k3':
                return "Halo Tim Drainusantara, saya ingin info mengenai standar operasional dan SOP K3 teknisi Drainusantara.";

            case 'about.holding':
            case 'about.portfolio':
                return "Halo Tim Drainusantara, kami ingin konsultasi kerja sama pemeliharaan saluran berkala B2B untuk restoran/hotel/perkantoran.";

            case 'articles.show':
            case 'articles.silo':
                $slug = (string) ($params['slug'] ?? '');
                $article = $slug !== '' ? \App\Models\Article::where('slug', $slug)->first() : null;
                $title = $article ? $article->title : 'Edukasi';
                return "Halo Tim Drainusantara, saya sedang membaca artikel '{$title}' dan ingin konsultasi penanganan saluran pipa di tempat saya.";

            case 'case-study.show':
                $slug = (string) ($params['slug'] ?? '');
                $gallery = $slug !== '' ? \App\Models\Gallery::where('slug', $slug)->first() : null;
                $title = $gallery ? $gallery->title : 'Studi Kasus';
                return "Halo Tim Drainusantara, saya melihat dokumentasi '{$title}' dan ingin tanya estimasi untuk penanganan serupa.";

            case 'partnership.show':
                $slug = (string) ($params['slug'] ?? '');
                $portfolio = $slug !== '' ? \App\Models\Portfolio::where('slug', $slug)->first() : null;
                $title = $portfolio ? ($portfolio->project_title ?: $portfolio->client_name) : 'Kemitraan';
                return "Halo Tim Drainusantara, saya melihat dokumentasi '{$title}' dan ingin tanya estimasi untuk penanganan serupa.";

            default:
                return "Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.";
        }
    }
}

