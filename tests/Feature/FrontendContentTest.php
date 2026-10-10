<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_page_renders_successfully(): void
    {
        Gallery::create([
            'title' => 'Pelancaran Pipa Restoran',
            'description' => 'Pipa wastafel lancar kembali tanpa bongkar keramik.',
            'before_image' => 'https://placehold.co/600x400?text=Before',
            'after_image' => 'https://placehold.co/600x400?text=After',
            'is_active' => true,
        ]);

        $response = $this->get('/galeri');

        $response->assertStatus(200);
        $response->assertSee('Galeri Hasil Pengerjaan', false);
        $response->assertSee('Pelancaran Pipa Restoran');
    }

    public function test_articles_index_page_renders_successfully(): void
    {
        Article::create([
            'title' => 'Bahaya Soda Api untuk Pipa',
            'slug' => 'bahaya-soda-api-untuk-pipa',
            'category' => 'Tips & Edukasi',
            'excerpt' => 'Soda api berbahaya bagi pipa PVC.',
            'content' => 'Soda api menghasilkan reaksi eksotermik yang merusak pipa.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get('/pengetahuan');

        $response->assertStatus(200);
        $response->assertSee('Panduan Perawatan & Tips');
        $response->assertSee('Bahaya Soda Api untuk Pipa');
    }

    public function test_knowledge_heading_decodes_ampersand_once(): void
    {
        $response = $this->get('/pengetahuan')->assertOk();
        $response->assertSeeText('Panduan Perawatan & Tips');
        $response->assertDontSee('Panduan Perawatan &amp;amp; Tips', false);

        $document = new \DOMDocument;
        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
        $heading = $document->getElementsByTagName('h1')->item(0);

        $this->assertNotNull($heading);
        $this->assertSame('Panduan Perawatan & Tips Saluran Pipa', trim(preg_replace('/\s+/', ' ', $heading->textContent)));
    }

    public function test_article_titles_escape_special_characters_without_rendering_markup(): void
    {
        $title = 'Pipa & "Saluran" <em>Rumah</em>';
        $article = Article::create([
            'title' => $title,
            'slug' => 'pipa-saluran-rumah',
            'category' => 'Tips & Edukasi',
            'excerpt' => 'Panduan perawatan saluran rumah.',
            'content' => 'Bersihkan saluran secara berkala.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        foreach (['/pengetahuan', "/artikel/{$article->slug}"] as $url) {
            $response = $this->get($url)->assertOk();
            $response->assertSeeText($title);
            $response->assertDontSee(e(e($title)), false);

            $document = new \DOMDocument;
            $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
            $headings = (new \DOMXPath($document))->query('//h1 | //h2');
            $titles = [];
            foreach ($headings as $heading) {
                $titles[] = trim(preg_replace('/\s+/', ' ', $heading->textContent));
            }
            $this->assertContains($title, $titles, $url);
        }
    }

    public function test_article_detail_page_renders_successfully(): void
    {
        $article = Article::create([
            'title' => 'Cara Merawat Saluran Air Mandi',
            'slug' => 'cara-merawat-saluran-air-mandi',
            'category' => 'Tips Rumah',
            'excerpt' => 'Gunakan saringan rambut pada floor drain.',
            'content' => 'Gumpalan rambut adalah penyebab nomor satu floor drain mampet.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get("/artikel/{$article->slug}");

        $response->assertStatus(200);
        $response->assertSee('Cara Merawat Saluran Air Mandi');
        $response->assertSee('Gumpalan rambut');
    }
}
