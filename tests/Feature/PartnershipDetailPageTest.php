<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnershipDetailPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_partnership_detail_page_renders_hero_background_image_from_portfolio_thumbnail(): void
    {
        $service = Service::create([
            'name' => 'Pelancaran Pipa Resto',
            'slug' => 'pelancaran-pipa-resto',
            'description' => 'Layanan pembersihan pipa restoran.',
            'is_active' => true,
        ]);

        $portfolio = Portfolio::create([
            'client_name' => 'Restoran Aroma Nusantara',
            'slug' => 'restoran-aroma-nusantara',
            'client_type' => 'F&B Komersial',
            'partnership_type' => 'kontrak-maintenance',
            'image' => '/images/portfolio/resto-aroma-nusantara.webp',
            'logo' => null,
            'description' => 'Kerjasama pemeliharaan rutin instalasi pipa dapur komersial.',
            'location' => 'Jakarta Selatan',
            'duration' => 'Kontrak 12 Bulan',
            'about_client' => 'Restoran keluarga dengan kapasitas 200 kursi.',
            'scope_of_work' => 'Pembersihan grease trap dan pipa pembuangan berkala.',
            'results_benefit' => 'Zero downtime dapur saat jam makan siang dan malam.',
            'is_active' => true,
        ]);

        $portfolio->services()->attach($service->id);

        $response = $this->get(route('partnership.show', $portfolio->slug));

        $response->assertStatus(200);

        // Verifikasi Hero Background Image
        $response->assertSee('/images/portfolio/resto-aroma-nusantara.webp', false);
        $response->assertSee('filter brightness-90', false);
        $response->assertSee('Restoran Aroma Nusantara');
        $response->assertSee('Kontrak Maintenance');
        $response->assertSee('Jakarta Selatan');

        // Verifikasi Fallback Inisial Klien
        $response->assertSee('AN'); // Inisial Aroma Nusantara

        // Verifikasi Konten Tetap Utuh
        $response->assertSee('Executive Partnership Memo');
        $response->assertSee('Ruang Lingkup Tindakan Teknis');
        $response->assertSee('Hasil & Nilai Tambah Operasional', false);
        $response->assertSee('Konsultasi Kemitraan');
    }

    public function test_partnership_detail_page_renders_cleanly_when_image_is_null(): void
    {
        $portfolio = Portfolio::create([
            'client_name' => 'Kafe Senja Kopi',
            'slug' => 'kafe-senja-kopi',
            'client_type' => 'Coffee Shop',
            'partnership_type' => 'emergency',
            'image' => null,
            'logo' => null,
            'description' => 'Penanganan pipa bar mampet darurat.',
            'location' => 'Bandung',
            'is_active' => true,
        ]);

        $response = $this->get(route('partnership.show', $portfolio->slug));

        $response->assertStatus(200);
        $response->assertSee('Kafe Senja Kopi');
        $response->assertSee('Layanan Darurat');
        $response->assertSee('SK'); // Inisial Senja Kopi
    }

    public function test_partnership_detail_renders_client_logo_in_crisp_badge_container(): void
    {
        $portfolio = Portfolio::create([
            'client_name' => 'Bistro Modern Plaza',
            'slug' => 'bistro-modern-plaza',
            'client_type' => 'Casual Dining',
            'partnership_type' => 'kerjasama-proyek',
            'image' => 'https://example.com/bistro-hero.webp',
            'logo' => 'https://example.com/bistro-logo.png',
            'description' => 'Kerjasama proyek peremajaan pipa grease trap.',
            'location' => 'Tangerang',
            'is_active' => true,
        ]);

        $response = $this->get(route('partnership.show', $portfolio->slug));

        $response->assertStatus(200);
        $response->assertSee('https://example.com/bistro-hero.webp', false);
        $response->assertSee('https://example.com/bistro-logo.png', false);
        $response->assertSee('bg-white/95 rounded-lg', false);
    }

    public function test_partnership_detail_renders_mobile_navbar_dock_and_related_partnerships_carousel(): void
    {
        $main = Portfolio::create([
            'client_name' => 'Mitra Utama',
            'slug' => 'mitra-utama',
            'client_type' => 'Restoran',
            'partnership_type' => 'kontrak-maintenance',
            'location' => 'Jakarta Selatan',
            'is_active' => true,
        ]);

        $related = Portfolio::create([
            'client_name' => 'Mitra Serupa',
            'slug' => 'mitra-serupa',
            'client_type' => 'Kafe',
            'partnership_type' => 'kontrak-maintenance',
            'location' => 'Jakarta Barat',
            'is_active' => true,
        ]);

        $response = $this->get(route('partnership.show', $main->slug))->assertOk();

        // Must NOT hide mobile nav dock
        $response->assertDontSee('.mobile-nav-dock { display: none !important; }', false);

        // Must render related partnerships in mobile swipeable container
        $response->assertSee('snap-x snap-mandatory', false);
        $response->assertSee('Mitra Serupa');
    }
}
