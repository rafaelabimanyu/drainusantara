<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandLogoTest extends TestCase
{
    use RefreshDatabase;

    public function test_brand_backgrounds_blend_with_layout(): void
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML($this->get('/')->assertOk()->getContent());
        $xpath = new \DOMXPath($dom);
        $footerClass = $xpath->evaluate('string(//footer//a[img]/@class)');
        $this->assertStringNotContainsString('bg-white', $footerClass);
        $this->assertStringContainsString('bg-slate-300', $xpath->evaluate('string(//header/@class)'));
        $this->assertStringContainsString('bg-slate-300', $xpath->evaluate('string(//*[@id="mobile-drawer-title"]/parent::div/@class)'));
    }

    public function test_public_layout_uses_supplied_brand_images(): void
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$this->get('/')->assertOk()->getContent());
        $xpath = new \DOMXPath($dom);

        foreach ([
            '//header//a[1]//img' => 'TEKSBRAND-TAGLINE.webp',
            '//*[@id="mobile-drawer-title"]//img' => 'TEKSBRAND-TAGLINE.webp',
            '//footer//img[1]' => 'LOGOFULL.webp',
        ] as $selector => $filename) {
            $images = $xpath->query($selector);
            $this->assertSame(1, $images->length, $selector);
            $image = $images->item(0);
            $this->assertSame(asset('images/logo/'.$filename), $image->getAttribute('src'));
            $this->assertStringContainsString('Drainusantara', $image->getAttribute('alt'));
            [$width, $height] = getimagesize(public_path('images/logo/'.$filename));
            $this->assertSame((string) $width, $image->getAttribute('width'));
            $this->assertSame((string) $height, $image->getAttribute('height'));
        }
    }
}
