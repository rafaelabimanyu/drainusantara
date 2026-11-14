<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSubcategory;
use App\Models\CoverageArea;
use App\Services\RegionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoSiloAndSchemaIntegrityTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_article_route_redirects_301_to_silo_url(): void
    {
        $category = ArticleCategory::create([
            'name' => 'Tips Perawatan',
            'slug' => 'tips-perawatan',
        ]);
        $subcategory = ArticleSubcategory::create([
            'category_id' => $category->id,
            'name' => 'Wastafel Dapur',
            'slug' => 'wastafel-dapur',
        ]);
        $article = Article::create([
            'title' => 'Cara Mengatasi Saluran Wastafel Mampet',
            'slug' => 'cara-mengatasi-saluran-wastafel-mampet',
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'content' => 'Gunakan air panas dan pembersih enzim.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $expectedSiloUrl = url('/edukasi/tips-perawatan/wastafel-dapur/cara-mengatasi-saluran-wastafel-mampet');
        $this->assertSame($expectedSiloUrl, $article->silo_url);

        // Access legacy /artikel/{slug}
        $response = $this->get('/artikel/' . $article->slug);
        $response->assertStatus(301);
        $response->assertRedirect($expectedSiloUrl);

        // Access legacy /blog/{slug}
        $blogResponse = $this->get('/blog/' . $article->slug);
        $blogResponse->assertStatus(301);
    }

    public function test_silo_mismatched_slugs_redirect_301_to_canonical_silo_url(): void
    {
        $category = ArticleCategory::create(['name' => 'Edukasi Teknis', 'slug' => 'edukasi-teknis']);
        $subcategory = ArticleSubcategory::create(['category_id' => $category->id, 'name' => 'Kloset Duduk', 'slug' => 'kloset-duduk']);
        $article = Article::create([
            'title' => 'Panduan Perbaikan Kloset Mampet',
            'slug' => 'panduan-perbaikan-kloset-mampet',
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'content' => 'Gunakan plunger atau spiral baja.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Wrong category or subcategory in URL
        $wrongUrl = url('/edukasi/wrong-category/wrong-sub/panduan-perbaikan-kloset-mampet');
        $response = $this->get($wrongUrl);
        $response->assertStatus(301);
        $response->assertRedirect($article->silo_url);

        // Correct silo URL renders 200 OK
        $okResponse = $this->get($article->silo_url);
        $okResponse->assertStatus(200);
        $okResponse->assertSee('Panduan Perbaikan Kloset Mampet');
    }

    public function test_partial_edukasi_routes_redirect_301_to_pengetahuan(): void
    {
        $r1 = $this->get('/edukasi');
        $r1->assertStatus(301);
        $r1->assertRedirect(route('articles.index'));

        $r2 = $this->get('/edukasi/tips-perawatan');
        $r2->assertStatus(301);
        $r2->assertRedirect(route('articles.index', ['category' => 'tips-perawatan']));

        $r3 = $this->get('/edukasi/tips-perawatan/wastafel');
        $r3->assertStatus(301);
        $r3->assertRedirect(route('articles.index', ['category' => 'tips-perawatan', 'sub' => 'wastafel']));
    }

    public function test_article_detail_has_full_breadcrumb_schema_and_canonical(): void
    {
        $category = ArticleCategory::create(['name' => 'Kategori Utama', 'slug' => 'kategori-utama']);
        $subcategory = ArticleSubcategory::create(['category_id' => $category->id, 'name' => 'Sub Kategori', 'slug' => 'sub-kategori']);
        $article = Article::create([
            'title' => 'Judul Artikel Silo Schema Test',
            'slug' => 'judul-artikel-silo-schema-test',
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'content' => 'Konten pengujian schema breadcrumbs.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get($article->silo_url);
        $response->assertStatus(200);

        // Canonical verification
        $dom = new \DOMDocument;
        @$dom->loadHTML($response->getContent());
        $xpath = new \DOMXPath($dom);
        $canonical = $xpath->query('//link[@rel="canonical"]');
        $this->assertCount(1, $canonical);
        $this->assertSame($article->silo_url, $canonical->item(0)->getAttribute('href'));

        // Schema JSON-LD verification

        $schemas = [];
        foreach ($xpath->query('//script[@type="application/ld+json"]') as $script) {
            $data = json_decode($script->textContent, true, 512, JSON_THROW_ON_ERROR);
            if (isset($data['@type'])) {
                $schemas[$data['@type']] = $data;
            }
        }

        $this->assertArrayHasKey('BreadcrumbList', $schemas);
        $elements = $schemas['BreadcrumbList']['itemListElement'];
        $this->assertGreaterThanOrEqual(4, count($elements));

        // Check level 1 Home/Beranda
        $this->assertSame(1, $elements[0]['position']);
        $this->assertSame('Beranda', $elements[0]['name']);

        // Check level 2 Edukasi
        $this->assertSame(2, $elements[1]['position']);
        $this->assertSame('Edukasi', $elements[1]['name']);

        // Check level 3 Category
        $this->assertSame(3, $elements[2]['position']);
        $this->assertSame('Kategori Utama', $elements[2]['name']);

        // Check last element is the article title
        $last = end($elements);
        $this->assertSame('Judul Artikel Silo Schema Test', $last['name']);
        $this->assertSame($article->silo_url, $last['item']);
    }

    public function test_how_to_works_schema_has_valid_steps(): void
    {
        $response = $this->get(route('how-it-works'));
        $response->assertStatus(200);

        $html = $response->getContent();
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        $howToFound = false;
        foreach ($xpath->query('//script[@type="application/ld+json"]') as $script) {
            $data = json_decode($script->textContent, true, 512, JSON_THROW_ON_ERROR);
            if (($data['@type'] ?? '') === 'HowTo') {
                $howToFound = true;
                $this->assertNotEmpty($data['step']);
                $this->assertCount(5, $data['step']);
                foreach ($data['step'] as $step) {
                    $this->assertSame('HowToStep', $step['@type']);
                    $this->assertNotEmpty($step['name']);
                    $this->assertNotEmpty($step['text']);
                    $this->assertNotEmpty($step['url']);
                }
            }
        }
        $this->assertTrue($howToFound, 'HowTo schema was not found on how-it-works page.');
    }

    public function test_faq_schema_rendered_on_area_pages(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Baru',
            'slug' => 'kebayoran-baru',
            'is_active' => true,
        ]);

        // Test district area page
        $districtResponse = $this->get('/area/jakarta-selatan/kebayoran-baru');
        $districtResponse->assertStatus(200);

        $dom = new \DOMDocument;
        @$dom->loadHTML($districtResponse->getContent());
        $xpath = new \DOMXPath($dom);

        $faqFound = false;
        foreach ($xpath->query('//script[@type="application/ld+json"]') as $script) {
            $data = json_decode($script->textContent, true, 512, JSON_THROW_ON_ERROR);
            if (($data['@type'] ?? '') === 'FAQPage') {
                $faqFound = true;
                $this->assertNotEmpty($data['mainEntity']);
                foreach ($data['mainEntity'] as $qa) {
                    $this->assertSame('Question', $qa['@type']);
                    $this->assertNotEmpty($qa['name']);
                    $this->assertSame('Answer', $qa['acceptedAnswer']['@type']);
                    $this->assertNotEmpty($qa['acceptedAnswer']['text']);
                }
            }
        }
        $this->assertTrue($faqFound, 'FAQPage schema was not found on district area page.');

        // Test city area page
        $cityResponse = $this->get('/area/jakarta-selatan');
        $cityResponse->assertStatus(200);
        $this->assertStringContainsString('FAQPage', $cityResponse->getContent());

        // Test province area page
        $provResponse = $this->get('/area/provinsi/dki-jakarta');
        $provResponse->assertStatus(200);
        $this->assertStringContainsString('FAQPage', $provResponse->getContent());
    }

    public function test_robots_txt_format(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('User-agent: *', $content);
        $this->assertStringContainsString('Sitemap: ' . url('/sitemap.xml'), $content);
        // Ensure ai-catalog is not declared as a Sitemap directive
        $this->assertStringNotContainsString('Sitemap: ' . url('/.well-known/ai-catalog.json'), $content);
        // Ensure it is mentioned as reference comment
        $this->assertStringContainsString('# AI-Catalog: ' . url('/.well-known/ai-catalog.json'), $content);
    }
}
