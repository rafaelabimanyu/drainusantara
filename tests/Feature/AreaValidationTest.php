<?php

namespace Tests\Feature;

use App\Models\CoverageArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_city_returns_404_without_creating_records(): void
    {
        $this->get('/area/wilayah-tidak-ada')->assertNotFound();

        $this->assertDatabaseCount('coverage_areas', 0);
    }

    public function test_invalid_district_returns_404_without_creating_records(): void
    {
        $this->get('/area/jakarta-selatan/kecamatan-tidak-ada')->assertNotFound();

        $this->assertDatabaseCount('coverage_areas', 0);
    }

    public function test_valid_unseeded_district_does_not_write_to_database(): void
    {
        $this->get('/area/semarang/banyumanik')
            ->assertOk()
            ->assertSee('Banyumanik');

        $this->assertDatabaseCount('coverage_areas', 0);
    }

    public function test_inactive_district_is_not_published_by_fallback(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'is_active' => false,
        ]);

        $this->get('/area/jakarta-selatan/tebet')->assertNotFound();
        $this->assertDatabaseCount('coverage_areas', 1);
    }

    public function test_district_slug_cannot_load_content_from_another_city(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'banyumanik',
            'meta_title' => 'Konten kota yang salah',
            'is_active' => true,
        ]);

        $this->get('/area/semarang/banyumanik')
            ->assertOk()
            ->assertSee('Banyumanik')
            ->assertDontSee('Konten kota yang salah');

        $this->assertDatabaseCount('coverage_areas', 1);
    }
}
