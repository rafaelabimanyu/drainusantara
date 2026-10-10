<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Service;
use App\Models\User;
use App\Support\MediaPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CmsSecurityRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_unchecked_article_is_saved_as_draft_on_create_and_update(): void
    {
        $this->actingAs(User::factory()->create());
        $this->post(route('admin.articles.store'), [
            'title' => 'Artikel Draft', 'content' => 'Isi artikel',
        ])->assertRedirect(route('admin.articles.index'));

        $article = Article::where('title', 'Artikel Draft')->firstOrFail();
        $this->assertFalse($article->is_published);
        $this->assertNull($article->published_at);

        $article->update(['is_published' => true, 'published_at' => now()]);
        $this->put(route('admin.articles.update', $article), [
            'title' => 'Artikel Draft', 'content' => 'Isi artikel',
        ])->assertRedirect(route('admin.articles.index'));
        $this->assertFalse($article->fresh()->is_published);
        $this->assertNull($article->fresh()->published_at);
    }

    public function test_unchecked_service_is_inactive_on_create_and_update(): void
    {
        $this->actingAs(User::factory()->create());
        $this->post(route('admin.services.store'), ['name' => 'Layanan Nonaktif'])
            ->assertRedirect(route('admin.services.index'));
        $service = Service::where('name', 'Layanan Nonaktif')->firstOrFail();
        $this->assertFalse($service->is_active);

        $service->update(['is_active' => true]);
        $this->put(route('admin.services.update', $service), ['name' => 'Layanan Nonaktif'])
            ->assertRedirect(route('admin.services.index'));
        $this->assertFalse($service->fresh()->is_active);
    }

    public function test_media_path_resolution_rejects_traversal_and_symlinks_without_deleting(): void
    {
        $folder = 'images/services';
        $this->assertNull(MediaPath::resolve('/images/services/../../outside.webp', $folder));
        $this->assertNull(MediaPath::resolve('/images/services/../portfolio/photo.webp', $folder));
        $this->assertNull(MediaPath::resolve('/images/services/./photo.webp', $folder));
        $this->assertNull(MediaPath::resolve('/images/services/not-found.webp', $folder));

        $root = public_path($folder);
        $outside = public_path('media-path-outside-test.webp');
        $link = $root . '/media-path-link-test.webp';
        file_put_contents($outside, 'untouched');
        try {
            if (function_exists('symlink') && symlink($outside, $link)) {
                $this->assertNull(MediaPath::resolve('/images/services/media-path-link-test.webp', $folder));
            }
            $this->assertNull(MediaPath::resolve('/images/services/../media-path-outside-test.webp', $folder));
            $this->assertSame('untouched', file_get_contents($outside));
        } finally {
            if (is_link($link)) {
                unlink($link);
            }
            unlink($outside);
        }
    }

    public function test_service_delete_does_not_remove_file_outside_media_directory(): void
    {
        $this->actingAs(User::factory()->create());
        $outside = public_path('media-path-outside-test.webp');
        file_put_contents($outside, 'untouched');
        try {
            $service = Service::create([
                'name' => 'Traversal', 'slug' => 'traversal',
                'image' => '/images/services/../../media-path-outside-test.webp',
                'is_active' => true,
            ]);
            $this->delete(route('admin.services.destroy', $service))
                ->assertRedirect(route('admin.services.index'));
            $this->assertSame('untouched', file_get_contents($outside));
        } finally {
            unlink($outside);
        }
    }

    public function test_existing_admin_password_is_unchanged_by_content_seeder(): void
    {
        $user = User::create([
            'name' => 'Drainusantara@admin',
            'email' => 'Drainusantara@admin',
            'password' => Hash::make('password-yang-sudah-diganti'),
        ]);
        $oldHash = $user->password;

        $this->seed(\DatabaseSeeder::class);

        $this->assertSame($oldHash, $user->fresh()->password);
        $this->assertTrue(Hash::check('password-yang-sudah-diganti', $user->fresh()->password));
    }

    public function test_image_preview_serializes_untrusted_url_as_javascript_data(): void
    {
        $payload = "/images/services/';alert(1);//.webp";
        \Illuminate\Support\Facades\View::share('errors', new \Illuminate\Support\ViewErrorBag);
        $html = view('components.form.image-upload', ['current' => $payload])->render();
        $this->assertStringNotContainsString("';alert(1);//", $html);
        $this->assertStringContainsString('\\u0027', $html);

        $this->actingAs(User::factory()->create());
        $service = Service::create(['name' => 'Preview Test', 'slug' => 'preview-test', 'image' => $payload]);
        $html = $this->get(route('admin.services.edit', $service))->assertOk()->getContent();
        $this->assertStringNotContainsString("';alert(1);//", $html);
        $this->assertStringContainsString('\\u0027', $html);
    }
}
