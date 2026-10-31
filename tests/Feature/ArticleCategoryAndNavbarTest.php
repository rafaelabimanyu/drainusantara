<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleCategoryAndNavbarTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Drainusantara@admin',
            'email' => 'Drainusantara@admin',
            'password' => \Illuminate\Support\Facades\Hash::make('Drainusantara123'),
        ]);
    }

    public function test_desktop_navbar_and_mobile_drawer_display_artikel_label(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        // Desktop navbar
        $response->assertSee('Artikel');
        $response->assertSee(route('articles.index'));

        // Mobile drawer
        $response->assertSee('Artikel &amp; Edukasi', false);
    }

    public function test_article_model_normalizes_categories_and_slugs(): void
    {
        $edu = Article::create([
            'title' => 'Tips Merawat Pipa Paralon',
            'slug' => 'tips-merawat-pipa-paralon',
            'category' => 'Tips & Edukasi',
            'content' => 'Konten edukasi pipa paralon.',
        ]);
        $this->assertSame('edukasi', $edu->category_slug);
        $this->assertSame('Edukasi', $edu->category_label);

        $brand = Article::create([
            'title' => 'Keunggulan Mesin Rotary K-50',
            'slug' => 'keunggulan-mesin-rotary-k-50',
            'category' => 'Teknologi Plumbing',
            'content' => 'Armada canggih Drainusantara.',
        ]);
        $this->assertSame('penguatan-brand', $brand->category_slug);
        $this->assertSame('Penguatan Brand', $brand->category_label);

        $promo = Article::create([
            'title' => 'Promo Penanganan Saluran Darurat',
            'slug' => 'promo-penanganan-saluran-darurat',
            'category' => 'Promo Penawaran',
            'content' => 'Paket promo pelancaran pipa.',
        ]);
        $this->assertSame('promo-penawaran', $promo->category_slug);
        $this->assertSame('Promo Penawaran', $promo->category_label);
    }

    public function test_articles_index_page_displays_three_category_tabs(): void
    {
        $response = $this->get(route('articles.index'));
        $response->assertOk();

        $response->assertSee('Semua Artikel');
        $response->assertSee('Edukasi');
        $response->assertSee('Penguatan Brand');
        $response->assertSee('Promo Penawaran');
        $response->assertSee("activeCategory = 'edukasi'", false);
        $response->assertSee("activeCategory = 'penguatan-brand'", false);
        $response->assertSee("activeCategory = 'promo-penawaran'", false);
    }

    public function test_admin_article_forms_provide_category_select_options(): void
    {
        $this->actingAs($this->adminUser);

        // Create form
        $createResponse = $this->get(route('admin.articles.create'));
        $createResponse->assertOk();
        $createResponse->assertSee('<select name="category"', false);
        $createResponse->assertSee('value="Edukasi"', false);
        $createResponse->assertSee('value="Penguatan Brand"', false);
        $createResponse->assertSee('value="Promo Penawaran"', false);

        // Store via admin
        $postResponse = $this->post(route('admin.articles.store'), [
            'title' => 'Artikel Promo Khusus B2B Restoran',
            'category' => 'Promo Penawaran',
            'excerpt' => 'Promo khusus kontrak maintenance resto.',
            'content' => 'Informasi paket promo untuk restoran.',
            'is_published' => true,
        ]);
        $postResponse->assertRedirect(route('admin.articles.index'));

        $article = Article::where('slug', 'artikel-promo-khusus-b2b-restoran')->first();
        $this->assertNotNull($article);
        $this->assertSame('Promo Penawaran', $article->category);
        $this->assertSame('Promo Penawaran', $article->category_label);
        $this->assertSame('promo-penawaran', $article->category_slug);

        // Edit form
        $editResponse = $this->get(route('admin.articles.edit', $article));
        $editResponse->assertOk();
        $editResponse->assertSee('<select name="category"', false);
        $editResponse->assertSee('selected', false);
    }
}
