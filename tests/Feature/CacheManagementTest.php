<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Services\CacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_caches_essential_collections(): void
    {
        CacheService::clearPublicCache();

        Service::create([
            'name' => 'Wastafel Mampet',
            'slug' => 'wastafel-mampet',
            'short_description' => 'Pelancaran wastafel mampet.',
            'description' => 'Layanan pelancaran wastafel dengan mesin spiral.',
            'price_starting_from' => 400000,
            'is_active' => true,
            'order' => 1,
        ]);

        $this->get('/');

        $this->assertTrue(Cache::has('landing.services'));
        $this->assertTrue(Cache::has('landing.reviews'));
        $this->assertTrue(Cache::has('landing.galleries'));
        $this->assertTrue(Cache::has('landing.articles'));
        $this->assertTrue(Cache::has('landing.portfolios'));
    }

    public function test_model_change_automatically_clears_public_caches(): void
    {
        Cache::put('landing.services', 'cached_data', 3600);
        Cache::put('nav.services', 'cached_data', 3600);
        Cache::put('sitemap.xml', 'cached_xml', 3600);

        $this->assertTrue(Cache::has('landing.services'));

        // Triggering a model save should invalidate caches
        Service::create([
            'name' => 'Pipa Kamar Mandi',
            'slug' => 'pipa-kamar-mandi',
            'short_description' => 'Pelancaran pipa kamar mandi.',
            'description' => 'Layanan pelancaran pipa dengan spiral baja.',
            'price_starting_from' => 450000,
            'is_active' => true,
            'order' => 2,
        ]);

        $this->assertFalse(Cache::has('landing.services'));
        $this->assertFalse(Cache::has('nav.services'));
        $this->assertFalse(Cache::has('sitemap.xml'));
    }

    public function test_area_pages_cache_services_and_reviews(): void
    {
        CacheService::clearPublicCache();

        $this->get('/area');
        $this->assertTrue(Cache::has('services.all_active'));

        $this->get('/area/provinsi/dki-jakarta');
        $this->assertTrue(Cache::has('reviews.top3'));
        $this->assertTrue(Cache::has('galleries.top3'));

        $this->get('/area/jakarta-selatan');
        $this->assertTrue(Cache::has('reviews.top4'));
    }

    public function test_about_subpages_cache_staff_and_equipment(): void
    {
        CacheService::clearPublicCache();

        $this->get('/tentang-kami/profil');
        $this->assertTrue(Cache::has('staff.all_active'));

        $this->get('/tentang-kami/peralatan');
        $this->assertTrue(Cache::has('equipments.all_active'));
    }
}
