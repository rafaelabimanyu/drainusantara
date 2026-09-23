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
        $response->assertSee('Panduan Perawatan & Tips', false);
        $response->assertSee('Bahaya Soda Api untuk Pipa');
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
