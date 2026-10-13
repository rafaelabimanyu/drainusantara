<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicAccessibilityTest extends TestCase
{
    use RefreshDatabase;

    private function dom(string $html): \DOMXPath
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
        return new \DOMXPath($dom);
    }

    public function test_faq_buttons_expose_expansion_state_and_answer_targets(): void
    {
        foreach (['/' => 'faq', '/tentang-kami/faq' => 'faq-page'] as $url => $id) {
            $dom = $this->dom($this->get($url)->assertOk()->getContent());
            $buttons = $dom->query('//*[@id="'.$id.'"]//button[@aria-controls]');
            $this->assertGreaterThan(0, $buttons->length);
            foreach ($buttons as $button) {
                $this->assertTrue($button->hasAttribute('aria-expanded'));
                $this->assertTrue($button->hasAttribute(':aria-expanded'));
                $this->assertSame(1, $dom->query('//*[@id="'.$button->getAttribute('aria-controls').'"]')->length);
            }
        }
    }

    public function test_layout_contact_links_work_without_javascript(): void
    {
        config(['app.whatsapp_number' => '6281198765432']);
        $dom = $this->dom($this->get('/')->assertOk()->getContent());
        $links = $dom->query('//a[contains(@*[name()=":href"], "wa.me")]');
        $this->assertGreaterThanOrEqual(4, $links->length);
        foreach ($links as $link) {
            $url = $link->getAttribute('href');
            $this->assertStringStartsWith('https://wa.me/6281198765432?text=', $url);
            parse_str(parse_url($url, PHP_URL_QUERY), $query);
            $this->assertStringStartsWith('Halo Admin Drainusantara,', $query['text']);
        }
    }

    public function test_search_dialog_and_input_have_accessible_names(): void
    {
        $dom = $this->dom($this->get('/')->assertOk()->getContent());
        $dialog = $dom->query('//dialog[@aria-labelledby="area-search-title"]')->item(0);
        $this->assertNotNull($dialog, 'Search must use a named native modal dialog.');
        $this->assertSame(1, $dom->query('//*[@id="area-search-title"]')->length);
        $this->assertSame(1, $dom->query('//label[@for="area-search-input"]')->length);
        $this->assertSame(1, $dom->query('//input[@id="area-search-input"]')->length);
    }

    public function test_indonesian_content_declares_indonesian_even_with_english_app_locale(): void
    {
        app()->setLocale('en');
        $dom = $this->dom($this->get('/')->assertOk()->getContent());
        $this->assertSame('id', $dom->evaluate('string(/html/@lang)'));
    }
}
