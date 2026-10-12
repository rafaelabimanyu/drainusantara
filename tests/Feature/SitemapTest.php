<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_xml_renders_with_xsl_stylesheet(): void
    {
        Article::create([
            'title' => 'Cara Mengatasi Saluran Pipa Mampet',
            'slug' => 'cara-mengatasi-saluran-pipa-mampet',
            'content' => 'Gunakan metode spiral baja atau inspeksi kamera.',
            'is_published' => true,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');

        $content = $response->getContent();
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>', $content);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);
        $this->assertStringContainsString(url('/'), $content);
        $this->assertStringContainsString(url('/area'), $content);
        $this->assertStringContainsString(url('/tentang-kami'), $content);
        $this->assertStringContainsString('cara-mengatasi-saluran-pipa-mampet', $content);
    }

    public function test_sitemap_respects_custom_app_url_and_https(): void
    {
        config(['app.url' => 'https://drainusantara.id']);
        Cache::forget('sitemap.xml');

        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<loc>https://drainusantara.id</loc>', $content);
        $this->assertStringContainsString('<loc>https://drainusantara.id/area</loc>', $content);
        $this->assertStringContainsString('<loc>https://drainusantara.id/tentang-kami/profil</loc>', $content);
        $this->assertStringNotContainsString('http://localhost', $content);
    }

    public function test_layanan_redirects_301_to_home_layanan_anchor(): void
    {
        $response = $this->get('/layanan');
        $response->assertStatus(301);
        $response->assertRedirect('/#layanan');
    }

    public function test_sitemap_xsl_file_exists_and_contains_proper_structure(): void
    {
        $xslPath = public_path('sitemap.xsl');
        $this->assertFileExists($xslPath);

        $xslContent = file_get_contents($xslPath);
        $this->assertStringContainsString('<xsl:stylesheet', $xslContent);
        $this->assertStringContainsString('DRAINUSANTARA', $xslContent);
        $this->assertStringContainsString('Peta Situs XML Resmi', $xslContent);
        $this->assertStringContainsString('sitemapTable', $xslContent);
    }

    public function test_robots_txt_renders_dynamically_with_sitemap_url(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=utf-8');
        $this->assertStringContainsString('User-agent: *', $response->getContent());
        $this->assertStringContainsString('Disallow: /admin/', $response->getContent());
        $this->assertStringContainsString('Sitemap: '.url('/sitemap.xml'), $response->getContent());
    }

    public function test_legacy_artikel_url_redirects_301_to_pengetahuan(): void
    {
        $response = $this->get('/artikel');

        $response->assertStatus(301);
        $response->assertRedirect(route('articles.index'));
    }

    public function test_sitemap_is_cached(): void
    {
        Cache::forget('sitemap.xml');
        $this->get('/sitemap.xml');

        $this->assertTrue(Cache::has('sitemap.xml'));
    }
}
