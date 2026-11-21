<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Tests\TestCase;

class CustomerServicePagesTest extends TestCase
{
    use RefreshDatabase;

    private function resetSeoTools(): void
    {
        foreach (['seotools.json-ld-multi', 'seotools.metatags', 'seotools.opengraph', 'seotools.twitter'] as $service) {
            app()->forgetInstance($service);
            Facade::clearResolvedInstance($service);
        }
    }

    private function dom(string $html): \DOMXPath
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);

        return new \DOMXPath($dom);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function extractJsonLdSchemas(string $html): array
    {
        preg_match_all('~<script type="application/ld\\+json"[^>]*>(.*?)</script>~s', $html, $scripts);
        if (empty($scripts[1])) {
            return [];
        }

        return array_merge(...array_map(static function (string $script): array {
            $schema = json_decode($script, true, 512, JSON_THROW_ON_ERROR);

            return $schema['@graph'] ?? (array_is_list($schema) ? $schema : [$schema]);
        }, $scripts[1]));
    }

    public function test_hub_and_all_seven_channel_pages_render_uniquely_for_indexing(): void
    {
        $channels = config('customer_service.channels', []);
        $this->assertCount(7, $channels);

        $routes = [route('customer-service.index')];
        foreach (array_keys($channels) as $slug) {
            $routes[] = route('customer-service.show', ['socialMedia' => $slug]);
        }

        $titles = [];
        $descriptions = [];
        $h1s = [];
        $faqQuestions = [];

        foreach ($routes as $url) {
            $this->resetSeoTools();
            $response = $this->get($url);
            $response->assertOk();
            $html = $response->getContent();
            $xpath = $this->dom($html);

            $canonical = $xpath->query('//link[@rel="canonical"]');
            $this->assertCount(1, $canonical, "Canonical tag missing on {$url}");
            $this->assertSame($url, $canonical->item(0)->getAttribute('href'), "Canonical mismatch on {$url}");

            $title = trim($xpath->evaluate('string(//title)'));
            $description = trim($xpath->evaluate('string(//meta[@name="description"]/@content)'));
            $h1 = trim(preg_replace('/\s+/', ' ', $xpath->evaluate('string(//h1)')));

            $this->assertNotEmpty($title, "Empty title on {$url}");
            $this->assertNotEmpty($description, "Empty meta description on {$url}");
            $this->assertNotEmpty($h1, "Empty H1 on {$url}");

            $titles[] = $title;
            $descriptions[] = $description;
            $h1s[] = $h1;

            // Antislop checks: zero em-dash, rounded-3xl, shadow-2xl, or double-escaped entities
            $this->assertStringNotContainsString("\u{2014}", $html, "Em-dash found on {$url}");
            $this->assertStringNotContainsString('&mdash;', $html, "HTML em-dash found on {$url}");
            $this->assertStringNotContainsString('&amp;amp;', $html, "Double-escaped HTML entity found on {$url}");
            $this->assertStringNotContainsString('rounded-3xl', $html, "rounded-3xl found on {$url}");
            $this->assertStringNotContainsString('shadow-2xl', $html, "shadow-2xl found on {$url}");

            // Mobile carousel checks: every CS page renders snap-x swipeable regions with accessible Prev/Next buttons
            $carouselRegions = $xpath->query('//*[@role="region" and contains(@class, "snap-x")]');
            $this->assertGreaterThan(0, $carouselRegions->length, "Expected at least 1 mobile snap-x carousel region on {$url}");

            $prevButtons = $xpath->query('//button[contains(@aria-label, "sebelumnya")]');
            $nextButtons = $xpath->query('//button[contains(@aria-label, "berikutnya")]');
            $this->assertGreaterThan(0, $prevButtons->length, "Missing mobile carousel previous button on {$url}");
            $this->assertSame($prevButtons->length, $nextButtons->length, "Mismatched carousel Prev/Next button counts on {$url}");

            // FAQ accessibility checks: every FAQ accordion button has aria-expanded, :aria-expanded, aria-controls matching panel id
            $faqButtons = $xpath->query('//button[starts-with(@aria-controls, "cs-faq-")]');
            $this->assertCount(4, $faqButtons, "Expected 4 FAQ accordion buttons on {$url}");
            foreach ($faqButtons as $button) {
                $this->assertTrue($button->hasAttribute('aria-expanded'), "Missing aria-expanded on {$url}");
                $this->assertTrue($button->hasAttribute(':aria-expanded'), "Missing :aria-expanded on {$url}");
                $panelId = $button->getAttribute('aria-controls');
                $this->assertSame(1, $xpath->query('//*[@id="'.$panelId.'"]')->length, "Missing FAQ panel #{$panelId} on {$url}");
            }

            // Collect JSON-LD schemas and verify ContactPage, Plumber, BreadcrumbList, FAQPage
            $schemas = $this->extractJsonLdSchemas($html);
            $types = array_column($schemas, '@type');
            $this->assertContains('ContactPage', $types, "Missing ContactPage schema on {$url}");
            $this->assertContains('BreadcrumbList', $types, "Missing BreadcrumbList schema on {$url}");
            $this->assertContains('FAQPage', $types, "Missing FAQPage schema on {$url}");
            $this->assertNotContains('PlumbingService', $types, "Deprecated PlumbingService schema on {$url}");

            $contactPage = collect($schemas)->firstWhere('@type', 'ContactPage');
            $this->assertSame('Plumber', $contactPage['mainEntity']['@type'] ?? null, "ContactPage mainEntity must be Plumber on {$url}");

            $faqSchema = collect($schemas)->firstWhere('@type', 'FAQPage');
            foreach ($faqSchema['mainEntity'] ?? [] as $q) {
                $faqQuestions[] = $q['name'] ?? '';
            }
        }

        $this->assertCount(8, array_unique($titles), 'Page titles must be unique across all 8 CS pages.');
        $this->assertCount(8, array_unique($descriptions), 'Meta descriptions must be unique across all 8 CS pages.');
        $this->assertCount(8, array_unique($h1s), 'H1 headings must be unique across all 8 CS pages.');
        $this->assertCount(32, array_unique($faqQuestions), 'All 32 FAQ questions across 8 pages must be distinct.');
    }

    public function test_each_channel_uses_expected_whatsapp_greeting_template_and_number_override(): void
    {
        config(['app.whatsapp_number' => '6285609009009']);
        config(['customer_service.channels.instagram.whatsapp_number' => '628111222333']);

        $expectedCodes = [
            'whatsapp' => 'wa',
            'instagram' => 'ig',
            'tiktok' => 'tiktok',
            'facebook' => 'fb',
            'youtube' => 'youtube',
            'linkedin' => 'linkedin',
            'x' => 'x',
        ];

        foreach ($expectedCodes as $slug => $code) {
            $this->resetSeoTools();
            $expectedNumber = $slug === 'instagram' ? '628111222333' : '6285609009009';
            $expectedGreeting = "Hallo admin {$code} drainusantara, saluran saya mampet di daerah";

            $response = $this->get(route('customer-service.show', ['socialMedia' => $slug]));
            $response->assertOk();
            $html = $response->getContent();
            $xpath = $this->dom($html);

            $waLinks = $xpath->query('//a[contains(@href, "https://wa.me/'.$expectedNumber.'?text=")]');
            $this->assertGreaterThan(0, $waLinks->length, "Missing static fallback WA link for {$slug} with {$expectedNumber}");

            $foundGreeting = false;
            foreach ($waLinks as $link) {
                parse_str((string) parse_url($link->getAttribute('href'), PHP_URL_QUERY), $query);
                if (isset($query['text']) && str_starts_with($query['text'], $expectedGreeting)) {
                    $foundGreeting = true;
                    break;
                }
            }

            $this->assertTrue($foundGreeting, "Expected WhatsApp fallback text starting with '{$expectedGreeting}' on {$slug}");

            $trackLocation = $slug === 'tiktok' ? 'cs_tiktok_triage' : "cs_{$slug}_hero";
            $primaryCta = $xpath->query('//a[@data-track-location="'.$trackLocation.'"]');
            $this->assertSame(1, $primaryCta->length, "Missing primary WA CTA on {$slug}");
            $ctaText = trim(preg_replace('/\s+/', ' ', $primaryCta->item(0)->textContent));
            $this->assertSame('Hubungi Admin Drainusantara', $ctaText, "Unexpected WA CTA label on {$slug}");
        }
    }

    public function test_invalid_social_media_channel_returns_404_and_twitter_aliases_to_x(): void
    {
        $this->get('/customer-service/twitter')
            ->assertStatus(301)
            ->assertRedirect(route('customer-service.show', ['socialMedia' => 'x']));
        $this->get('/customer-service/threads')->assertNotFound();
        $this->get('/customer-service/unknown-channel')->assertNotFound();
    }

    public function test_channel_pages_render_real_database_content_distinctly(): void
    {
        $service = Service::create([
            'name' => 'Sedot Lemak Sink Resto',
            'slug' => 'sedot-lemak-sink-resto',
            'short_description' => 'Pembersihan kerak lemak sink dapur komersial.',
            'price_starting_from' => 450000,
            'is_active' => true,
            'order' => 1,
        ]);

        Gallery::create([
            'title' => 'Pelancaran Sink Dapur Kemang Jakarta Selatan',
            'slug' => 'pelancaran-sink-dapur-kemang',
            'category' => 'rumahan',
            'location' => 'Kemang, Jakarta Selatan',
            'drain_type' => 'Pipa Wastafel Dapur',
            'method' => 'Mesin Rooter Spiral',
            'service_id' => $service->id,
            'is_active' => true,
            'order' => 1,
        ]);

        Review::create([
            'customer_name' => 'Ibu Kartika',
            'customer_role_or_location' => 'Cilandak, Jakarta Selatan',
            'rating' => 5,
            'comment' => 'Wastafel lancar kembali tanpa membongkar keramik dapur.',
            'service_id' => $service->id,
            'is_active' => true,
        ]);

        Equipment::create([
            'name' => 'Ridgid K-50 Sectional Machine',
            'slug' => 'ridgid-k50-sectional-machine',
            'category' => 'Mesin Spiral Rooter',
            'short_description' => 'Mesin pembersih pipa spiral fleksibel 16mm.',
            'specs' => ['Kecepatan putar 400 RPM', 'Kabel baja karbon 16mm'],
            'is_active' => true,
            'order' => 1,
        ]);

        Portfolio::create([
            'client_name' => 'PT Kuliner Nusantara Jaya',
            'slug' => 'pt-kuliner-nusantara-jaya',
            'client_type' => 'Restoran & Kafe',
            'location' => 'SCBD, Jakarta Selatan',
            'scope_of_work' => 'Maintenance grease trap dan jalur pembuangan utama dapur.',
            'is_active' => true,
            'order' => 1,
        ]);

        Article::create([
            'title' => 'Bahaya Soda Api pada Pipa PVC Dapur',
            'slug' => 'bahaya-soda-api-pada-pipa-pvc-dapur',
            'excerpt' => 'Reaksi panas soda api dapat melunakkan pipa PVC dan mengeras di belokan.',
            'content' => 'Gunakan spiral baja rooter untuk hasil aman tanpa bongkar keramik.',
            'category' => 'Edukasi',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->resetSeoTools();
        $this->get(route('customer-service.show', ['socialMedia' => 'whatsapp']))
            ->assertOk()
            ->assertSee('Sedot Lemak Sink Resto')
            ->assertSee('450.000');

        $this->resetSeoTools();
        $this->get(route('customer-service.show', ['socialMedia' => 'instagram']))
            ->assertOk()
            ->assertSee('Pelancaran Sink Dapur Kemang Jakarta Selatan')
            ->assertSee('Kemang, Jakarta Selatan');

        $this->resetSeoTools();
        $this->get(route('customer-service.show', ['socialMedia' => 'tiktok']))
            ->assertOk()
            ->assertSee('1. Pilih Gejala Masalah Saluran Anda')
            ->assertSee('Fakta Lapangan vs Soda Api &amp; Bongkar Lantai', false);

        $this->resetSeoTools();
        $this->get(route('customer-service.show', ['socialMedia' => 'facebook']))
            ->assertOk()
            ->assertSee('Ibu Kartika')
            ->assertSee('Cek Posko Armada di Sekitar Rumah Anda');

        $this->resetSeoTools();
        $this->get(route('customer-service.show', ['socialMedia' => 'youtube']))
            ->assertOk()
            ->assertSee('Ridgid K-50 Sectional Machine')
            ->assertSee('Kapan Memakai Spiral Rooter vs Inspeksi CCTV Pipa?');

        $this->resetSeoTools();
        $this->get(route('customer-service.show', ['socialMedia' => 'linkedin']))
            ->assertOk()
            ->assertSee('PT Kuliner Nusantara Jaya')
            ->assertSee('Form Permintaan Survei &amp; Penawaran B2B', false);

        $this->resetSeoTools();
        $this->get(route('customer-service.show', ['socialMedia' => 'x']))
            ->assertOk()
            ->assertSee('Bahaya Soda Api pada Pipa PVC Dapur')
            ->assertSee('Alur Respon Cepat dari Mention &amp; DM X ke Teknisi Lapangan', false);
    }

    public function test_linkedin_b2b_form_submits_and_redirects_back_to_linkedin_page(): void
    {
        $response = $this->post(route('contact.submit'), [
            'source_channel' => 'linkedin',
            'name' => 'Manajemen Gedung Graha Mandiri',
            'phone' => '081299887766',
            'city' => 'Jakarta Selatan',
            'district' => 'Setiabudi',
            'service_type' => 'Pipa Induk & Bak Kontrol Gedung',
            'property_type' => 'Gedung Perkantoran / Hotel',
            'message' => 'Membutuhkan survei jadwal after-hours dan penawaran SPK + e-Faktur.',
            'website_url' => '',
        ]);

        $response->assertRedirect(route('customer-service.show', ['socialMedia' => 'linkedin']));
        $response->assertSessionHas('success');
        $response->assertSessionHas('direct_wa_url');

        $directWaUrl = session('direct_wa_url');
        parse_str((string) parse_url($directWaUrl, PHP_URL_QUERY), $query);
        $this->assertStringStartsWith(
            'Hallo admin linkedin drainusantara, saluran saya mampet di daerah Setiabudi, Jakarta Selatan',
            $query['text'] ?? ''
        );

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Manajemen Gedung Graha Mandiri',
            'admin_notes' => '[Sumber: Customer Service LinkedIn B2B]',
            'status' => 'new',
        ]);
    }

    public function test_all_customer_service_urls_are_linked_in_sitemap_contact_and_footer(): void
    {
        Cache::forget('sitemap.xml');
        Cache::forget('sitemap_xml');
        Cache::forget('sitemap.html_data');

        $sitemapXml = $this->get('/sitemap.xml')->assertOk()->getContent();
        $htmlSitemap = $this->get('/sitemap')->assertOk()->getContent();
        $contactPage = $this->get(route('contact'))->assertOk()->getContent();
        $homePage = $this->get('/')->assertOk()->getContent();

        $expectedUrls = [route('customer-service.index')];
        foreach (array_keys(config('customer_service.channels', [])) as $slug) {
            $expectedUrls[] = route('customer-service.show', ['socialMedia' => $slug]);
        }

        foreach ($expectedUrls as $url) {
            $this->assertStringContainsString("<loc>{$url}</loc>", $sitemapXml);
            $this->assertStringContainsString($url, $htmlSitemap);
            $this->assertStringContainsString($url, $contactPage);
        }

        $this->assertStringContainsString(route('customer-service.index'), $homePage);
    }

    public function test_official_social_urls_and_compact_bounded_pickers_are_rendered(): void
    {
        $expectedSocialUrls = [
            '/customer-service/x' => 'https://x.com/Drainusantara',
            '/customer-service/instagram' => 'https://www.instagram.com/drainusantara',
            '/customer-service/youtube' => 'https://www.youtube.com/@Drainusantara',
        ];

        $homeHtml = $this->get('/')->assertOk()->getContent();
        foreach ($expectedSocialUrls as $path => $expectedUrl) {
            $this->assertStringContainsString($expectedUrl, $homeHtml, "Missing {$expectedUrl} in footer");
            $this->resetSeoTools();
            $pageHtml = $this->get($path)->assertOk()->getContent();
            $this->assertStringContainsString($expectedUrl, $pageHtml, "Missing {$expectedUrl} on {$path}");
        }

        foreach (['/customer-service/facebook', '/customer-service/tiktok', '/customer-service/linkedin', '/kontak'] as $path) {
            $this->resetSeoTools();
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertStringContainsString('max-h-44 overflow-y-auto', $html, "Missing bounded dropdown scroll container on {$path}");
            $this->assertStringContainsString('role="listbox"', $html, "Missing listbox picker on {$path}");
            $this->assertStringNotContainsString('<select', $html, "Unexpected full-height native <select> on {$path}");
        }
    }
}
