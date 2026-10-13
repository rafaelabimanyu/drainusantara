<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleOutputSafetyTest extends TestCase
{
    use RefreshDatabase;

    public function test_cms_text_cannot_escape_json_ld_and_round_trips_in_article_and_breadcrumb(): void
    {
        $payload = '</ScRiPt><script id="cms-probe">window.cmsProbe=1</script><!-- & " \' é';
        $article = Article::create([
            'title' => $payload, 'slug' => 'json-ld-probe', 'content' => 'Isi aman',
            'meta_description' => $payload, 'is_published' => true, 'published_at' => now(),
        ]);
        $html = $this->get(route('articles.show', $article->slug))->assertOk()->getContent();
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $this->assertCount(0, $xpath->query('//*[@id="cms-probe"]'));
        $schemas = [];
        foreach ($xpath->query('//script[@type="application/ld+json"]') as $script) {
            $schema = json_decode($script->textContent, true, 512, JSON_THROW_ON_ERROR);
            $schemas[$schema['@type']][] = $schema;
        }
        $this->assertCount(1, $schemas['Article']);
        $this->assertCount(1, $schemas['BreadcrumbList']);
        $this->assertSame($payload, $schemas['Article'][0]['headline']);
        $this->assertSame($payload, $schemas['Article'][0]['description']);
        $this->assertSame($payload, $schemas['BreadcrumbList'][0]['itemListElement'][2]['name']);
    }
}
