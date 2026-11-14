<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogEnhancementsTest extends TestCase
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

    public function test_blog_route_redirects_301_to_pengetahuan(): void
    {
        $response = $this->get('/blog');
        $response->assertStatus(301);
        $response->assertRedirect(route('articles.index'));
    }

    public function test_articles_index_page_displays_blog_hero_and_pillars(): void
    {
        Article::create([
            'title' => 'Cara Merawat Sifon Wastafel Dapur',
            'slug' => 'cara-merawat-sifon-wastafel-dapur',
            'category' => 'Edukasi',
            'content' => 'Gunakan air hangat untuk melarutkan sisa minyak.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('articles.index'));
        $response->assertOk();

        // Breadcrumb and headings
        $response->assertSee('Blog');
        $response->assertSee('Blog Resmi &amp; Publikasi', false);
        $response->assertSee('01. Edukasi Residensial');
        $response->assertSee('02. Teknologi &amp; K3', false);
        $response->assertSee('03. Komersial &amp; B2B', false);

        // YouTube video showcase section
        $response->assertSee('DOKUMENTASI TINDAKAN LAPANGAN');
        $response->assertSee('Video Praktik Pelancaran &amp; Cara Kerja Mesin Rooter', false);
        $response->assertSee('youtube-nocookie.com/embed', false);
    }

    public function test_views_counter_increments_on_detail_visit_and_avoids_refresh_spam(): void
    {
        $article = Article::create([
            'title' => 'Mengapa Soda Api Merusak Pipa PVC',
            'slug' => 'mengapa-soda-api-merusak-pipa-pvc',
            'category' => 'Edukasi',
            'content' => '## Bahaya Panas Eksotermik' . "\n\n" . 'Panas soda api melunakkan sambungan paralon PVC.',
            'is_published' => true,
            'published_at' => now(),
            'views_count' => 5,
        ]);

        // First visit
        $this->get(route('articles.show', $article->slug))->assertRedirect($article->silo_url);
        $this->get($article->silo_url)->assertOk();
        $this->assertSame(6, $article->fresh()->views_count);

        // Immediate refresh with same session
        $this->get($article->silo_url)->assertOk();
        $this->assertSame(6, $article->fresh()->views_count);
    }

    public function test_html_tags_in_content_are_allowed_and_headings_get_ids(): void
    {
        $htmlContent = '<h2>Penyebab Utama Wastafel Mampet</h2>' .
            '<p>Endapan lemak dan sisa makanan <strong>membatu</strong> di pipa.</p>' .
            '<ul><li>Lemak beku</li><li>Ampas kopi</li></ul>' .
            '<iframe src="https://www.youtube-nocookie.com/embed/demo"></iframe>';

        $article = Article::create([
            'title' => 'Panduan Perawatan Wastafel Lengkap',
            'slug' => 'panduan-perawatan-wastafel-lengkap',
            'category' => 'Edukasi',
            'content' => $htmlContent,
            'is_published' => true,
            'published_at' => now(),
        ]);

        $rendered = $article->rendered_content;
        $this->assertStringContainsString('id="penyebab-utama-wastafel-mampet"', $rendered);
        $this->assertStringContainsString('<strong>membatu</strong>', $rendered);
        $this->assertStringContainsString('<ul>', $rendered);
        $this->assertStringContainsString('<iframe', $rendered);

        $response = $this->get($article->silo_url);
        $response->assertOk();
        $response->assertSee('id="penyebab-utama-wastafel-mampet"', false);
        $response->assertSee('<strong>membatu</strong>', false);
    }

    public function test_supporting_tags_are_stored_and_rendered_on_detail(): void
    {
        $article = Article::create([
            'title' => 'Inspeksi Kamera CCTV Pipa IP68',
            'slug' => 'inspeksi-kamera-cctv-pipa-ip68',
            'category' => 'Penguatan Brand',
            'tags' => 'CCTV Pipa, Deteksi Retak, Drainase',
            'content' => 'Kamera endoskopi menjangkau 30 meter.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->assertSame(['CCTV Pipa', 'Deteksi Retak', 'Drainase'], $article->tags_list);

        $response = $this->get($article->silo_url);
        $response->assertOk();
        $response->assertSee('#CCTV Pipa');
        $response->assertSee('#Deteksi Retak');
        $response->assertSee('#Drainase');
    }

    public function test_image_placement_options_in_admin_form_and_detail_view(): void
    {
        $this->actingAs($this->adminUser);

        // Check create form has fields
        $createResponse = $this->get(route('admin.articles.create'));
        $createResponse->assertOk();
        $createResponse->assertSee('name="image_placement"', false);
        $createResponse->assertSee('name="tags"', false);
        $createResponse->assertSee('name="published_at"', false);

        // Store with hero placement and custom published_at
        $postData = [
            'title' => 'Studi Kasus Rooter di Restoran',
            'category' => 'Penguatan Brand',
            'image_placement' => 'hero',
            'tags' => 'Restoran, Grease Trap',
            'published_at' => '2026-10-15T14:30',
            'content' => 'Penanganan lemak restoran di Jakarta.',
            'is_published' => '1',
        ];

        $postResponse = $this->post(route('admin.articles.store'), $postData);
        $postResponse->assertRedirect(route('admin.articles.index'));

        $created = Article::where('slug', 'studi-kasus-rooter-di-restoran')->first();
        $this->assertNotNull($created);
        $this->assertSame('hero', $created->image_placement);
        $this->assertSame('Restoran, Grease Trap', $created->tags);
        $this->assertSame('2026-10-15 14:30', $created->published_at->format('Y-m-d H:i'));
    }

    public function test_article_detail_page_renders_image_zoom_lightbox_viewer(): void
    {
        $article = Article::create([
            'title' => 'Teknik Menggunakan Mesin Rooter Spiral Baja',
            'slug' => 'teknik-menggunakan-mesin-rooter-spiral-baja',
            'category' => 'Edukasi',
            'thumbnail' => 'images/dokumentasi-rooter-teknisi.webp',
            'image_placement' => 'content',
            'content' => 'Mesin rooter membersihkan kerak lemak tanpa merusak pipa.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get($article->silo_url);
        $response->assertOk();

        // Lightbox trigger & interactive elements
        $response->assertSee('x-data="blogImageViewer()"', false);
        $response->assertSee('Lihat Gambar Penuh');
        $response->assertSee('cursor-zoom-in', false);

        // Modal Lightbox & Accessible Controls
        $response->assertSee('role="dialog"', false);
        $response->assertSee('aria-label="Penampil Gambar Penuh"', false);
        $response->assertSee('aria-label="Perbesar Gambar"', false);
        $response->assertSee('aria-label="Perkecil Gambar"', false);
        $response->assertSee('aria-label="Tutup Penampil Gambar"', false);
        $response->assertSee('window.blogImageViewer = function()', false);
    }
}
