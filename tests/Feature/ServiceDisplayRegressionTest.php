<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ServiceDisplayRegressionTest extends TestCase
{
    use RefreshDatabase;

    public static function routes(): array
    {
        return [
            ['/'], ['/area/provinsi/dki-jakarta'],
            ['/area/jakarta-selatan'], ['/area/jakarta-selatan/tebet'],
        ];
    }

    private function serviceDom(string $url): \DOMXPath
    {
        $document = new \DOMDocument;
        @$document->loadHTML('<?xml encoding="utf-8" ?>'.$this->get($url)->assertOk()->getContent());
        return new \DOMXPath($document);
    }

    #[DataProvider('routes')]
    public function test_all_six_categories_have_local_fallbacks_and_failed_image_recovery(string $url): void
    {
        foreach (['Wastafel', 'Kloset', 'Floor Drain', 'Talang', 'Grease Trap', 'CCTV'] as $index => $name) {
            Service::create([
                'name' => $name, 'slug' => 'service-'.$index, 'image' => null,
                'price_starting_from' => 0, 'is_active' => true,
            ]);
        }
        $dom = $this->serviceDom($url);
        $images = $dom->query('//h3/preceding-sibling::div/img');
        $this->assertCount(6, $images);
        foreach ($images as $image) {
            $this->assertSame('/assets/placeholders/service.svg', parse_url($image->getAttribute('src'), PHP_URL_PATH));
            $this->assertFileExists(public_path('assets/placeholders/service.svg'));
            $this->assertStringContainsString('this.onerror=null', $image->getAttribute('onerror'));
            $this->assertStringContainsString('/assets/placeholders/service.svg', $image->getAttribute('onerror'));
        }
    }

    public function test_drawer_has_native_modality_and_accordion_state(): void
    {
        $dom = $this->serviceDom('/');
        $this->assertSame(1, $dom->query('//dialog[@aria-labelledby="mobile-drawer-title"]')->length);
        $button = $dom->query('//button[@aria-controls="drawer-company-links"]')->item(0);
        $this->assertNotNull($button);
        $this->assertSame('false', $button->getAttribute('aria-expanded'));
        $this->assertSame('tentangDrawerOpen', $button->getAttribute(':aria-expanded'));
        $this->assertSame(1, $dom->query('//*[@id="'.$button->getAttribute('aria-controls').'"]')->length);
    }

    #[DataProvider('routes')]
    public function test_zero_price_is_unset_and_positive_price_is_exact(string $url): void
    {
        foreach ([0, 765432] as $price) {
            Service::create([
                'name' => 'Wastafel '.$price, 'slug' => 'wastafel-'.$price,
                'price_starting_from' => $price, 'is_active' => true,
            ]);
        }
        $dom = $this->serviceDom($url);
        foreach ([0 => 'Hubungi untuk harga', 765432 => 'Rp 765.432'] as $price => $expected) {
            $heading = $dom->query('//h3[normalize-space(.)="Wastafel '.$price.'"]')->item(0);
            $this->assertNotNull($heading);
            $card = $heading->parentNode->parentNode->textContent;
            $this->assertStringContainsString($expected, $card);
            $this->assertStringNotContainsString('Rp 400.000', $card);
            if ($price === 0) {
                $this->assertStringNotContainsString('Rp 0', $card);
            }
        }
    }
}
