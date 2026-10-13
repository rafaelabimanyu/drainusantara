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
        $xml = simplexml_load_string($this->get('/sitemap.xml')->assertOk()->getContent());
        $entry = collect(iterator_to_array($xml->url, false))
            ->first(fn ($entry) => (string) $entry->loc === route('articles.show', 'legacy'));
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
        \App\Models\Article::create([
            'title' => 'Draft', 'slug' => 'draft', 'content' => 'Draft', 'is_published' => false,
        ]);
        $this->travelTo(\Illuminate\Support\Carbon::parse('2026-02-20 12:00:00'));
        $xml = simplexml_load_string($this->get('/sitemap.xml')->assertOk()->getContent());
        $entries = [];
        foreach ($xml->url as $entry) {
            $entries[(string) $entry->loc] = $entry;
        }
        $this->assertSame($area->updated_at->toAtomString(), (string) $entries[url('/area/semarang/candisari')]->lastmod);
        $this->assertSame($article->updated_at->toAtomString(), (string) $entries[route('articles.show', 'panduan')]->lastmod);
        $this->assertArrayNotHasKey(route('articles.show', 'draft'), $entries);
        foreach (['/', '/tentang-kami/profil', '/area', '/area/semarang', '/area/semarang/tembalang'] as $path) {
            $this->assertFalse(isset($entries[url($path)]->lastmod), $path);
        }
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
}
