<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSubcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ArticleStudioAndTaxonomyTest extends TestCase
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

    public function test_admin_can_access_category_and_subcategory_management_index(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.article-categories.index'));
        $response->assertOk();
        $response->assertSee('Kategori &amp; Sub-Kategori Artikel', false);
        $response->assertSee('Tambah Kategori Utama');
        $response->assertSee('Tambah Sub-Kategori Baru');
    }

    public function test_admin_can_crud_article_categories(): void
    {
        $this->actingAs($this->adminUser);

        // 1. Create Category
        $response = $this->post(route('admin.article-categories.store'), [
            'name' => 'Teknologi Plumbing Modern',
            'description' => 'Kategori seputar teknologi canggih rooter dan CCTV pipa.',
            'sort_order' => 5,
        ]);
        $response->assertRedirect(route('admin.article-categories.index'));
        $response->assertSessionHas('success');

        $category = ArticleCategory::where('slug', 'teknologi-plumbing-modern')->first();
        $this->assertNotNull($category);
        $this->assertSame('Teknologi Plumbing Modern', $category->name);

        // 2. Update Category
        $updateResponse = $this->put(route('admin.article-categories.update', $category), [
            'name' => 'Teknologi Plumbing Terkini',
            'slug' => 'teknologi-plumbing-terkini',
            'description' => 'Deskripsi diperbarui.',
            'sort_order' => 6,
        ]);
        $updateResponse->assertRedirect(route('admin.article-categories.index'));

        $category->refresh();
        $this->assertSame('Teknologi Plumbing Terkini', $category->name);
        $this->assertSame('teknologi-plumbing-terkini', $category->slug);

        // 3. Delete Category
        $deleteResponse = $this->delete(route('admin.article-categories.destroy', $category));
        $deleteResponse->assertRedirect(route('admin.article-categories.index'));
        $this->assertDatabaseMissing('article_categories', ['id' => $category->id]);
    }

    public function test_admin_can_crud_article_subcategories(): void
    {
        $this->actingAs($this->adminUser);

        $category = ArticleCategory::create([
            'name' => 'Inovasi Alat',
            'slug' => 'inovasi-alat',
            'sort_order' => 1,
        ]);

        // 1. Create Subcategory
        $createSub = $this->post(route('admin.article-subcategories.store'), [
            'category_id' => $category->id,
            'name' => 'Kamera CCTV Endoskopi',
            'description' => 'Subkategori untuk inspeksi pipa dalam.',
            'sort_order' => 1,
        ]);
        $createSub->assertRedirect(route('admin.article-categories.index'));

        $subcategory = ArticleSubcategory::where('slug', 'kamera-cctv-endoskopi')->first();
        $this->assertNotNull($subcategory);
        $this->assertSame($category->id, $subcategory->category_id);

        // 2. Update Subcategory
        $updateSub = $this->put(route('admin.article-subcategories.update', $subcategory), [
            'name' => 'Kamera CCTV Pipa IP68',
            'slug' => 'kamera-cctv-pipa-ip68',
            'sort_order' => 2,
        ]);
        $updateSub->assertRedirect(route('admin.article-categories.index'));

        $subcategory->refresh();
        $this->assertSame('Kamera CCTV Pipa IP68', $subcategory->name);
        $this->assertSame('kamera-cctv-pipa-ip68', $subcategory->slug);

        // 3. Delete Subcategory
        $deleteSub = $this->delete(route('admin.article-subcategories.destroy', $subcategory));
        $deleteSub->assertRedirect(route('admin.article-categories.index'));
        $this->assertDatabaseMissing('article_subcategories', ['id' => $subcategory->id]);
    }

    public function test_api_subcategories_returns_json_list(): void
    {
        $this->actingAs($this->adminUser);

        $category = ArticleCategory::create([
            'name' => 'Edukasi Khusus',
            'slug' => 'edukasi-khusus',
        ]);

        ArticleSubcategory::create([
            'category_id' => $category->id,
            'name' => 'Sub Edukasi 1',
            'slug' => 'sub-edukasi-1',
        ]);

        ArticleSubcategory::create([
            'category_id' => $category->id,
            'name' => 'Sub Edukasi 2',
            'slug' => 'sub-edukasi-2',
        ]);

        $response = $this->getJson(route('admin.categories.subcategories', $category));
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'category_id' => $category->id,
            'category_name' => 'Edukasi Khusus',
        ]);
        $response->assertJsonCount(2, 'subcategories');
    }

    public function test_admin_can_upload_inline_image_to_webp_for_text_editor(): void
    {
        $this->actingAs($this->adminUser);

        // 1x1 transparent png
        $base64Png = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        $tempFile = tempnam(sys_get_temp_dir(), 'test_img_');
        file_put_contents($tempFile, base64_decode($base64Png));

        $uploadedFile = new UploadedFile($tempFile, 'test-editor-upload.png', 'image/png', null, true);

        $response = $this->postJson(route('admin.articles.upload-image'), [
            'file' => $uploadedFile,
        ]);

        $response->assertOk();
        $data = $response->json();
        $this->assertArrayHasKey('location', $data);
        $this->assertArrayHasKey('path', $data);
        $this->assertStringEndsWith('.webp', $data['path']);
        $this->assertStringContainsString('storage/articles/', $data['path']);
    }

    public function test_article_silo_url_route_renders_detail_page(): void
    {
        $category = ArticleCategory::create([
            'name' => 'Edukasi Mandiri',
            'slug' => 'edukasi-mandiri',
        ]);

        $subcategory = ArticleSubcategory::create([
            'category_id' => $category->id,
            'name' => 'Tips Wastafel Mampet',
            'slug' => 'tips-wastafel-mampet',
        ]);

        $article = Article::create([
            'title' => 'Cara Membersihkan Wastafel Tanpa Soda Api',
            'slug' => 'cara-membersihkan-wastafel-tanpa-soda-api',
            'category' => $category->name,
            'sub_category' => $subcategory->name,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'content' => 'Gunakan metode mekanis spiral baja untuk melancarkan leher angsa wastafel.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->assertSame(
            url('/edukasi/edukasi-mandiri/tips-wastafel-mampet/cara-membersihkan-wastafel-tanpa-soda-api'),
            $article->silo_url
        );

        $response = $this->get('/edukasi/edukasi-mandiri/tips-wastafel-mampet/cara-membersihkan-wastafel-tanpa-soda-api');
        $response->assertOk();
        $response->assertSee('Cara Membersihkan Wastafel Tanpa Soda Api');
        $response->assertSee('Gunakan metode mekanis spiral baja');
    }

    public function test_article_form_ui_does_not_leak_raw_javascript_code_in_html_dom(): void
    {
        $this->actingAs($this->adminUser);

        $createResponse = $this->get(route('admin.articles.create'));
        $createResponse->assertOk();
        $createContent = $createResponse->getContent();

        // The raw functions should NOT leak into opening tag attributes
        $this->assertStringNotContainsString('x-data="{ title', $createContent);
        $this->assertStringNotContainsString('x-data="articleStudio({', $createContent);
        // It must cleanly call articleStudio()
        $this->assertStringContainsString('x-data="articleStudio()"', $createContent);
        // It must have the JSON payload isolated in a script tag
        $this->assertStringContainsString('id="article-studio-config"', $createContent);
        $this->assertStringContainsString('tinymce.min.js', $createContent);
    }
}
