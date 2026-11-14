<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ComprehensiveEnhancementsV5Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_google_analytics_tag_is_present_in_head(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('G-VN5KHRRZ1D', false);
        $response->assertSee('googletagmanager.com/gtag/js?id=G-VN5KHRRZ1D', false);
    }

    public function test_legal_pages_privacy_policy_and_terms_of_service(): void
    {
        $privacy = $this->get(route('legal.privacy'));
        $privacy->assertStatus(200);
        $privacy->assertSee('Kebijakan Privasi', false);
        $privacy->assertSee('PT JAWA JAYA ROOTER', false);

        $terms = $this->get(route('legal.terms'));
        $terms->assertStatus(200);
        $terms->assertSee('Syarat & Ketentuan Layanan', false);
        $terms->assertSee('Garansi Tertulis 30 Hari Kalender', false);

        // Test 301 legacy redirects
        $this->get('/privacy-policy')->assertRedirect(route('legal.privacy'));
        $this->get('/terms-of-service')->assertRedirect(route('legal.terms'));
    }

    public function test_long_article_content_does_not_disappear(): void
    {
        // Generate a very long content string with 200 paragraphs
        $longContent = '';
        for ($i = 1; $i <= 200; $i++) {
            $longContent .= "<p>Paragraf ke-{$i} mengenai penanganan saluran pipa mampet menggunakan mesin rotary rooter tanpa pembongkaran lantai keramik pada perumahan dan komersial.</p>\n\n";
        }

        $article = Article::create([
            'title' => 'Uji Konten Panjang',
            'slug' => 'uji-konten-panjang',
            'category' => 'Edukasi',
            'excerpt' => 'Ringkasan uji konten panjang',
            'content' => $longContent,
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        $rendered = $article->rendered_content;
        $this->assertNotEmpty($rendered);
        $this->assertStringContainsString('Paragraf ke-1 mengenai penanganan', $rendered);
        $this->assertStringContainsString('Paragraf ke-200 mengenai penanganan', $rendered);

        $this->get(route('articles.show', $article->slug))->assertRedirect($article->silo_url);
        $response = $this->get($article->silo_url);
        $response->assertStatus(200);
        $response->assertSee('Paragraf ke-200 mengenai penanganan', false);
    }

    public function test_inline_content_images_with_shortcodes_and_auto_placement(): void
    {
        $articleWithShortcode = Article::create([
            'title' => 'Artikel Shortcode Foto',
            'slug' => 'artikel-shortcode-foto',
            'category' => 'Edukasi',
            'excerpt' => 'Ringkasan foto',
            'content' => "<p>Paragraf awal.</p>\n[foto-1]\n<p>Paragraf akhir.</p>",
            'content_images' => [
                ['path' => '/storage/articles/foto-tengah-1.webp', 'caption' => 'Kamera CCTV Inspeksi'],
            ],
            'is_published' => true,
            'published_at' => now(),
        ]);

        $rendered = $articleWithShortcode->rendered_content;
        $this->assertStringContainsString('/storage/articles/foto-tengah-1.webp', $rendered);
        $this->assertStringContainsString('Kamera CCTV Inspeksi', $rendered);
        $this->assertStringNotContainsString('[foto-1]', $rendered);

        // Test auto placement when no shortcodes exist
        $articleAuto = Article::create([
            'title' => 'Artikel Auto Foto',
            'slug' => 'artikel-auto-foto',
            'category' => 'Edukasi',
            'excerpt' => 'Ringkasan auto foto',
            'content' => "<p>P1</p>\n<p>P2</p>\n<p>P3</p>\n<p>P4</p>",
            'content_images' => [
                ['path' => '/storage/articles/auto-1.webp', 'caption' => 'Foto Auto 1'],
            ],
            'is_published' => true,
            'published_at' => now(),
        ]);

        $renderedAuto = $articleAuto->rendered_content;
        $this->assertStringContainsString('/storage/articles/auto-1.webp', $renderedAuto);
        $this->assertStringContainsString('Foto Auto 1', $renderedAuto);
    }

    public function test_blog_recommendations_deduplication(): void
    {
        // Create 10 published articles
        $created = [];
        for ($i = 1; $i <= 10; $i++) {
            $created[] = Article::create([
                'title' => "Artikel Edukasi {$i}",
                'slug' => "artikel-edukasi-{$i}",
                'category' => 'Edukasi',
                'excerpt' => "Ringkasan artikel edukasi {$i}",
                'content' => "<p>Isi artikel edukasi {$i}</p>",
                'is_published' => true,
                'published_at' => now()->subDays($i),
            ]);
        }

        $currentArticle = $created[0];

        $this->get(route('articles.show', $currentArticle->slug))->assertRedirect($currentArticle->silo_url);
        $response = $this->get($currentArticle->silo_url);
        $response->assertStatus(200);

        $recentArticles = $response->viewData('recentArticles');
        $relatedArticles = $response->viewData('relatedArticles');

        $this->assertNotNull($recentArticles);
        $this->assertNotNull($relatedArticles);

        $recentIds = $recentArticles->pluck('id')->all();
        $relatedIds = $relatedArticles->pluck('id')->all();

        // Must not contain current article
        $this->assertNotContains($currentArticle->id, $recentIds);
        $this->assertNotContains($currentArticle->id, $relatedIds);

        // Deduplication: no ID should be in both collections
        $overlap = array_intersect($recentIds, $relatedIds);
        $this->assertEmpty($overlap, 'Sidebar and bottom recommendations should not duplicate articles.');
    }

    public function test_sub_category_filtering_and_storage(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.articles.store'), [
            'title' => 'Bahaya Soda Api pada Pipa',
            'category' => 'Edukasi',
            'sub_category' => 'Bahaya Kimia & Soda Api',
            'content' => '<p>Penjelasan bahaya soda api.</p>',
            'excerpt' => 'Ringkasan bahaya soda api.',
            'is_published' => '1',
            'published_at' => now()->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect(route('admin.articles.index'));

        $article = Article::where('title', 'Bahaya Soda Api pada Pipa')->first();
        $this->assertNotNull($article);
        $this->assertSame('Bahaya Kimia & Soda Api', $article->sub_category);
    }

    public function test_portfolio_documentation_images_storage(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.portfolios.store'), [
            'client_name' => 'PT Boga Rasa',
            'project_title' => 'Restoran Boga Rasa Sudirman',
            'client_type' => 'Restoran & Cafe',
            'location' => 'Jakarta Pusat',
            'description' => 'Penanganan pipa grease trap mampet total.',
            'scope_of_work' => 'Grease trap clearance, Rotary rooter',
            'doc_image_1' => UploadedFile::fake()->image('doc1.jpg', 800, 600),
            'doc_caption_1' => 'Unit spiral baja Ridgid',
            'doc_image_2' => UploadedFile::fake()->image('doc2.jpg', 800, 600),
            'doc_caption_2' => 'Pengecekan bak kontrol restoran',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.portfolios.index'));

        $portfolio = Portfolio::where('client_name', 'PT Boga Rasa')->first();
        $this->assertNotNull($portfolio);
        $this->assertIsArray($portfolio->documentation_images);
        $this->assertCount(2, $portfolio->documentation_images);
        $this->assertSame('Unit spiral baja Ridgid', $portfolio->documentation_images[0]['caption']);
    }

    public function test_about_page_5_steps_responsive_structure(): void
    {
        $response = $this->get(route('how-it-works'));
        $response->assertStatus(200);
        $response->assertSee('5 Tahapan Pelancaran Saluran Pipa Mekanis', false);
        $response->assertSee('langkah-1', false);
        $response->assertSee('langkah-5', false);
        // Verify horizontal swipe scroll is removed in favor of clean vertical responsive flow
        $response->assertDontSee('overflow-x-auto snap-x', false);
    }
}
