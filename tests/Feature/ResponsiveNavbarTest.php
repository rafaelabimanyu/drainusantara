<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponsiveNavbarTest extends TestCase
{
    use RefreshDatabase;

    public function test_navbar_renders_single_focused_whatsapp_cta_without_cek_estimasi(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        // 1. CTA WhatsApp Hijau tersedia di navbar desktop & mobile
        $response->assertSee('data-track-location="navbar"', false);
        $response->assertSee('data-track-location="navbar_mobile"', false);
        $response->assertSee('Hubungi Kami', false);

        // 2. Tombol Cek Estimasi pada navbar telah dihapus agar navbar lega dan fokus
        $response->assertDontSee('data-track-location="navbar_quick_quote"', false);
        $response->assertDontSee('<span>Cek Estimasi</span>', false);

        // 3. Tombol Hamburger Menu pada mobile header tersedia untuk membuka drawer
        $response->assertSee('aria-label="Buka Menu Navigasi"', false);
        $response->assertSee('@click="sidebarOpen = true"', false);
    }

    public function test_quick_quote_modal_remains_available_globally(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        // Quick quote modal tetap ada di DOM untuk dipanggil kapan saja
        $response->assertSee('id="quick-quote-dialog"', false);
        $response->assertSee('@open-quick-quote.window="quickQuoteOpen = true"', false);
    }
}
