<?php

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HolisticWebsiteImprovementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test custom 419 Page Expired view renders cleanly.
     */
    public function test_419_error_page_renders_with_session_and_refresh_action(): void
    {
        $view = $this->view('errors.419');

        $view->assertSee('419');
        $view->assertSee('Sesi Keamanan Halaman Telah Berakhir');
        $view->assertSee('Segarkan Halaman');
        $view->assertSee('PT JAWA JAYA ROOTER');
        $view->assertSee('0856-0900-9009');
    }

    /**
     * Test custom 503 Maintenance view renders with 24h emergency hotline.
     */
    public function test_503_maintenance_page_renders_with_emergency_hotline(): void
    {
        $view = $this->view('errors.503');

        $view->assertSee('503');
        $view->assertSee('Platform Sedang Pemeliharaan Sistem');
        $view->assertSee('PT Jawa Jaya Rooter');
        $view->assertSee('0856-0900-9009');
        $view->assertSee('No Cure No Pay');
        $view->assertSee('Garansi 30 Hari');
    }

    /**
     * Test preconnects for Google Tag Manager and WhatsApp exist on layout.
     */
    public function test_network_preconnects_present_on_pages(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>', false);
        $response->assertSee('<link rel="dns-prefetch" href="https://www.googletagmanager.com">', false);
        $response->assertSee('<link rel="preconnect" href="https://wa.me" crossorigin>', false);
        $response->assertSee('<link rel="dns-prefetch" href="https://wa.me">', false);
    }

    /**
     * Test footer displays "Kemitraan" and strictly avoids "Portofolio B2B".
     */
    public function test_footer_displays_kemitraan_without_portofolio_b2b(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Kemitraan');
        $response->assertDontSee('Kemitraan &amp; Portofolio B2B', false);
        $response->assertDontSee('Kemitraan & Portofolio B2B', false);
    }

    /**
     * Test about holding page displays "Induk PT Jawa Jaya Rooter" strictly without "Struktur Holding".
     */
    public function test_holding_subnav_displays_induk_pt_jawa_jaya_rooter(): void
    {
        $response = $this->get(route('about.holding'));

        $response->assertStatus(200);
        $response->assertSee('Induk PT Jawa Jaya Rooter');
        $response->assertDontSee('Struktur Holding');
    }

    /**
     * Test admin sidebar uses "Kemitraan" label.
     */
    public function test_admin_sidebar_displays_kemitraan_label(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.portfolios.index'));

        $response->assertStatus(200);
        $response->assertSee('Kemitraan');
        $response->assertDontSee('Portofolio Klien B2B');
    }

    /**
     * Test city page has WCAG accessibility attributes on FAQ and LCP preload.
     */
    public function test_city_page_has_accessible_faq_and_lcp_preload(): void
    {
        CoverageArea::create([
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Timur',
            'district' => 'Duren Sawit',
            'slug' => 'duren-sawit',
            'is_active' => true,
            'price_starting_from' => 400000,
        ]);

        $response = $this->get('/area/jakarta-timur');

        $response->assertStatus(200);
        $response->assertSee('aria-expanded', false);
        $response->assertSee('aria-controls="city-faq-ans-', false);
        $response->assertSee('rel="preload" as="image"', false);
    }

    /**
     * Test sitemap.xml returns 200 OK with application/xml header and valid XML structure.
     */
    public function test_sitemap_returns_valid_xml_with_proper_headers(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $response->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false);
        $response->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false);
        $response->assertSee('</urlset>', false);
    }
}
