<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response->assertHeader('Content-Type', 'application/xml');

        $content = $response->getContent();
        $this->assertStringContainsString('<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>', $content);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);
        $this->assertStringContainsString(url('/'), $content);
        $this->assertStringContainsString(url('/area'), $content);
        $this->assertStringContainsString(url('/tentang-kami'), $content);
        $this->assertStringContainsString('cara-mengatasi-saluran-pipa-mampet', $content);
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
}
