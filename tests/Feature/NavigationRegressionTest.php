<?php

namespace Tests\Feature;

use App\Services\RegionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_desktop_area_menu_links_use_canonical_region_slugs(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        preg_match('/<nav[^>]*aria-label="Navigasi Utama".*?<\/nav>/s', $html, $nav);
        $this->assertNotEmpty($nav);
        preg_match_all('~href="[^"]*/area/([^"/]+)"~', $nav[0], $links);
        $this->assertNotEmpty($links[1]);
        foreach ($links[1] as $slug) {
            $this->assertSame($slug, RegionService::findCity($slug)['slug'] ?? null, "Invalid city link: $slug");
        }
        $this->assertContains('bogor', $links[1]);
        $this->get('/area/bogor')->assertOk();
    }

    public function test_tablet_uses_mobile_navigation_until_desktop_fits(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        $this->assertMatchesRegularExpression('/<nav class="[^"]*hidden lg:flex[^"]*" aria-label="Navigasi Utama"/', $html);
        $this->assertMatchesRegularExpression('/<nav class="[^"]*lg:hidden[^"]*"[^>]*aria-label="Navigasi Mobile Floating Dock"/', $html);
        $this->assertMatchesRegularExpression('/class="fixed inset-0 z-60 lg:hidden"/', $html);
        $this->assertMatchesRegularExpression('/class="fixed inset-0 z-\[60\] lg:hidden"/', $html);
        $this->assertMatchesRegularExpression('/<main[^>]*class="[^"]*pb-24 lg:pb-0/', $html);
    }
}
