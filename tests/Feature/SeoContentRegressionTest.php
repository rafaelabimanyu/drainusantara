<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Facade;
use Tests\TestCase;

class SeoContentRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_omits_unknown_article_date_instead_of_failing(): void
    {
        \Illuminate\Support\Facades\DB::table('articles')->insert([
            'title' => 'Legacy', 'slug' => 'legacy', 'content' => 'Pipa',
            'is_published' => true, 'created_at' => null, 'updated_at' => null,
        ]);
        $article = \App\Models\Article::where('slug', 'legacy')->first();
        $xml = simplexml_load_string($this->get('/sitemap.xml')->assertOk()->getContent());
        $entry = collect(iterator_to_array($xml->url, false))
            ->first(fn ($entry) => (string) $entry->loc === $article->silo_url);
        $this->assertNotNull($entry);
        $this->assertFalse(isset($entry->lastmod));
    }

    public function test_every_sitemap_url_is_a_successful_self_canonical_page(): void
    {
        $xml = simplexml_load_string($this->get('/sitemap.xml')->assertOk()->getContent());
        foreach ($xml->url as $entry) {
            foreach (['seotools.json-ld-multi', 'seotools.metatags', 'seotools.opengraph'] as $service) {
                app()->forgetInstance($service);
                Facade::clearResolvedInstance($service);
            }
            $url = (string) $entry->loc;
            $response = $this->get($url)->assertOk();
            $dom = new \DOMDocument;
            @$dom->loadHTML($response->getContent());
            $canonical = (new \DOMXPath($dom))->query('//link[@rel="canonical"]');
            $this->assertCount(1, $canonical, $url);
            $this->assertSame($url, $canonical->item(0)->getAttribute('href'));
        }
    }

    public function test_sitemap_dates_use_content_timestamps_and_omit_unknown_static_dates(): void
    {
        $this->travelTo(\Illuminate\Support\Carbon::parse('2026-01-10 09:30:00'));
        $area = \App\Models\CoverageArea::create([
            'city' => 'Semarang', 'district' => 'candisari', 'slug' => 'legacy-slug', 'is_active' => true,
        ]);
        $article = \App\Models\Article::create([
            'title' => 'Panduan', 'slug' => 'panduan', 'content' => 'Pipa', 'is_published' => true,
        ]);
        $draft = \App\Models\Article::create([
            'title' => 'Draft', 'slug' => 'draft', 'content' => 'Draft', 'is_published' => false,
        ]);
        $this->travelTo(\Illuminate\Support\Carbon::parse('2026-02-20 12:00:00'));
        $xml = simplexml_load_string($this->get('/sitemap.xml')->assertOk()->getContent());
        $entries = [];
        foreach ($xml->url as $entry) {
            $entries[(string) $entry->loc] = $entry;
        }
        $this->assertSame($area->updated_at->toAtomString(), (string) $entries[url('/area/semarang/candisari')]->lastmod);
        $this->assertSame($article->updated_at->toAtomString(), (string) $entries[$article->silo_url]->lastmod);
        $this->assertArrayNotHasKey($draft->silo_url, $entries);
        $this->assertSame($article->updated_at->toAtomString(), (string) $entries[url('/')]->lastmod);
        $this->assertSame($area->updated_at->toAtomString(), (string) $entries[url('/area')]->lastmod);
        $this->assertSame($area->updated_at->toAtomString(), (string) $entries[url('/area/semarang')]->lastmod);
        $this->assertSame($area->updated_at->toAtomString(), (string) $entries[url('/area/semarang/tembalang')]->lastmod);
        $first = $this->get('/sitemap.xml')->getContent();
        $this->travel(2)->days();
        \Illuminate\Support\Facades\Cache::forget('sitemap.xml');
        $this->assertSame($first, $this->get('/sitemap.xml')->getContent());
        $this->travelBack();
    }

    public function test_sitemap_excludes_inactive_areas_and_noncanonical_duplicates(): void
    {
        $area = \App\Models\CoverageArea::create([
            'city' => 'Tangerang Selatan', 'district' => 'Serpong',
            'slug' => 'custom-cms-slug', 'is_active' => true,
        ]);
        $this->get('/sitemap.xml')->assertOk();
        $area->update(['is_active' => false]);
        $response = $this->get('/sitemap.xml')->assertOk();
        $xml = simplexml_load_string($response->getContent());
        $urls = array_map(fn ($url) => (string) $url->loc, iterator_to_array($xml->url, false));
        $this->assertNotContains(route('area.detail', ['city' => 'tangerang-selatan', 'district' => 'serpong']), $urls);
        $this->assertNotContains(route('about'), $urls);
        $this->assertContains(route('about.profile'), $urls);
        $this->assertContains(route('area.detail', ['city' => 'tangerang-selatan', 'district' => 'bsd-city']), $urls);
        $this->assertSame($urls, array_values(array_unique($urls)));
        $this->get('/area/tangerang-selatan/serpong')->assertNotFound();
    }

    public function test_article_pagination_has_its_own_canonical_without_tracking_parameters(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Article::create([
                'title' => "Panduan $i", 'slug' => "panduan-$i", 'content' => 'Pipa',
                'is_published' => true, 'published_at' => now()->subDays($i),
            ]);
        }
        foreach ([2, 3, 1] as $page) {
            $response = $this->get("/pengetahuan?page=$page&utm_source=test")->assertOk();
            $dom = new \DOMDocument;
            @$dom->loadHTML($response->getContent());
            $xpath = new \DOMXPath($dom);
            $canonical = $xpath->query('//link[@rel="canonical"]');
            $expected = route('articles.index').($page > 1 ? "?page=$page" : '');
            $this->assertCount(1, $canonical);
            $this->assertSame($expected, $canonical->item(0)->getAttribute('href'));
            $this->assertSame($expected, $xpath->query('//meta[@property="og:url"]')->item(0)->getAttribute('content'));
        }
    }

    public function test_business_schema_uses_plumber_on_every_business_page(): void
    {
        foreach (['/', '/area', '/area/provinsi/banten', '/area/tangerang-selatan', '/area/tangerang-selatan/serpong', '/galeri'] as $path) {
            app()->forgetInstance('seotools.json-ld-multi');
            Facade::clearResolvedInstance('seotools.json-ld-multi');
            $response = $this->get($path)->assertOk();
            preg_match_all('~<script type="application/ld\\+json"[^>]*>(.*?)</script>~s', $response->getContent(), $scripts);
            $schemas = array_merge(...array_map(static function (string $script): array {
                $schema = json_decode($script, true, 512, JSON_THROW_ON_ERROR);

                return $schema['@graph'] ?? (array_is_list($schema) ? $schema : [$schema]);
            }, $scripts[1]));
            $types = array_column($schemas, '@type');
            $this->assertContains('Plumber', $types, $path);
            $this->assertNotContains('PlumbingService', $types, $path);
        }
        $this->assertStringNotContainsString('PlumbingService', file_get_contents(base_path('AGENTS.md')));
    }

    public function test_all_bali_cities_and_districts_resolve_to_bali_hospitality_not_jakarta(): void
    {
        $baliCities = array_keys(\App\Services\RegionService::all()['bali']['cities'] ?? []);
        $this->assertCount(9, $baliCities);

        foreach ($baliCities as $citySlug) {
            $this->assertSame('bali_hospitality', \App\Services\RegionalTaxonomy::resolveZone($citySlug), $citySlug);
        }

        $response = $this->get('/area/kabupaten-badung/canggu')->assertOk();
        $html = $response->getContent();
        $this->assertStringContainsString('Pulau Dewata', $html);
        $this->assertStringNotContainsString('Metropolitan Ibukota', $html);
        $this->assertStringNotContainsString('wilayah Jakarta', $html);
    }

    public function test_article_search_pages_are_noindex_without_bot_override_and_align_hreflang(): void
    {
        \App\Models\Article::create([
            'title' => 'Panduan Pipa Soda Api',
            'slug' => 'panduan-pipa-soda-api',
            'content' => 'Hindari soda api pada pipa PVC.',
            'is_published' => true,
        ]);

        $response = $this->get('/pengetahuan?q=Soda+Api')->assertOk();
        $dom = new \DOMDocument;
        @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$response->getContent());
        $xpath = new \DOMXPath($dom);

        $robots = $xpath->query('//meta[@name="robots"]');
        $canonical = $xpath->query('//link[@rel="canonical"]');
        $hreflangId = $xpath->query('//link[@rel="alternate" and @hreflang="id"]');
        $hreflangDefault = $xpath->query('//link[@rel="alternate" and @hreflang="x-default"]');

        $this->assertCount(1, $robots);
        $this->assertSame('noindex, follow', $robots->item(0)->getAttribute('content'));
        $this->assertSame(0, $xpath->query('//meta[@name="googlebot" or @name="bingbot" or @name="yandex"]')->length);
        $this->assertCount(1, $canonical);
        $this->assertSame(route('articles.index'), $canonical->item(0)->getAttribute('href'));
        $this->assertSame(route('articles.index'), $hreflangId->item(0)->getAttribute('href'));
        $this->assertSame(route('articles.index'), $hreflangDefault->item(0)->getAttribute('href'));
    }

    public function test_case_study_partnership_equipment_and_linkedin_cs_have_no_double_brand_title(): void
    {
        $gallery = \App\Models\Gallery::create([
            'title' => 'Pelancaran Pipa Resto Kemang',
            'slug' => 'pelancaran-pipa-resto-kemang',
            'location' => 'Kemang, Jakarta Selatan',
            'description' => 'Pelancaran pipa lemak resto tanpa bongkar.',
            'is_active' => true,
        ]);

        $portfolio = \App\Models\Portfolio::create([
            'client_name' => 'Resto Nusantara B2B',
            'slug' => 'resto-nusantara-b2b',
            'client_type' => 'Restoran & Kafe',
            'location' => 'Jakarta Selatan',
            'description' => 'Kontrak perawatan grease trap berkala.',
            'is_active' => true,
        ]);

        $equipment = \App\Models\Equipment::create([
            'name' => 'Mesin Rooter Ridgid K-50',
            'slug' => 'mesin-rooter-ridgid-k-50',
            'category' => 'Mesin Spiral Rooter',
            'short_description' => 'Mesin rooter spiral baja fleksibel.',
            'is_active' => true,
        ]);

        foreach ([
            route('case-study.show', $gallery->slug),
            route('partnership.show', $portfolio->slug),
            route('equipment.show', $equipment->slug),
            route('customer-service.show', ['socialMedia' => 'linkedin']),
        ] as $url) {
            app()->forgetInstance('seotools.json-ld-multi');
            Facade::clearResolvedInstance('seotools.json-ld-multi');
            $html = $this->get($url)->assertOk()->getContent();
            $dom = new \DOMDocument;
            @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
            $title = trim((new \DOMXPath($dom))->evaluate('string(//title)'));
            $this->assertLessThanOrEqual(1, substr_count($title, 'Drainusantara'), "Double brand suffix in title on {$url}: {$title}");
        }

        foreach ([route('case-study.show', $gallery->slug), route('partnership.show', $portfolio->slug)] as $url) {
            app()->forgetInstance('seotools.json-ld-multi');
            Facade::clearResolvedInstance('seotools.json-ld-multi');
            $html = $this->get($url)->assertOk()->getContent();
            preg_match_all('~<script type="application/ld\\+json"[^>]*>(.*?)</script>~s', $html, $scripts);
            $schemas = array_merge(...array_map(static function (string $script): array {
                $schema = json_decode($script, true, 512, JSON_THROW_ON_ERROR);

                return $schema['@graph'] ?? (array_is_list($schema) ? $schema : [$schema]);
            }, $scripts[1]));
            $types = array_column($schemas, '@type');
            $articleCount = count(array_filter($types, static fn ($t) => $t === 'Article'));
            $breadcrumbCount = count(array_filter($types, static fn ($t) => $t === 'BreadcrumbList'));

            $this->assertSame(1, $articleCount, $url);
            $this->assertSame(1, $breadcrumbCount, $url);
        }
    }

    public function test_equipment_detail_legal_and_area_schemas_have_no_plumbing_service_and_accurate_district_type(): void
    {
        $equipment = \App\Models\Equipment::create([
            'name' => 'Mesin Rooter Ridgid K-50',
            'slug' => 'mesin-rooter-ridgid-k-50',
            'category' => 'Mesin Spiral Rooter',
            'short_description' => 'Mesin rooter spiral baja fleksibel.',
            'is_active' => true,
        ]);

        foreach ([
            route('equipment.show', $equipment->slug) => 'Product',
            route('legal.privacy') => 'WebPage',
            route('legal.terms') => 'WebPage',
        ] as $url => $expectedType) {
            app()->forgetInstance('seotools.json-ld-multi');
            Facade::clearResolvedInstance('seotools.json-ld-multi');
            $html = $this->get($url)->assertOk()->getContent();
            preg_match_all('~<script type="application/ld\\+json"[^>]*>(.*?)</script>~s', $html, $scripts);
            $schemas = array_merge(...array_map(static function (string $script): array {
                $schema = json_decode($script, true, 512, JSON_THROW_ON_ERROR);

                return $schema['@graph'] ?? (array_is_list($schema) ? $schema : [$schema]);
            }, $scripts[1]));
            $types = array_column($schemas, '@type');

            $this->assertContains($expectedType, $types, $url);
            $this->assertNotContains('PlumbingService', $types, $url);
        }

        app()->forgetInstance('seotools.json-ld-multi');
        Facade::clearResolvedInstance('seotools.json-ld-multi');
        $bsdHtml = $this->get('/area/tangerang-selatan/bsd-city')->assertOk()->getContent();
        preg_match_all('~<script type="application/ld\\+json"[^>]*>(.*?)</script>~s', $bsdHtml, $bsdScripts);
        $bsdJsonLd = implode("\n", $bsdScripts[1]);
        $this->assertStringContainsString('Kawasan BSD City', $bsdJsonLd);
        $this->assertStringNotContainsString('Kecamatan BSD City', $bsdJsonLd);

        $robotsTxt = $this->get('/robots.txt')->assertOk()->getContent();
        $this->assertDoesNotMatchRegularExpression('/^Sitemap:.*\.json$/mi', $robotsTxt);
    }
}
