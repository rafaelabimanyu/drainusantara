<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PortfolioVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public static function activePortfolioPages(): array
    {
        return [
            'homepage image' => ['/', 'portofolio-b2b', '/images/portfolio/test-client.webp'],
            'homepage no image' => ['/', 'portofolio-b2b', null],
            'about image' => ['/tentang-kami/portofolio', 'portofolio-page', '/images/portfolio/test-client.webp'],
            'about no image' => ['/tentang-kami/portofolio', 'portofolio-page', null],
        ];
    }

    #[DataProvider('activePortfolioPages')]
    public function test_active_clients_render_without_unrelated_brand_images(string $url, string $section, ?string $image): void
    {
        Portfolio::create(['client_name' => 'Active Test Client', 'image' => $image, 'is_active' => true]);
        Portfolio::create(['client_name' => 'Disabled Test Client', 'is_active' => false]);

        $response = $this->get($url)->assertOk();

        $response->assertSee('id="'.$section.'"', false);
        $response->assertSee('Active Test Client');
        $response->assertDontSee('Disabled Test Client');
        $response->assertDontSee('gacoan-mitra-kepercayaan');
        if ($image !== null) {
            $response->assertSee($image, false);
        }
    }

    public static function emptyPortfolioPages(): array
    {
        return [
            'homepage empty' => ['/', 'portofolio-b2b', false],
            'homepage all disabled' => ['/', 'portofolio-b2b', true],
            'about empty' => ['/tentang-kami/portofolio', 'portofolio-page', false],
            'about all disabled' => ['/tentang-kami/portofolio', 'portofolio-page', true],
        ];
    }

    #[DataProvider('emptyPortfolioPages')]
    public function test_client_section_is_absent_without_active_portfolios(string $url, string $section, bool $hasDisabled): void
    {
        if ($hasDisabled) {
            Portfolio::create(['client_name' => 'Disabled Test Client', 'is_active' => false]);
        }

        $response = $this->get($url)->assertOk();

        $response->assertDontSee('id="'.$section.'"', false);
        $response->assertDontSee('Disabled Test Client');
        $response->assertDontSee('/images/portfolio/');
        foreach (['Mie Gacoan', 'KFC Indonesia', "McDonald's Indonesia", 'Richeese Factory', 'Sushi Tei', 'Super Indo Supermarket', 'SPBU Pertamina Sunter', 'Stasiun KAI Lempuyangan', 'Haka Dimsum'] as $brand) {
            $response->assertDontSee($brand);
        }
    }
}
