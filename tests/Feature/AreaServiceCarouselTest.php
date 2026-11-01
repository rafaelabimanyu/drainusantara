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

    public function test_province_page_renders_single_row_service_and_equipment_carousel(): void
    {
        $response = $this->get('/area/provinsi/dki-jakarta');

        $response->assertStatus(200);
        $response->assertSee('id="layanan"', false);
        $response->assertSee('serviceCarousel', false);
        $response->assertSee('service-card', false);
        $response->assertSee('Pesan via WhatsApp');

        // Dokumentasi real & wilayah-layanan
        $response->assertSee('id="dokumentasi"', false);
        $response->assertSee('id="wilayah-layanan"', false);
    }

    public function test_city_page_renders_single_row_service_and_equipment_carousel(): void
    {
        $response = $this->get('/area/jakarta-selatan');

        $response->assertStatus(200);
        $response->assertSee('id="layanan-kota"', false);
        $response->assertSee('cityServiceCarousel', false);
        $response->assertSee('service-card', false);
        $response->assertSee('Pesan via WhatsApp');

        // Sektor layanan, keunggulan & galeri
        $response->assertSee('id="sektor-layanan-kota"', false);
        $response->assertSee('id="keunggulan-kota"', false);
        $response->assertSee('id="galeri-kota"', false);
    }

    public function test_district_page_renders_single_row_service_and_equipment_carousel(): void
    {
        $response = $this->get('/area/jakarta-selatan/tebet');

        $response->assertStatus(200);
        $response->assertSee('id="layanan-area"', false);
        $response->assertSee('id="layanan-kecamatan"', false);
        $response->assertSee('districtServiceCarousel', false);
        $response->assertSee('service-card', false);
        $response->assertSee('Pesan Teknisi');

        // Sektor layanan, keunggulan, and cakupan
        $response->assertSee('id="sektor-layanan"', false);
        $response->assertSee('id="keunggulan-area"', false);
        $response->assertSee('id="posko-armada"', false);
    }
}
