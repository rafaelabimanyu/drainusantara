<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class BuildingCategoryVisualIconTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Pastikan ada service minimal agar page render sempurna
        if (Service::count() === 0) {
            Service::create([
                'name' => 'Wastafel Cuci Piring',
                'slug' => 'wastafel-cuci-piring',
                'price_starting_from' => 400000,
                'is_active' => true,
            ]);
        }
    }

    public function test_building_category_icon_component_renders_correct_svg_per_type(): void
    {
        // 1. Rumahan / Residential
        $htmlRumah = Blade::render('<x-area.building-category-icon category="rumahan" />');
        $this->assertStringContainsString('d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"', $htmlRumah);
        $this->assertStringContainsString('aria-hidden="true"', $htmlRumah);

        // 2. Restoran & FnB
        $htmlFnb = Blade::render('<x-area.building-category-icon category="restoran" />');
        $this->assertStringContainsString('d="M18 2v6a3 3 0 0 1-3 3 3 3 0 0 1-3-3V2M15 11v11M5 2v10a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2V2M7 14v8"', $htmlFnb);

        // 3. Ruko & Komersial
        $htmlRuko = Blade::render('<x-area.building-category-icon category="ruko" />');
        $this->assertStringContainsString('d="M4 21V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v17M4 21h16M9 8h2m-2 4h2m-2 4h2m4-8h2m-2 4h2m-2 4h2M9 21v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"', $htmlRuko);

        // 4. Gedung & Perkantoran
        $htmlGedung = Blade::render('<x-area.building-category-icon category="gedung" />');
        $this->assertStringContainsString('d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"', $htmlGedung);

        // 5. Pabrik & Pergudangan
        $htmlPabrik = Blade::render('<x-area.building-category-icon category="pabrik" />');
        $this->assertStringContainsString('d="M2 20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-7 5V8l-7 5V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"', $htmlPabrik);
    }

    public function test_city_page_renders_building_category_icons_and_visual_cards(): void
    {
        CoverageArea::firstOrCreate(
            ['city' => 'Jakarta Selatan', 'district' => 'Tebet'],
            [
                'slug' => 'jakarta-selatan-tebet',
                'is_active' => true,
            ]
        );

        $response = $this->get('/area/jakarta-selatan');

        $response->assertStatus(200);
        $response->assertSee('id="sektor-layanan-kota"', false);
        $response->assertSee('Solusi Pipa untuk Beragam Kategori Bangunan');

        // Memastikan kelima kategori ter-render
        $response->assertSee('Rumahan / Residensial');
        $response->assertSee('Restoran &amp; FnB / Kafe', false);
        $response->assertSee('Ruko &amp; Komersial', false);
        $response->assertSee('Gedung &amp; Perkantoran', false);
        $response->assertSee('Pabrik &amp; Pergudangan', false);

        // Memastikan ikon SVG vektor ada di respons HTML
        $response->assertSee('d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"', false);
        $response->assertSee('d="M18 2v6a3 3 0 0 1-3 3 3 3 0 0 1-3-3V2M15 11v11M5 2v10a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2V2M7 14v8"', false);
        $response->assertSee('d="M4 21V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v17M4 21h16M9 8h2m-2 4h2m-2 4h2m4-8h2m-2 4h2m-2 4h2M9 21v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"', false);
    }

    public function test_district_page_renders_building_category_icons_and_district_tags(): void
    {
        $area = CoverageArea::firstOrCreate(
            ['city' => 'Jakarta Selatan', 'district' => 'Kebayoran Baru'],
            [
                'slug' => 'jakarta-selatan-kebayoran-baru',
                'is_active' => true,
            ]
        );

        $response = $this->get('/area/jakarta-selatan/kebayoran-baru');

        $response->assertStatus(200);
        $response->assertSee('id="sektor-layanan"', false);
        $response->assertSee('Solusi Pipa untuk Beragam Kategori Bangunan');

        // Memastikan kelima kategori ter-render dengan label distrik Kebayoran Baru
        $response->assertSee('Rumahan / Residensial');
        $response->assertSee('Kebayoran Baru');

        // Memastikan ikon pabrik & gedung ada di dalam respons
        $response->assertSee('d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"', false);
        $response->assertSee('d="M2 20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-7 5V8l-7 5V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"', false);
    }
}
