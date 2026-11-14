<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleStudioAndRendererTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_renders_shortcodes_callouts_and_eeat_box(): void
    {
        $article = Article::create([
            'title' => 'Panduan Perawatan Pipa PVC Anti Mampet',
            'slug' => 'panduan-perawatan-pipa-pvc-anti-mampet',
            'content' => "## Cara Merawat Saluran\n\n" .
                "[Info Penting]Pipa PVC standar memerlukan perawatan rutin tanpa bahan kimia keras.[/Info Penting]\n\n" .
                "[Peringatan Bahaya]Soda api dapat melelehkan sambungan lem PVC.[/Peringatan Bahaya]\n\n" .
                "[Tips Hemat]Gunakan air panas seminggu sekali di leher angsa wastafel.[/Tips Hemat]\n\n" .
                "[cta-konsultasi]\n\n" .
                "[cta-kalkulator]\n\n" .
                "[video: https://www.youtube.com/watch?v=uE_yM6aK1S0]",
            'excerpt' => 'Panduan komprehensif merawat pipa PVC agar bebas sumbatan bertahun-tahun.',
            'category' => 'Edukasi',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->get(route('articles.show', $article->slug))->assertRedirect($article->silo_url);

        $response = $this->get($article->silo_url);

        $response->assertStatus(200);
        $response->assertSee('Catatan Penting', false);
        $response->assertSee('Pipa PVC standar memerlukan perawatan rutin', false);
        $response->assertSee('Peringatan Bahaya', false);
        $response->assertSee('Soda api dapat melelehkan sambungan lem PVC', false);
        $response->assertSee('Tips Hemat', false);
        $response->assertSee('Gunakan air panas seminggu sekali', false);
        $response->assertSee('Saluran Pipa Anda Mengalami Masalah Serupa?', false);
        $response->assertSee('Kalkulator Biaya Transparan', false);
        $response->assertSee('https://www.youtube.com/embed/uE_yM6aK1S0', false);
        $response->assertSee('Ditulis &amp; Ditinjau oleh Tim Ahli Teknis Drainusantara', false);
        $response->assertSee('PT Jawa Jaya Rooter', false);
        $response->assertSee('Bagikan Panduan Bermanfaat Ini:', false);
    }

    public function test_admin_can_save_article_with_related_service_and_city(): void
    {
        $admin = User::factory()->create();

        $service = Service::create([
            'name' => 'Pelancaran Wastafel Mampet',
            'slug' => 'wastafel-cuci-piring',
            'short_description' => 'Pelancaran wastafel mampet',
            'price_starting_from' => 400000,
            'is_active' => true,
        ]);

        $postData = [
            'title' => 'Solusi Wastafel Mampet di Semarang Tanpa Bongkar',
            'category' => 'Edukasi',
            'service_id' => $service->id,
            'city' => 'Kota Semarang',
            'content' => '## Solusi Wastafel Mampet di Semarang\n\nAir wastafel lambat mengalir karena lemak masakan beku.',
            'excerpt' => 'Panduan mengatasi wastafel mampet di Kota Semarang.',
            'is_published' => '1',
            'published_at' => now()->format('Y-m-d\TH:i'),
        ];

        $response = $this->actingAs($admin)->post(route('admin.articles.store'), $postData);

        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', [
            'title' => 'Solusi Wastafel Mampet di Semarang Tanpa Bongkar',
            'service_id' => $service->id,
            'city' => 'Kota Semarang',
        ]);

        $createdArticle = Article::where('title', 'Solusi Wastafel Mampet di Semarang Tanpa Bongkar')->firstOrFail();
        $this->get(route('articles.show', $createdArticle->slug))->assertRedirect($createdArticle->silo_url);
        $detailResponse = $this->get($createdArticle->silo_url);

        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Layanan Spesialis: Pelancaran Wastafel Mampet', false);
        $detailResponse->assertSee('Area Siaga: Kota Semarang', false);

        $redirectResponse = $this->get('/pengetahuan/' . $createdArticle->slug);
        $redirectResponse->assertStatus(301);
        $redirectResponse->assertRedirect(route('articles.show', $createdArticle->slug));
    }
}
