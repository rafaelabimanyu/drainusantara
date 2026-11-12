<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaImageIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (Service::count() === 0) {
            Service::create([
                'name' => 'Wastafel Cuci Piring',
                'slug' => 'wastafel-cuci-piring',
                'short_description' => 'Pelancaran wastafel mampet',
                'price_starting_from' => 400000,
                'is_active' => true,
            ]);
        }

        if (Equipment::count() === 0) {
            Equipment::create([
                'name' => 'Mesin Spiral Rotary Ridgid K-6200',
                'slug' => 'mesin-spiral-rotary-ridgid-k6200',
                'badge' => 'PENGHANCUR LEMAK BEKU',
                'short_description' => 'Motor torsi tinggi',
                'is_active' => true,
            ]);
        }
    }

    public function test_area_directory_renders_with_resolved_images(): void
    {
        $response = $this->get('/area');

        $response->assertStatus(200);
        $response->assertSee('Direktori Wilayah Layanan');
        $response->assertSee('images/areas/', false);
        $response->assertSee('alt="Jasa Saluran Pipa Mampet', false);
    }

    public function test_province_page_renders_with_resolved_image_and_metadata(): void
    {
        $response = $this->get('/area/provinsi/dki-jakarta');

        $response->assertStatus(200);
        $response->assertSee('DKI%20JAKARTA', false);
        $response->assertSee('Jaringan Wilayah DKI Jakarta', false);
    }

    public function test_city_page_renders_with_dedicated_city_image(): void
    {
        $response = $this->get('/area/semarang');

        $response->assertStatus(200);
        $response->assertSee('SEMARANG', false);
        $response->assertSee('semarang.webp', false);
    }

    public function test_district_page_renders_with_dedicated_district_image(): void
    {
        $area = CoverageArea::create([
            'province_name' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'starting_price' => 400000,
            'is_active' => true,
        ]);

        $response = $this->get('/area/jakarta-selatan/tebet');

        $response->assertStatus(200);
        $response->assertSee('tebet.webp', false);
        $response->assertSee('DKI%20JAKARTA', false);
    }

    public function test_unmapped_region_gracefully_falls_back_to_fleet_image(): void
    {
        $response = $this->get('/area/kota-denpasar');

        $response->assertStatus(200);
        $response->assertSee('drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp', false);
    }

    public function test_admin_edit_displays_resolved_image_preview_and_source_badge(): void
    {
        $admin = User::factory()->create();

        $area = CoverageArea::create([
            'province_name' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get("/admin/coverage-areas/{$area->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Foto Aktif yang Ditampilkan di Website:');
        $response->assertSee('Sumber: Aset Dedicated Kecamatan');
        $response->assertSee('tebet.webp', false);
    }
}

