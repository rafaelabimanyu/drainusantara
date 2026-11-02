<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\CoverageArea;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Drainusantara@admin',
            'email' => 'Drainusantara@admin',
            'password' => Hash::make('Drainusantara123'),
        ]);
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('CMS Control Panel');
        $response->assertDontSee('Drainusantara@admin');
    }

    public function test_admin_can_authenticate_using_login_screen(): void
    {
        $response = $this->post('/login', [
            'login' => 'Drainusantara@admin',
            'password' => 'Drainusantara123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/admin');
    }

    public function test_secondary_admin_can_authenticate_with_and_without_space_password(): void
    {
        User::create([
            'name' => 'Drainusantara2@admin',
            'email' => 'Drainusantara2@admin',
            'password' => Hash::make('Drainusantara 123'),
        ]);

        // Attempt login with exact space password
        $response1 = $this->post('/login', [
            'login' => 'Drainusantara2@admin',
            'password' => 'Drainusantara 123',
        ]);
        $this->assertAuthenticated();
        $response1->assertRedirect('/admin');

        $this->post('/logout');
        $this->assertGuest();

        // Attempt login without space password (normalized tolerance)
        $response2 = $this->post('/login', [
            'login' => 'Drainusantara2@admin',
            'password' => 'Drainusantara123',
        ]);
        $this->assertAuthenticated();
        $response2->assertRedirect('/admin');
    }

    public function test_admin_can_not_authenticate_with_invalid_password(): void
    {
        $response = $this->from('/login')->post('/login', [
            'login' => 'Drainusantara@admin',
            'password' => 'WrongPassword',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('login');
    }

    public function test_login_is_rate_limited_after_five_attempts(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from('/login')->post('/login', [
                'login' => 'unknown-admin',
                'password' => 'WrongPassword',
            ])->assertRedirect('/login');
        }

        $this->post('/login', [
            'login' => 'unknown-admin',
            'password' => 'WrongPassword',
        ])->assertTooManyRequests();
    }

    public function test_admin_can_logout(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard_renders_successfully(): void
    {
        Service::create([
            'name' => 'Kloset Mampet',
            'slug' => 'kloset-mampet',
            'price_starting_from' => 450000,
            'is_active' => true,
        ]);

        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Ringkasan Dashboard');
        $response->assertSee('Total Layanan');
        $response->assertSee('Area Jangkauan (SEO)');
        $response->assertSee('Kloset Mampet');
    }

    public function test_admin_services_crud(): void
    {
        $this->actingAs($this->adminUser);

        // 1. List services
        $response = $this->get('/admin/services');
        $response->assertStatus(200);
        $response->assertSee('Katalog Layanan Pipa Mampet');

        // 2. Create service
        $postResponse = $this->post('/admin/services', [
            'name' => 'Saluran Talang Air Mampet',
            'price_starting_from' => 400000,
            'short_description' => 'Pelancaran pipa talang atap.',
            'features_text' => "Tanpa bongkar atap\nGaransi 30 hari",
            'is_active' => '1',
            'order' => 5,
        ]);

        $postResponse->assertRedirect('/admin/services');
        $this->assertDatabaseHas('services', [
            'name' => 'Saluran Talang Air Mampet',
            'slug' => 'saluran-talang-air-mampet',
            'price_starting_from' => 400000,
        ]);

        $service = Service::where('slug', 'saluran-talang-air-mampet')->first();
        $this->assertNotNull($service);

        // 3. Delete service
        $deleteResponse = $this->delete("/admin/services/{$service->id}");
        $deleteResponse->assertRedirect('/admin/services');
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    public function test_admin_coverage_areas_crud(): void
    {
        $this->actingAs($this->adminUser);

        // 1. List areas
        $response = $this->get('/admin/coverage-areas');
        $response->assertStatus(200);
        $response->assertSee('Area Jangkauan & Landing SEO Lokal', false);

        // 2. Create area with hero_image and faqs
        $postResponse = $this->post('/admin/coverage-areas', [
            'city' => 'Jakarta Barat',
            'district' => 'Puri Indah',
            'postal_code' => '11610',
            'hero_image_url' => 'https://domain.com/puri-indah.webp',
            'faqs' => [
                [
                    'question' => 'Berapa lama teknisi sampai ke Puri Indah?',
                    'answer' => 'Sekitar 30 menit dari posko terdekat.',
                ],
            ],
            'is_active' => '1',
        ]);

        $postResponse->assertRedirect('/admin/coverage-areas');
        $this->assertDatabaseHas('coverage_areas', [
            'city' => 'Jakarta Barat',
            'district' => 'Puri Indah',
            'slug' => 'jakarta-barat-puri-indah',
            'hero_image' => 'https://domain.com/puri-indah.webp',
        ]);

        $createdArea = \App\Models\CoverageArea::where('slug', 'jakarta-barat-puri-indah')->first();
        $this->assertNotNull($createdArea);
        $this->assertCount(1, $createdArea->faqs);
        $this->assertEquals('Berapa lama teknisi sampai ke Puri Indah?', $createdArea->faqs[0]['question']);

        // 3. Update area
        $putResponse = $this->put("/admin/coverage-areas/{$createdArea->id}", [
            'city' => 'Jakarta Barat',
            'district' => 'Puri Indah',
            'hero_image_url' => 'https://domain.com/puri-indah-updated.webp',
            'faqs' => [
                [
                    'question' => 'Berapa biaya pipa mampet di Puri Indah?',
                    'answer' => 'Mulai Rp 400.000 bergaransi 30 hari.',
                ],
            ],
            'is_active' => '1',
        ]);

        $putResponse->assertRedirect('/admin/coverage-areas');
        $createdArea->refresh();
        $this->assertEquals('https://domain.com/puri-indah-updated.webp', $createdArea->hero_image);
        $this->assertEquals('Berapa biaya pipa mampet di Puri Indah?', $createdArea->faqs[0]['question']);
    }

    public function test_admin_galleries_crud(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->get('/admin/galleries');
        $response->assertStatus(200);
        $response->assertSee('Galeri & Portofolio Proyek');

        $postResponse = $this->post('/admin/galleries', [
            'title' => 'Pembersihan Pipa Restoran Senopati',
            'description' => 'Kerak minyak membeku dibersihkan dengan kabel spiral baja.',
            'before_image' => 'https://placehold.co/600x400?text=Before',
            'after_image' => 'https://placehold.co/600x400?text=After',
            'is_active' => '1',
        ]);

        $postResponse->assertRedirect('/admin/galleries');
        $this->assertDatabaseHas('galleries', [
            'title' => 'Pembersihan Pipa Restoran Senopati',
        ]);
    }

    public function test_admin_articles_crud(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->get('/admin/articles');
        $response->assertStatus(200);
        $response->assertSee('Daftar Artikel & Edukasi Plumbing');

        $postResponse = $this->post('/admin/articles', [
            'title' => 'Cara Merawat Sifon Wastafel Dapur',
            'category' => 'Tips Rumah',
            'excerpt' => 'Panduan membersihkan leher angsa wastafel agar bebas bau got.',
            'content' => 'Lakukan pembersihan berkala pada perangkap sifon setiap 3 bulan sekali.',
            'is_published' => '1',
        ]);

        $postResponse->assertRedirect('/admin/articles');
        $this->assertDatabaseHas('articles', [
            'title' => 'Cara Merawat Sifon Wastafel Dapur',
            'slug' => 'cara-merawat-sifon-wastafel-dapur',
        ]);
    }

    public function test_admin_service_image_upload(): void
    {
        $this->actingAs($this->adminUser);

        $file = UploadedFile::fake()->image('wastafel-test.jpg', 600, 400);

        $response = $this->post('/admin/services', [
            'name' => 'Wastafel Dapur Mampet',
            'price_starting_from' => 400000,
            'image' => $file,
        ]);

        $response->assertRedirect('/admin/services');
        $service = Service::where('slug', 'wastafel-dapur-mampet')->first();
        $this->assertNotNull($service);
        $this->assertStringContainsString('/images/services/', $service->image);
        $savedPath = public_path(ltrim($service->image, '/'));
        $this->assertFileExists($savedPath);

        if (file_exists($savedPath)) {
            @unlink($savedPath);
        }
    }

    public function test_admin_gallery_image_upload(): void
    {
        $this->actingAs($this->adminUser);

        $before = UploadedFile::fake()->image('before-saluran.jpg', 600, 400);
        $after = UploadedFile::fake()->image('after-saluran.jpg', 600, 400);

        $response = $this->post('/admin/galleries', [
            'title' => 'Pipa Restoran Bebas Sumbatan',
            'before_image' => $before,
            'after_image' => $after,
        ]);

        $response->assertRedirect('/admin/galleries');
        $gallery = Gallery::where('title', 'Pipa Restoran Bebas Sumbatan')->first();
        $this->assertNotNull($gallery);
        $this->assertStringContainsString('/images/dokumentasi/', $gallery->before_image);
        $this->assertStringContainsString('/images/dokumentasi/', $gallery->after_image);
        $this->assertFileExists(public_path(ltrim($gallery->before_image, '/')));
        $this->assertFileExists(public_path(ltrim($gallery->after_image, '/')));

        // Clean up test files
        @unlink(public_path(ltrim($gallery->before_image, '/')));
        @unlink(public_path(ltrim($gallery->after_image, '/')));
    }

    public function test_admin_article_image_upload(): void
    {
        $this->actingAs($this->adminUser);
        Storage::fake('public');

        $thumb = UploadedFile::fake()->image('artikel.png', 800, 500);

        $response = $this->post('/admin/articles', [
            'title' => 'Tips Aman Mengatasi Pipa Tersumbat',
            'content' => 'Gunakan cara mekanis ketimbang bahan kimia keras.',
            'thumbnail' => $thumb,
        ]);

        $response->assertRedirect('/admin/articles');
        $article = Article::where('slug', 'tips-aman-mengatasi-pipa-tersumbat')->first();
        $this->assertNotNull($article);
        $this->assertStringContainsString('/storage/articles/', $article->thumbnail);
        Storage::disk('public')->assertExists(str_replace('/storage/', '', $article->thumbnail));
    }

    public function test_admin_gallery_destroy_deletes_image_files(): void
    {
        $this->actingAs($this->adminUser);

        $testFile = UploadedFile::fake()->image('test-delete-dokumentasi.jpg', 600, 400);

        $response = $this->post('/admin/galleries', [
            'title' => 'Dokumentasi Hapus File Fisik',
            'image' => $testFile,
        ]);

        $response->assertRedirect('/admin/galleries');
        $gallery = Gallery::where('title', 'Dokumentasi Hapus File Fisik')->first();
        $this->assertNotNull($gallery);
        $this->assertFileExists(public_path(ltrim($gallery->image, '/')));

        // Hapus via CMS
        $deleteResponse = $this->delete("/admin/galleries/{$gallery->id}");
        $deleteResponse->assertRedirect('/admin/galleries');
        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);

        // Verifikasi file fisik juga terhapus dari folder public/images/dokumentasi
        $this->assertFileDoesNotExist(public_path(ltrim($gallery->image, '/')));
    }

    public function test_admin_portfolio_destroy_deletes_image_file(): void
    {
        $this->actingAs($this->adminUser);

        $testFile = UploadedFile::fake()->image('test-delete-portfolio.jpg', 600, 400);

        $response = $this->post('/admin/portfolios', [
            'client_name' => 'PT Test Hapus File',
            'image' => $testFile,
        ]);

        $response->assertRedirect('/admin/portfolios');
        $portfolio = \App\Models\Portfolio::where('client_name', 'PT Test Hapus File')->first();
        $this->assertNotNull($portfolio);
        $this->assertFileExists(public_path(ltrim($portfolio->image, '/')));

        // Hapus via CMS
        $deleteResponse = $this->delete("/admin/portfolios/{$portfolio->id}");
        $deleteResponse->assertRedirect('/admin/portfolios');
        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);

        // Verifikasi file fisik juga terhapus dari folder public/images/portfolio
        $this->assertFileDoesNotExist(public_path(ltrim($portfolio->image, '/')));
    }
}

