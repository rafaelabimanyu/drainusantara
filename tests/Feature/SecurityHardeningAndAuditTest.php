<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Portfolio;
use App\Services\CacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SecurityHardeningAndAuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_responses_contain_owasp_security_headers(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_preview_cards_page_renders_without_500_error_in_local_environment(): void
    {
        $response = $this->get('/preview-cards');
        $response->assertOk();
        $response->assertSee('Preview Blade Components');
        $response->assertDontSee('RouteNotFoundException');
    }

    public function test_dynamic_case_study_and_partnership_caches_are_purged_on_model_events(): void
    {
        // 1. Case study cache
        Cache::put('case_study_test-slug-1', 'old_data', 86400);
        $this->assertTrue(Cache::has('case_study_test-slug-1'));

        $gallery = Gallery::create([
            'title' => 'Test Pelancaran Saluran',
            'slug' => 'test-slug-1',
            'category' => 'Wastafel',
            'image' => 'images/dokumentasi/test.webp',
        ]);

        // Observer should have purged case_study_test-slug-1
        $this->assertFalse(Cache::has('case_study_test-slug-1'));

        // Put cache again
        Cache::put('case_study_test-slug-1', 'cached_data', 86400);

        // Delete gallery
        $gallery->delete();
        $this->assertFalse(Cache::has('case_study_test-slug-1'));

        // 2. Partnership cache
        Cache::put('partnership_mitra-test', 'old_partnership_data', 86400);
        $this->assertTrue(Cache::has('partnership_mitra-test'));

        $portfolio = Portfolio::create([
            'client_name' => 'Mitra Test Restoran',
            'slug' => 'mitra-test',
            'client_type' => 'Restoran',
            'image' => 'images/portfolio/test.webp',
        ]);

        $this->assertFalse(Cache::has('partnership_mitra-test'));
    }
}

