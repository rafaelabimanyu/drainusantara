<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Article;
use App\Models\CoverageArea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaBlogSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_area_pages_sync_blog_articles_with_correct_thumbnails_and_views(): void
    {
        $author = User::factory()->create();

        $article = Article::create([
            'title' => 'Cara Mengatasi Saluran Pipa Mampet Tanpa Kimia Keras',
            'slug' => 'cara-mengatasi-saluran-pipa-mampet-tanpa-kimia-keras',
            'thumbnail' => 'uploads/articles/solusi-pipa-mampet.webp',
            'excerpt' => 'Panduan lengkap melancarkan pipa mampet menggunakan alat spiral mekanik.',
            'content' => 'Gunakan metode spiral baja rooter untuk mengatasi sumbatan lemak dapur secara tuntas.',
            'category' => Article::CATEGORY_EDUKASI,
            'is_published' => true,
            'published_at' => now()->subDay(),
            'views_count' => 1250,
        ]);

        CoverageArea::create([
            'province_name' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'type' => 'district',
            'is_active' => true,
        ]);

        // 1. Test District Page
        $districtResponse = $this->get('/area/jakarta-selatan/tebet');
        $districtResponse->assertStatus(200);
        $districtResponse->assertSee('Cara Mengatasi Saluran Pipa Mampet Tanpa Kimia Keras');
        $districtResponse->assertSee('uploads/articles/solusi-pipa-mampet.webp');
        $districtResponse->assertSee('1.250 views');
        $districtResponse->assertSee(Article::CATEGORY_EDUKASI);

        // 2. Test City Page
        $cityResponse = $this->get('/area/jakarta-selatan');
        $cityResponse->assertStatus(200);
        $cityResponse->assertSee('Cara Mengatasi Saluran Pipa Mampet Tanpa Kimia Keras');
        $cityResponse->assertSee('uploads/articles/solusi-pipa-mampet.webp');
        $cityResponse->assertSee('1.250 views');

        // 3. Test Province Page
        $provinceResponse = $this->get('/area/provinsi/dki-jakarta');
        $provinceResponse->assertStatus(200);
        $provinceResponse->assertSee('Cara Mengatasi Saluran Pipa Mampet Tanpa Kimia Keras');
        $provinceResponse->assertSee('uploads/articles/solusi-pipa-mampet.webp');
        $provinceResponse->assertSee('1.250 views');
    }
}
