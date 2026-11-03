<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaMobileGapRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_area_city_page_has_no_bottom_padding_gap_before_footer(): void
    {
        $response = $this->get('/area/bogor');
        $response->assertOk();

        $content = $response->getContent();

        // Must not contain pb-24 or pb- on the page container
        $this->assertStringNotContainsString('area-city-page pb-', $content);
        $this->assertStringContainsString('<div class="area-city-page">', $content);

        // Closing CTA must not have a bottom border separating it from the footer
        $this->assertStringNotContainsString('id="kontak-kota" class="pt-12 pb-10 sm:pt-16 sm:pb-14 bg-slate-900 text-white relative overflow-hidden border-b', $content);
        $this->assertStringContainsString('id="kontak-kota"', $content);

        // Layout main element must not have pb-24
        $this->assertStringNotContainsString('<main id="main-content" tabindex="-1" class="flex-1 pb-24', $content);
    }

    public function test_area_district_page_has_no_bottom_padding_gap_before_footer(): void
    {
        $response = $this->get('/area/bogor/cibinong');
        $response->assertOk();

        $content = $response->getContent();

        $this->assertStringNotContainsString('area-detail-page pb-', $content);
        $this->assertStringContainsString('<div class="area-detail-page">', $content);

        $this->assertStringNotContainsString('id="kontak-kecamatan" class="pt-12 pb-10 sm:pt-16 sm:pb-14 bg-slate-900 text-white text-center relative overflow-hidden border-b', $content);
        $this->assertStringContainsString('id="kontak-kecamatan"', $content);
    }

    public function test_area_province_page_has_no_bottom_padding_gap_before_footer(): void
    {
        $response = $this->get('/area/provinsi/jawa-barat');
        $response->assertOk();

        $content = $response->getContent();

        $this->assertStringNotContainsString('area-directory-page pb-', $content);
        $this->assertStringContainsString('<div class="area-directory-page">', $content);

        $this->assertStringNotContainsString('id="kontak-provinsi" class="pt-12 pb-10 sm:pt-16 sm:pb-14 bg-slate-900 text-white relative overflow-hidden border-b', $content);
        $this->assertStringContainsString('id="kontak-provinsi"', $content);
    }
}
