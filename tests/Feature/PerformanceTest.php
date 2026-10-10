<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_font_is_local_and_preloaded(): void
    {
        $response = $this->get('/')->assertOk();
        $response->assertDontSee('fonts.googleapis.com', false);
        $dom = new \DOMDocument;
        @$dom->loadHTML($response->getContent());
        $xpath = new \DOMXPath($dom);
        $fonts = $xpath->query('//link[@rel="preload" and @as="font"]');
        $this->assertSame(1, $fonts->length);
        $this->assertSame(asset('fonts/plus-jakarta-sans-latin.woff2'), $fonts->item(0)->getAttribute('href'));
        $this->assertFileExists(public_path('fonts/plus-jakarta-sans-latin.woff2'));
        $this->assertFileExists(public_path('fonts/OFL.txt'));
    }

    public function test_navigation_logos_offer_smaller_responsive_images(): void
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML($this->get('/')->assertOk()->getContent());
        $xpath = new \DOMXPath($dom);
        $logos = $xpath->query('//header//img | //*[@id="mobile-drawer-title"]//img');
        $this->assertSame(2, $logos->length);
        foreach ($logos as $image) {
            $this->assertSame('224px', $image->getAttribute('sizes'));
            foreach ([224, 448] as $width) {
                $name = "images/logo/TEKSBRAND-TAGLINE-{$width}.webp";
                $this->assertStringContainsString(asset($name)." {$width}w", $image->getAttribute('srcset'));
                $this->assertFileExists(public_path($name));
                $this->assertSame($width, getimagesize(public_path($name))[0]);
                $this->assertLessThan(filesize(public_path('images/logo/TEKSBRAND-TAGLINE.webp')), filesize(public_path($name)));
                $bitmap = imagecreatefromwebp(public_path($name));
                $this->assertSame(127, imagecolorsforindex($bitmap, imagecolorat($bitmap, 0, 0))['alpha']);
            }
        }
    }

    public function test_homepage_hero_is_not_preloaded_on_unrelated_pages(): void
    {
        foreach (['/' => 2, '/tentang-kami/faq' => 0, '/pengetahuan' => 0] as $path => $expected) {
            $dom = new \DOMDocument;
            @$dom->loadHTML($this->get($path)->assertOk()->getContent());
            $xpath = new \DOMXPath($dom);
            $this->assertSame($expected, $xpath->query('//link[@rel="preload" and @as="image" and contains(@href,"hero-technician")]')->length, $path);
        }
    }
}
