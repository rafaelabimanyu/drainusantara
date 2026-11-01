<?php

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaServiceCarouselTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (CoverageArea::where('slug', 'jakarta-selatan-tebet')->count() === 0) {
            CoverageArea::create([
                'city' => 'Jakarta Selatan',
                'district' => 'Tebet',
                'slug' => 'jakarta-selatan-tebet',
                'meta_title' => 'Jasa Saluran Mampet di Tebet, Jakarta Selatan',
                'hero_image' => 'images/areas/tebet-landmark.webp',
                'price_starting_from' => 350000,
                'is_active' => true,
            ]);
        }
    }

    public function test_province_page_renders_single_row_mobile_and_2x2_desktop_carousel(): void
    {
        $response = $this->get('/area/provinsi/dki-jakarta');

        $response->assertStatus(200);
        $response->assertSee('id="layanan"', false);
        $response->assertSee('provinceServiceCarouselMobile', false);
        $response->assertSee('provinceServiceCarousel', false);
        $response->assertSee('w-[82vw]', false);
        $response->assertSee('grid-cols-2', false);
        $response->assertSee('service-card', false);
        $response->assertSee('Pesan Penanganan');

        // Dokumentasi real & wilayah-layanan mobile carousels
        $response->assertSee('id="dokumentasi"', false);
        $response->assertSee('id="wilayah-layanan"', false);
        $response->assertSee('w-[86vw]', false);
    }

    public function test_city_page_renders_single_row_mobile_and_2x2_desktop_carousel(): void
    {
        $response = $this->get('/area/jakarta-selatan');

        $response->assertStatus(200);
        $response->assertSee('id="layanan-kota"', false);
        $response->assertSee('cityServiceCarouselMobile', false);
        $response->assertSee('cityServiceCarousel', false);
        $response->assertSee('w-[82vw]', false);
        $response->assertSee('grid-cols-2', false);
        $response->assertSee('service-card', false);
        $response->assertSee('Pesan via WhatsApp');

        // Sektor layanan & keunggulan mobile carousels
        $response->assertSee('id="sektor-layanan-kota"', false);
        $response->assertSee('id="keunggulan-kota"', false);
        $response->assertSee('id="gallery-blog-kota"', false);
        $response->assertSee('w-[78vw]', false);
    }

    public function test_district_page_renders_single_row_mobile_and_2x2_desktop_carousel(): void
    {
        $response = $this->get('/area/jakarta-selatan/tebet');

        $response->assertStatus(200);
        $response->assertSee('id="layanan-area"', false);
        $response->assertSee('serviceCarouselMobile', false);
        $response->assertSee('serviceCarousel', false);
        $response->assertSee('w-[82vw]', false);
        $response->assertSee('grid-cols-2', false);
        $response->assertSee('service-card', false);
        $response->assertSee('Pesan Teknisi');

        // Sektor layanan, keunggulan, and studi-kasus-edukasi mobile carousels
        $response->assertSee('id="sektor-layanan"', false);
        $response->assertSee('id="keunggulan-area"', false);
        $response->assertSee('id="studi-kasus-edukasi"', false);
        $response->assertSee('w-[78vw]', false);
    }
}
