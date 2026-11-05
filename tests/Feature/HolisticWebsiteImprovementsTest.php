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

    /**
     * Test admin dashboard shows contact leads metric card.
     */
    public function test_admin_dashboard_displays_contact_leads_card(): void
    {
        $admin = User::factory()->create();
        \App\Models\ContactMessage::create([
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'city' => 'Jakarta Timur',
            'district' => 'Duren Sawit',
            'service_type' => 'Wastafel Mampet',
            'message' => 'Wastafel dapur meluap.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Pesan Masuk');
        $response->assertSee('Permohonan Baru');
        $response->assertSee('Budi Santoso');
    }

    /**
     * Test partnership show page loads related partnerships with services.
     */
    public function test_partnership_show_eager_loads_related_services(): void
    {
        $service = \App\Models\Service::create([
            'name' => 'Pelancaran Grease Trap Restoran',
            'slug' => 'pelancaran-grease-trap-restoran',
            'price_starting_from' => 450000,
            'is_active' => true,
        ]);

        $p1 = \App\Models\Portfolio::create([
            'client_name' => 'Restoran Padang Sederhana',
            'slug' => 'restoran-padang-sederhana',
            'client_type' => 'Restoran F&B',
            'is_active' => true,
        ]);
        $p1->services()->attach($service->id);

        $p2 = \App\Models\Portfolio::create([
            'client_name' => 'Kafe Kopi Kenangan',
            'slug' => 'kafe-kopi-kenangan',
            'client_type' => 'Restoran F&B',
            'is_active' => true,
        ]);
        $p2->services()->attach($service->id);

        $response = $this->get(route('partnership.show', $p1->slug));

        $response->assertStatus(200);
        $response->assertSee('Restoran Padang Sederhana');
        $response->assertSee('Kafe Kopi Kenangan');
    }

    /**
     * Test custom 403 Forbidden view renders cleanly with emergency hotline.
     */
    public function test_403_forbidden_page_renders_with_security_shield_and_hotline(): void
    {
        $view = $this->view('errors.403');

        $view->assertSee('403');
        $view->assertSee('Akses Halaman Dibatasi oleh Sistem');
        $view->assertSee('Kembali ke Beranda');
        $view->assertSee('PT JAWA JAYA ROOTER');
        $view->assertSee('0856-0900-9009');
    }

    /**
     * Test site.webmanifest is valid JSON and referenced in layout.
     */
    public function test_site_webmanifest_exists_and_referenced(): void
    {
        $manifestPath = public_path('site.webmanifest');
        $this->assertFileExists($manifestPath);

        $json = json_decode((string) file_get_contents($manifestPath), true);
        $this->assertIsArray($json);
        $this->assertEquals('Drainusantara - Jasa Saluran Pipa Mampet', $json['name']);
        $this->assertEquals('standalone', $json['display']);

        $response = $this->get('/');
        $response->assertSee('rel="manifest"', false);
    }

    /**
     * Test homepage has WebSite SearchAction schema in JSON-LD.
     */
    public function test_homepage_has_website_searchaction_json_ld(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SearchAction', false);
        $response->assertSee('query-input', false);
        $response->assertSee('pengetahuan?q={search_term_string}', false);
    }

    /**
     * Test article search query filters results server-side.
     */
    public function test_article_search_filters_results_by_keyword(): void
    {
        \App\Models\Article::create([
            'title' => 'Bahaya Soda Api pada Pipa Sifon PVC',
            'slug' => 'bahaya-soda-api-pada-pipa-sifon-pvc',
            'content' => 'Reaksi termal soda api dapat melelehkan sambungan pipa PVC leher angsa.',
            'is_published' => true,
        ]);

        \App\Models\Article::create([
            'title' => 'Cara Membersihkan Talang Atap dari Lumut',
            'slug' => 'cara-membersihkan-talang-atap-dari-lumut',
            'content' => 'Endapan lumut pada pipa vertikal dibersihkan dengan kabel spiral panjang.',
            'is_published' => true,
        ]);

        $response = $this->get('/pengetahuan?q=Soda+Api');

        $response->assertStatus(200);
        $response->assertSee('Bahaya Soda Api pada Pipa Sifon PVC');
        $response->assertDontSee('Cara Membersihkan Talang Atap dari Lumut');
    }

    /**
     * Test holding page breadcrumb JSON-LD explicitly uses Induk PT Jawa Jaya Rooter.
     */
    public function test_holding_page_breadcrumb_uses_induk_pt_jawa_jaya_rooter(): void
    {
        $response = $this->get(route('about.holding'));

        $response->assertStatus(200);
        $response->assertSee('Induk PT Jawa Jaya Rooter');
    }
}
