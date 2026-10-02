<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_successfully_with_seo_and_services(): void
    {
        // Arrange: create active services & reviews
        $service = Service::create([
            'name' => 'Wastafel & Cuci Piring',
            'slug' => 'wastafel-cuci-piring',
            'short_description' => 'Pelancaran wastafel tanpa bongkar keramik.',
            'price_starting_from' => 400000,
            'features' => ['Tanpa Bongkar', 'Garansi 30 Hari'],
            'is_active' => true,
            'order' => 1,
        ]);

        Review::create([
            'customer_name' => 'Pak Budi',
            'customer_role_or_location' => 'Jakarta Selatan',
            'rating' => 5,
            'comment' => 'Sangat cepat dan bersih!',
            'service_id' => $service->id,
            'is_active' => true,
        ]);

        // Act
        $response = $this->get('/');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Drainusantara');
        $response->assertSee('Wastafel &amp; Cuci Piring', false);
        $response->assertSee('Ibu Ratna Dewi');
        $response->assertSee('Tanpa Bongkar Keramik');
        $response->assertSee('Inspeksi CCTV 30M');
        $response->assertSee('Garansi 30 Hari');
        $response->assertSee('Edukasi &amp; Tips Perawatan Saluran Pipa', false);
        $response->assertSee('Mulai Rp 400.000');
        $response->assertSee('Posko Siaga Armada &amp; Spesifikasi Tindakan Lapangan', false);
        $response->assertSee('Jaringan Posko Siaga');
        $response->assertSee('Kelengkapan Alat Armada');
        $response->assertSee('No Cure No Pay');
        $response->assertSee('Peta Lokasi Workshop Pusat Drainusantara');
    }

    public function test_articles_section_has_mobile_carousel_structure(): void
    {
        \App\Models\Article::create([
            'title' => 'Cara Merawat Pipa Dapur',
            'slug' => 'cara-merawat-pipa-dapur',
            'category' => 'Tips & Edukasi',
            'excerpt' => 'Gunakan saringan bak cuci piring.',
            'content' => 'Tips pencegahan pipa mampet.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="edukasi"', false);
        $response->assertSee('mobileCarousel(', false);
        $response->assertSee('x-ref="slider"', false);
        $response->assertSee('Geser artikel &bull; Auto-scroll aktif', false);
        $response->assertSee('Cara Merawat Pipa Dapur');
    }

    public function test_landing_page_includes_accessible_animation_classes_and_reduced_motion_styles(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('reveal-soft', false);
        $response->assertSee('card-lift', false);
        $response->assertSee('btn-press', false);
        $response->assertSee('@media (prefers-reduced-motion: reduce)', false);
        $response->assertSee('IntersectionObserver', false);
    }

    public function test_mobile_navigation_dock_and_drawers_have_correct_classes_and_anti_overlap_binding(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Floating dock anti-overlap transition binding
        $response->assertSee("translate-y-28 opacity-0 pointer-events-none", false);
        $response->assertSee("mobileSearchOpen || sidebarOpen", false);

        // Search modal structure & thumb-friendly close
        $response->assertSee('id="drainusantara-areas-data"', false);
        $response->assertSee('"name":"Ciracas"', false);
        $response->assertSee('Tutup Pencarian', false);

        // Thumb-friendly drawer controls
        $response->assertSee('Tutup Menu', false);
        $response->assertSee('Hubungi Teknisi Siaga 24 Jam', false);
        $response->assertSee('h-12', false);
    }

    public function test_documentation_and_equipment_sections_have_mobile_carousel_structure(): void
    {
        $service = \App\Models\Service::first() ?? \App\Models\Service::create([
            'name' => 'Pelancaran Pipa Wastafel',
            'slug' => 'wastafel-mampet',
            'description' => 'Layanan pelancaran wastafel mampet.',
            'is_active' => true,
        ]);

        \App\Models\Gallery::create([
            'title' => 'Pelancaran Saluran Gutter Kafe',
            'category' => 'b2b',
            'service_id' => $service->id,
            'image' => '/images/dokumentasi/pelancar-saluran-gutter-resto-jakarta.webp',
            'description' => 'Pembersihan pipa tanpa bongkar.',
            'is_active' => true,
            'order' => 1,
        ]);

        \App\Models\Equipment::create([
            'name' => 'Mesin Spiral Elektrik K-50',
            'category' => 'Mesin Utama',
            'badge' => 'Standar Armada',
            'short_description' => 'Pembersih pipa diameter 3/4 hingga 4 inch.',
            'image' => '/images/equipment/k50.webp',
            'specs' => ['Jangkauan 30 Meter', 'Motor 590 RPM'],
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        // Documentation mobile carousel assertions
        $response->assertSee('id="dokumentasi"', false);
        $response->assertSee('Geser foto dokumentasi &bull; Auto-scroll aktif', false);
        $response->assertSee('aria-label="Dokumentasi 1"', false);

        // Equipment mobile carousel assertions
        $response->assertSee('id="peralatan-armada"', false);
        $response->assertSee('Geser katalog peralatan &bull; Auto-scroll aktif', false);
        $response->assertSee('aria-label="Peralatan 1"', false);
    }
}


