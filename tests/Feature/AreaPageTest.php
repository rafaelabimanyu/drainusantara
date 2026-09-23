<?php

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_area_page_renders_with_seeded_coverage_area(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'meta_title' => 'Jasa Saluran Mampet di Tebet, Jakarta Selatan - Drainusantara Bergaransi',
            'meta_description' => 'Jasa pelancaran pipa wastafel di Tebet.',
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Wastafel Mampet',
            'slug' => 'wastafel-mampet',
            'price_starting_from' => 400000,
            'is_active' => true,
        ]);

        $response = $this->get('/area/jakarta-selatan/tebet');

        $response->assertStatus(200);
        $response->assertSee('Jasa Pipa & Saluran Mampet', false);
        $response->assertSee('Tebet');
        $response->assertSee('Jakarta Selatan');
        $response->assertSee('Panggil Teknisi Tebet');
        $response->assertSee('Sering Terjadi di Tebet: Pipa Rusak Akibat Soda Api!');
        $response->assertSee('Mulai Rp 400.000');
    }

    public function test_area_page_creates_and_renders_dynamic_district_gracefully(): void
    {
        $response = $this->get('/area/semarang/banyumanik');

        $response->assertStatus(200);
        $response->assertSee('Banyumanik');
        $response->assertSee('Semarang');
        $response->assertSee('Panggil Teknisi Banyumanik');
        $response->assertSee('Mulai Rp 400.000');
    }

    public function test_area_page_resolves_aliases_and_regions(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'meta_title' => 'Jasa Saluran Mampet di Tebet, Jakarta Selatan - Drainusantara Bergaransi',
            'meta_description' => 'Jasa pelancaran pipa wastafel di Tebet.',
            'is_active' => true,
        ]);

        CoverageArea::create([
            'city' => 'Depok & Cinere',
            'district' => 'Cinere',
            'slug' => 'depok-cinere-cinere',
            'meta_title' => 'Jasa Saluran Mampet di Cinere, Depok & Cinere - Drainusantara Bergaransi',
            'is_active' => true,
        ]);

        // Test alias jaksel
        $responseJaksel = $this->get('/area/jaksel/tebet');
        $responseJaksel->assertStatus(200);
        $responseJaksel->assertSee('Jakarta Selatan');
        $responseJaksel->assertSee('Tebet');

        // Test Depok & Cinere
        $responseDepok = $this->get('/area/depok-cinere/cinere');
        $responseDepok->assertStatus(200);
        $responseDepok->assertSee('Depok &amp; Cinere', false);
        $responseDepok->assertSee('Cinere');

        // Test Bandar Lampung
        $responseLampung = $this->get('/area/bandar-lampung/kedaton');
        $responseLampung->assertStatus(200);
        $responseLampung->assertSee('Bandar Lampung');
        $responseLampung->assertSee('Kedaton');
    }
}
