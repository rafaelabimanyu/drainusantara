<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConversionAndTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_gtm_scripts_and_datalayer_rendered_when_container_id_configured(): void
    {
        config(['services.gtm.id' => 'GTM-TEST1234']);

        $response = $this->get('/');
        $response->assertOk();

        // GTM Head script
        $response->assertSee('https://www.googletagmanager.com/gtm.js?id=', false);
        $response->assertSee("})(window,document,'script','dataLayer','GTM-TEST1234');", false);
        // GTM Noscript Body iframe
        $response->assertSee('https://www.googletagmanager.com/ns.html?id=GTM-TEST1234', false);
        // dataLayer initialization
        $response->assertSee('window.dataLayer = window.dataLayer || [];', false);
        $response->assertSee('page_context_ready', false);
    }

    public function test_gtm_scripts_omitted_gracefully_when_container_id_empty(): void
    {
        config(['services.gtm.id' => null]);

        $response = $this->get('/');
        $response->assertOk();

        $response->assertDontSee('https://www.googletagmanager.com/gtm.js', false);
        $response->assertDontSee('https://www.googletagmanager.com/ns.html', false);
        // dataLayer must still be initialized for client-side tracking
        $response->assertSee('window.dataLayer = window.dataLayer || [];', false);
    }

    public function test_contextual_whatsapp_url_adapts_to_area_detail_page(): void
    {
        CoverageArea::create([
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Baru',
            'slug' => 'kebayoran-baru',
            'is_active' => true,
        ]);

        $response = $this->get(route('area.detail', [
            'city' => 'jakarta-selatan',
            'district' => 'kebayoran-baru',
        ]));
        $response->assertOk();

        // Contextual WhatsApp link in layout must mention the district and city
        $response->assertSee(rawurlencode('Kecamatan Kebayoran Baru'), false);
        $response->assertSee(rawurlencode('Jakarta Selatan'), false);
        $response->assertSee(rawurlencode('Halo Admin Drainusantara,'), false);
    }

    public function test_contextual_whatsapp_url_adapts_to_equipment_detail_page(): void
    {
        $equipment = Equipment::create([
            'name' => 'Mesin Rooter Spiral Baja K-50',
            'slug' => 'mesin-rooter-spiral-baja-k-50',
            'category' => 'Mesin Utama',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('equipment.show', $equipment->slug));
        $response->assertOk();

        $response->assertSee(rawurlencode('Mesin Rooter Spiral Baja K 50'), false);
        $response->assertSee(rawurlencode('Halo Admin Drainusantara,'), false);
    }

    public function test_contextual_whatsapp_url_adapts_to_warranty_and_b2b_pages(): void
    {
        // Warranty page
        $resWarranty = $this->get(route('about.warranty'));
        $resWarranty->assertOk();
        $resWarranty->assertSee(rawurlencode('garansi resmi pengerjaan saluran 30 hari'), false);

        // B2B Holding page
        $resHolding = $this->get(route('about.holding'));
        $resHolding->assertOk();
        $resHolding->assertSee(rawurlencode('B2B'), false);
    }

    public function test_layout_buttons_contain_track_location_attributes(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $response->assertSee('data-track-location="navbar"', false);
        $response->assertSee('data-track-location="navbar_mobile"', false);
        $response->assertSee('data-track-location="mobile_dock"', false);
        $response->assertSee('data-track-location="mobile_drawer"', false);
        $response->assertSee('data-track-location="footer"', false);
    }

    public function test_quick_quote_component_rendered_and_accessible_on_homepage(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $response->assertSee('Hitung Estimasi Biaya &amp; Jadwal Teknisi', false);
        $response->assertSee('Wastafel &amp; Sink', false);
        $response->assertSee('Kloset &amp; WC', false);
        $response->assertSee('Floor Drain', false);
        $response->assertSee('Talang Atap', false);
        $response->assertSee('Grease Trap', false);
        $response->assertSee('Pipa Utama', false);
        $response->assertSee('Konsultasi Biaya &amp; Jadwal via WhatsApp', false);
    }

    public function test_quick_quote_modal_accessible_globally(): void
    {
        $response = $this->get(route('about.profile'));
        $response->assertOk();

        $response->assertSee('id="quick-quote-dialog"', false);
        $response->assertSee('@open-quick-quote.window="quickQuoteOpen = true"', false);
    }

    public function test_dialog_overlays_are_hidden_by_default_to_prevent_click_blocking(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        // 1. Global defensive CSS rule ensures closed dialogs never intercept pointer events
        $response->assertSee('dialog:not([open]) { display: none !important; }', false);

        // 2. Quick quote modal starts with display: none and x-show
        $response->assertSee('id="quick-quote-dialog"', false);
        $response->assertSee('x-show="quickQuoteOpen"', false);
        $response->assertSee('display: none;', false);

        // 3. Search modal and mobile drawer start with display: none
        $response->assertSee('id="area-search-dialog"', false);
        $response->assertSee('id="mobile-drawer"', false);
    }
}
