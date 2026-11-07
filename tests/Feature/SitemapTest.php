<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_xml_renders_clean_xml_without_deprecated_xslt(): void
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
        $this->assertStringNotContainsString('xml-stylesheet', $content);
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
        $content = $response->getContent();

        $this->assertStringContainsString('User-agent: *', $content);
        $this->assertStringContainsString('Disallow: /admin/', $content);
        $this->assertStringContainsString('Disallow: /api/', $content);
        $this->assertStringContainsString('Disallow: /preview-*', $content);
        $this->assertStringContainsString('Allow: /llms.txt', $content);
        $this->assertStringContainsString('User-agent: Google-Extended', $content);
        $this->assertStringContainsString('User-agent: GPTBot', $content);
        $this->assertStringContainsString('User-agent: ChatGPT-User', $content);
        $this->assertStringContainsString('User-agent: Claude-Bot', $content);
        $this->assertStringContainsString('User-agent: PerplexityBot', $content);
        $this->assertStringContainsString('Sitemap: '.url('/sitemap.xml'), $content);
        $this->assertStringContainsString(url('/.well-known/ai-catalog.json'), $content);
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
        Cache::forget('sitemap_xml');
        $this->get('/sitemap.xml');

        $this->assertTrue(Cache::has('sitemap.xml'));
        $this->assertTrue(Cache::has('sitemap_xml'));
    }

    public function test_html_sitemap_renders_successfully_for_human_visitors(): void
    {
        Cache::forget('sitemap.html_data');

        $response = $this->get('/sitemap');

        $response->assertStatus(200);
        $response->assertSee('Peta Situs &amp; Panduan Direktori Drainusantara', false);
        $response->assertSee('Layanan Pelancar Saluran Pipa');
        $response->assertSee('Wilayah Layanan Siaga 24 Jam');
        $response->assertSee('Profil Perusahaan &amp; Tata Kelola', false);
        $response->assertSee('/sitemap.xml');
        $response->assertSee(route('area.detail', ['city' => 'bandung', 'district' => 'dago']));
        $response->assertSee(route('area.detail', ['city' => 'bandar-lampung', 'district' => 'sukarame']));

        $this->assertTrue(Cache::has('sitemap.html_data'));
    }

    public function test_sitemap_xml_contains_lastmod_and_priority_tags(): void
    {
        Article::create([
            'title' => 'Panduan Deteksi Pipa Mampet',
            'slug' => 'panduan-deteksi-pipa-mampet',
            'content' => 'Panduan lengkap deteksi pipa.',
            'is_published' => true,
        ]);

        Cache::forget('sitemap.xml');
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('<lastmod>', $content);
        $this->assertStringContainsString('<priority>1.0</priority>', $content);
        $this->assertStringContainsString('<priority>0.9</priority>', $content);
        $this->assertStringContainsString('<priority>0.8</priority>', $content);
        $this->assertStringContainsString('<priority>0.5</priority>', $content);
        $this->assertStringContainsString(url('/area/bandung/dago'), $content);
        $this->assertStringContainsString(url('/tentang-kami/holding'), $content);
    }

    public function test_indexnow_verification_key_file_exists(): void
    {
        $keyPath = public_path('drainusantara-indexnow-key.txt');
        $this->assertFileExists($keyPath);
        $this->assertSame('drainusantara-indexnow-key', trim(file_get_contents($keyPath)));
    }

    public function test_peta_situs_alias_redirects_301_to_sitemap(): void
    {
        $response = $this->get('/peta-situs');

        $response->assertStatus(301);
        $response->assertRedirect(route('sitemap.html'));
    }
}
