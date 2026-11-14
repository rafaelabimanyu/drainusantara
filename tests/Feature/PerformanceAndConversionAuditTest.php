<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSubcategory;
use App\Models\CoverageArea;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\User;
use App\Support\MediaLifecycle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PerformanceAndConversionAuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_contextual_whatsapp_message_on_area_pages(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Baru',
            'slug' => 'kebayoran-baru',
            'is_active' => true,
        ]);

        // 1. District page
        $districtResponse = $this->get('/area/jakarta-selatan/kebayoran-baru');
        $districtResponse->assertStatus(200);
        $expectedDistrictMsg = 'Halo Tim Drainusantara, saya membutuhkan jasa pelancaran pipa mampet di area Kecamatan Kebayoran Baru, Jakarta Selatan. Mohon info estimasi biaya dan teknisi terdekat.';
        $districtResponse->assertSee($expectedDistrictMsg, false);

        // 2. City page
        $cityResponse = $this->get('/area/jakarta-selatan');
        $cityResponse->assertStatus(200);
        $expectedCityMsg = 'Halo Tim Drainusantara, saya butuh penanganan saluran pipa mampet di wilayah Jakarta Selatan. Mohon info armada terdekat.';
        $cityResponse->assertSee($expectedCityMsg, false);

        // 3. Province page
        $provResponse = $this->get('/area/provinsi/dki-jakarta');
        $provResponse->assertStatus(200);
        $expectedProvMsg = 'Halo Tim Drainusantara, saya ingin konsultasi layanan saluran pipa mampet untuk wilayah DKI Jakarta.';
        $provResponse->assertSee($expectedProvMsg, false);
    }

    public function test_contextual_whatsapp_message_on_article_and_showcase(): void
    {
        $category = ArticleCategory::create(['name' => 'Kategori Pipa', 'slug' => 'kategori-pipa']);
        $subcategory = ArticleSubcategory::create(['category_id' => $category->id, 'name' => 'Wastafel', 'slug' => 'wastafel']);
        $article = Article::create([
            'title' => 'Cara Atasi Wastafel Berlemak',
            'slug' => 'cara-atasi-wastafel-berlemak',
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'content' => 'Gunakan air panas berkala.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $articleResponse = $this->get($article->silo_url);
        $articleResponse->assertStatus(200);
        $expectedArticleMsg = "Halo Tim Drainusantara, saya sedang membaca artikel '{$article->title}' dan ingin konsultasi penanganan saluran pipa di tempat saya.";
        $articleResponse->assertSee($expectedArticleMsg, false);

        // Case study
        $gallery = Gallery::create([
            'title' => 'Penanganan Pipa Restoran Senopati',
            'slug' => 'penanganan-pipa-restoran-senopati',
            'location' => 'Senopati, Jakarta Selatan',
            'is_active' => true,
        ]);

        $caseStudyResponse = $this->get(route('case-study.show', $gallery->slug));
        $caseStudyResponse->assertStatus(200);
        $expectedCaseStudyMsg = "Halo Tim Drainusantara, saya melihat dokumentasi '{$gallery->title}' dan ingin tanya estimasi untuk penanganan serupa.";
        $caseStudyResponse->assertSee($expectedCaseStudyMsg, false);

        // Partnership
        $portfolio = Portfolio::create([
            'client_name' => 'Restoran Mewah Jakarta',
            'project_title' => 'Maintenance Pipa Grease Trap Rutin',
            'slug' => 'restoran-mewah-jakarta',
            'is_active' => true,
        ]);

        $partnershipResponse = $this->get(route('partnership.show', $portfolio->slug));
        $partnershipResponse->assertStatus(200);
        $expectedPartnershipMsg = "Halo Tim Drainusantara, saya melihat dokumentasi '{$portfolio->project_title}' dan ingin tanya estimasi untuk penanganan serupa.";
        $partnershipResponse->assertSee($expectedPartnershipMsg, false);
    }

    public function test_cache_invalidation_on_cms_mutations(): void
    {
        $admin = User::factory()->create();

        // 1. Gallery Cache Invalidation
        $gallery = Gallery::create([
            'title' => 'Galeri Uji Cache',
            'slug' => 'galeri-uji-cache',
            'is_active' => true,
        ]);

        Cache::put('case_study_galeri-uji-cache', 'cached-data', 86400);
        Cache::put('landing.galleries', 'cached-landing', 86400);
        $this->assertTrue(Cache::has('case_study_galeri-uji-cache'));
        $this->assertTrue(Cache::has('landing.galleries'));

        $this->actingAs($admin)->put(route('admin.galleries.update', $gallery), [
            'title' => 'Galeri Uji Cache Diperbarui',
            'slug' => 'galeri-uji-cache-baru',
            'is_active' => '1',
        ]);

        $this->assertFalse(Cache::has('case_study_galeri-uji-cache'));
        $this->assertFalse(Cache::has('landing.galleries'));

        // 2. Portfolio Cache Invalidation
        $portfolio = Portfolio::create([
            'client_name' => 'Klien Portfolio Uji Cache',
            'slug' => 'klien-portfolio-uji-cache',
            'is_active' => true,
        ]);

        Cache::put('partnership_klien-portfolio-uji-cache', 'cached-partnership', 86400);
        Cache::put('landing.portfolios', 'cached-portfolios', 86400);
        $this->assertTrue(Cache::has('partnership_klien-portfolio-uji-cache'));
        $this->assertTrue(Cache::has('landing.portfolios'));

        $this->actingAs($admin)->delete(route('admin.portfolios.destroy', $portfolio));
        $this->assertFalse(Cache::has('partnership_klien-portfolio-uji-cache'));
        $this->assertFalse(Cache::has('landing.portfolios'));
    }

    public function test_media_lifecycle_cleans_up_multi_slot_array_images(): void
    {
        Storage::fake('public');
        $media = new MediaLifecycle;

        $file = UploadedFile::fake()->image('test-slot.jpg', 400, 300);
        $uploadedPath = $media->upload($file, 'articles', true);
        $diskPath = substr($uploadedPath, strlen('/storage/'));

        Storage::disk('public')->assertExists($diskPath);

        $article = Article::create([
            'title' => 'Artikel Multi Slot Image Test',
            'slug' => 'artikel-multi-slot-image-test',
            'content' => 'Konten uji media multi slot.',
            'content_images' => [
                ['path' => $uploadedPath, 'caption' => 'Kamera CCTV Pipa'],
            ],
            'is_published' => true,
        ]);

        // Removing the image from content_images and saving should trigger cleanup
        $media->run($article, function () use ($article, $media): void {
            $media->save($article, [
                'content_images' => [],
            ]);
        });

        Storage::disk('public')->assertMissing($diskPath);
    }

    public function test_area_views_have_explicit_cls_dimensions_and_geographic_alt_text(): void
    {
        CoverageArea::create([
            'city' => 'Tangerang Kota',
            'district' => 'Cipondoh',
            'slug' => 'cipondoh',
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Pelancaran Pipa Paralon Restoran',
            'slug' => 'pelancaran-pipa-paralon-restoran',
            'location' => 'Cipondoh, Tangerang Kota',
            'image' => 'images/dokumentasi/pelancar-saluran-gutter-resto-jakarta.webp',
            'is_active' => true,
        ]);

        Article::create([
            'title' => 'Panduan Perawatan Pipa Tangerang',
            'slug' => 'panduan-perawatan-pipa-tangerang',
            'content' => 'Tips pipa tanpa mampet di Tangerang.',
            'thumbnail' => 'images/dokumentasi/inspeksi-kamera-cctv-pipa-tersumbat.webp',
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Check District View
        $districtHtml = $this->get('/area/tangerang-kota/cipondoh')->assertOk()->getContent();
        $this->assertStringContainsString('width="600"', $districtHtml);
        $this->assertStringContainsString('height="375"', $districtHtml);
        $this->assertStringContainsString('loading="lazy"', $districtHtml);
        $this->assertStringContainsString('decoding="async"', $districtHtml);
        $this->assertStringContainsString('Dokumentasi Jasa Saluran Pipa Mampet di Cipondoh, Tangerang Kota', $districtHtml);

        // Check City View
        $cityHtml = $this->get('/area/tangerang-kota')->assertOk()->getContent();
        $this->assertStringContainsString('width="600"', $cityHtml);
        $this->assertStringContainsString('height="375"', $cityHtml);
        $this->assertStringContainsString('Dokumentasi Jasa Saluran Pipa Mampet di Tangerang Kota', $cityHtml);
    }
}
