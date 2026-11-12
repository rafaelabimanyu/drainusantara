<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Service;
use App\Services\RegionalTaxonomy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaLocalReviewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (Service::count() === 0) {
            Service::create([
                'name' => 'Pelancaran Wastafel Mampet',
                'slug' => 'wastafel-cuci-piring',
                'short_description' => 'Pelancaran wastafel mampet',
                'price_starting_from' => 400000,
                'is_active' => true,
            ]);
        }

        if (Equipment::count() === 0) {
            Equipment::create([
                'name' => 'Mesin Spiral Ridgid K-6200',
                'slug' => 'mesin-spiral-ridgid-k6200',
                'badge' => 'MESIN UTAMA',
                'short_description' => 'Motor torsi tinggi',
                'is_active' => true,
            ]);
        }
    }

    public function test_regional_taxonomy_generates_localized_reviews(): void
    {
        $reviews = RegionalTaxonomy::getLocalReviews('Semarang', 'Banyumanik', 4);

        $this->assertCount(4, $reviews);
        $this->assertSame(5, $reviews[0]['rating']);
        $this->assertTrue($reviews[0]['verified']);
        $this->assertNotEmpty($reviews[0]['customer_name']);
        $this->assertNotEmpty($reviews[0]['turnaround']);
        $this->assertStringContainsString('Banyumanik', $reviews[0]['comment']);
    }

    public function test_city_page_renders_local_reviews_section(): void
    {
        $response = $this->get('/area/semarang');

        $response->assertStatus(200);
        $response->assertSee('ulasan-pelanggan-lokal', false);
        $response->assertSee('Rating &amp; Ulasan Kepuasan Pelanggan di Kota Semarang', false);
        $response->assertSee('4.9', false);
        $response->assertSee('92%', false);
        $response->assertSee('Garansi Tuntas Baru Bayar (No Cure No Pay)', false);
        $response->assertSee('Lihat Profil di Google Maps', false);
        $response->assertSee('Konsultasi Masalah Pipa', false);
        $response->assertSee('Terverifikasi', false);
    }

    public function test_district_page_renders_localized_reviews_for_district(): void
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
        $response->assertSee('ulasan-pelanggan-lokal', false);
        $response->assertSee('Tebet, Jakarta Selatan', false);
        $response->assertSee('4.9', false);
        $response->assertSee('Terverifikasi', false);
        $response->assertSee('Garansi Tuntas Baru Bayar', false);
    }
}
