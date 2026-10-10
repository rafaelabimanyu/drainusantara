<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\{Article, Equipment, Gallery, Portfolio, Review, Service, Staff, User};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{DB, File, Storage};
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class MediaLifecycleTest extends TestCase
{
    use DatabaseMigrations;

    private string $publicRoot;
    private string $originalPublicRoot;

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalPublicRoot = public_path();
        $this->publicRoot = sys_get_temp_dir().'/media-lifecycle-'.bin2hex(random_bytes(8));
        File::makeDirectory($this->publicRoot, 0755, true);
        $this->app->usePublicPath($this->publicRoot);
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
    }

    protected function tearDown(): void
    {
        $this->app->usePublicPath($this->originalPublicRoot);
        File::deleteDirectory($this->publicRoot);
        parent::tearDown();
    }

    public static function media(): array
    {
        return [
            'service' => [Service::class, 'services', 'image', 'images/services', ['name' => 'Media test']],
            'equipment' => [Equipment::class, 'equipments', 'image', 'assets/TOOLKIT', ['name' => 'Media test']],
            'staff' => [Staff::class, 'staff', 'photo', 'images/staff', ['name' => 'Media test']],
            'portfolio' => [Portfolio::class, 'portfolios', 'image', 'images/portfolio', ['client_name' => 'Media test']],
            'gallery' => [Gallery::class, 'galleries', 'image', 'images/dokumentasi', ['title' => 'Media test']],
            'article' => [Article::class, 'articles', 'thumbnail', 'storage/articles', ['title' => 'Media test', 'content' => 'Content']],
            'review' => [Review::class, 'reviews', 'avatar', 'storage/reviews', ['customer_name' => 'Media test', 'rating' => 5, 'comment' => 'Good']],
        ];
    }

    private function putMedia(string $directory, string $name = 'old.jpg'): string
    {
        $path = $directory.'/'.$name;
        if (str_starts_with($directory, 'storage/')) {
            Storage::disk('public')->put(substr($path, 8), 'old contents');
        } else {
            File::ensureDirectoryExists(public_path($directory));
            File::put(public_path($path), 'old contents');
        }
        return '/'.$path;
    }

    private function physical(string $url): string
    {
        $path = ltrim((string) parse_url($url, PHP_URL_PATH), '/');
        return str_starts_with($path, 'storage/')
            ? Storage::disk('public')->path(substr($path, 8))
            : public_path($path);
    }

    private function record(string $model, string $field, string $path, array $payload): Model
    {
        return $model::create($payload + [$field => $path, 'slug' => 'media-'.bin2hex(random_bytes(6))]);
    }

    #[DataProvider('media')]
    public function test_failed_update_preserves_old_file_and_removes_new_upload(string $model, string $route, string $field, string $directory, array $payload): void
    {
        $old = $this->putMedia($directory);
        $record = $this->record($model, $field, $old, $payload);
        $model::updating(fn () => throw new \RuntimeException('forced write failure'));
        $this->put(route('admin.'.$route.'.update', $record), $payload + [$field => UploadedFile::fake()->image('old.jpg')])
            ->assertStatus(500);
        $this->assertSame($old, $record->fresh()->getAttribute($field));
        $this->assertSame('old contents', file_get_contents($this->physical($old)));
        $this->assertCount(1, File::files(dirname($this->physical($old))));
    }

    #[DataProvider('media')]
    public function test_failed_delete_preserves_file_and_record(string $model, string $route, string $field, string $directory, array $payload): void
    {
        $old = $this->putMedia($directory);
        $record = $this->record($model, $field, $old, $payload);
        $model::deleting(fn () => throw new \RuntimeException('forced delete failure'));
        $this->delete(route('admin.'.$route.'.destroy', $record))->assertStatus(500);
        $this->assertNotNull($record->fresh());
        $this->assertFileExists($this->physical($old));
    }

    #[DataProvider('media')]
    public function test_shared_media_survives_until_last_reference_deleted(string $model, string $route, string $field, string $directory, array $payload): void
    {
        $old = $this->putMedia($directory);
        $first = $this->record($model, $field, $old, $payload);
        $second = $this->record($model, $field, $old, $payload);
        $this->delete(route('admin.'.$route.'.destroy', $first))->assertRedirect();
        $this->assertFileExists($this->physical($old));
        $this->delete(route('admin.'.$route.'.destroy', $second))->assertRedirect();
        $this->assertFileDoesNotExist($this->physical($old));
    }

    #[DataProvider('media')]
    public function test_url_replacement_cleans_old_file_only_after_database_commit(string $model, string $route, string $field, string $directory, array $payload): void
    {
        $old = $this->putMedia($directory);
        $record = $this->record($model, $field, $old, $payload);
        DB::beginTransaction();
        $this->put(route('admin.'.$route.'.update', $record), $payload + [$field.'_url' => 'https://example.com/new.jpg'])
            ->assertSessionHasNoErrors()->assertRedirect();
        $this->assertFileExists($this->physical($old));
        DB::commit();
        $this->assertSame('https://example.com/new.jpg', $record->fresh()->getAttribute($field));
        $this->assertFileDoesNotExist($this->physical($old));
    }
}
