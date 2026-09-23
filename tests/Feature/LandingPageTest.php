<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_successfully_with_seo_and_services(): void
    {
        // Arrange: create active services & reviews
        $service = Service::create([
            'name' => 'Wastafel & Cuci Piring',
            'slug' => 'wastafel-cuci-piring',
            'short_description' => 'Pelancaran wastafel tanpa bongkar keramik.',
            'price_starting_from' => 400000,
            'features' => ['Tanpa Bongkar', 'Garansi 30 Hari'],
            'is_active' => true,
            'order' => 1,
        ]);

        Review::create([
            'customer_name' => 'Pak Budi',
            'customer_role_or_location' => 'Jakarta Selatan',
            'rating' => 5,
            'comment' => 'Sangat cepat dan bersih!',
            'service_id' => $service->id,
            'is_active' => true,
        ]);

        // Act
        $response = $this->get('/');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Drainusantara');
        $response->assertSee('Wastafel &amp; Cuci Piring', false);
        $response->assertSee('Pak Budi');
        $response->assertSee('Tanpa Bongkar Keramik');
        $response->assertSee('Inspeksi CCTV 30M');
        $response->assertSee('Garansi 30 Hari');
        $response->assertSee('Frequently Asked Questions');
        $response->assertSee('Mengapa Jangan Menuang Soda Api ke Saluran Mampet?');
        $response->assertSee('Mulai Rp 400.000');
    }
}
