<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\{Article, Equipment, Gallery, Portfolio, Review, Service, Staff, User};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{File, Storage};
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class MediaOptimizationTest extends TestCase
{
    use DatabaseMigrations;

    private string $publicRoot;
    private string $originalPublicRoot;

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalPublicRoot = public_path();
        $this->publicRoot = sys_get_temp_dir().'/media-optimization-'.bin2hex(random_bytes(8));
        File::ensureDirectoryExists($this->publicRoot);
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

    public static function resources(): array
    {
        return [
            'service' => [Service::class, 'services', 'image', ['name' => 'Optimized service']],
            'equipment' => [Equipment::class, 'equipments', 'image', ['name' => 'Optimized equipment']],
            'staff' => [Staff::class, 'staff', 'photo', ['name' => 'Optimized staff']],
            'portfolio' => [Portfolio::class, 'portfolios', 'image', ['client_name' => 'Optimized portfolio']],
            'gallery' => [Gallery::class, 'galleries', 'image', ['title' => 'Optimized gallery']],
            'article' => [Article::class, 'articles', 'thumbnail', ['title' => 'Optimized article', 'content' => 'Content']],
            'review' => [Review::class, 'reviews', 'avatar', ['customer_name' => 'Optimized review', 'rating' => 5, 'comment' => 'Good']],
        ];
    }

    public function test_oversized_image_is_rejected_without_replacing_existing_media(): void
    {
        $old = '/images/services/old.jpg';
        File::ensureDirectoryExists(dirname($this->physical($old)));
        File::put($this->physical($old), 'old image');
        $record = Service::create(['name' => 'Old', 'slug' => 'old', 'image' => $old]);
        $image = imagecreatetruecolor(1, 1);
        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        $dimensions = pack('NN', 6000, 4000).substr($png, 24, 5);
        $png = substr($png, 0, 16).$dimensions.pack('N', crc32('IHDR'.$dimensions)).substr($png, 33);
        $this->putJson(route('admin.services.update', $record), [
            'name' => 'New', 'image' => UploadedFile::fake()->createWithContent('bomb.png', $png),
        ])->assertUnprocessable();
        $this->assertSame($old, $record->fresh()->image);
        $this->assertSame('old image', file_get_contents($this->physical($old)));
        $this->assertCount(1, File::files(dirname($this->physical($old))));
    }

    public static function orientations(): array
    {
        return [
            [1, [0, 1, 2, 3]], [2, [1, 0, 3, 2]], [3, [3, 2, 1, 0]], [4, [2, 3, 0, 1]],
            [5, [0, 2, 1, 3]], [6, [2, 0, 3, 1]], [7, [3, 1, 2, 0]], [8, [1, 3, 0, 2]],
        ];
    }

    #[DataProvider('orientations')]
    public function test_exif_orientation_is_applied_before_metadata_is_removed(int $orientation, array $corners): void
    {
        $colors = [[255, 0, 0], [0, 255, 0], [0, 0, 255], [255, 255, 255]];
        $image = imagecreatetruecolor(80, 40);
        foreach ($colors as $i => $rgb) {
            $x = ($i % 2) * 40;
            $y = intdiv($i, 2) * 20;
            imagefilledrectangle($image, $x, $y, $x + 39, $y + 19, imagecolorallocate($image, ...$rgb));
        }
        ob_start();
        imagejpeg($image, null, 100);
        $jpeg = ob_get_clean();
        $exif = "Exif\0\0II".pack('vVv', 42, 8, 1).pack('vvVv', 0x0112, 3, 1, $orientation)."\0\0".pack('V', 0);
        $jpeg = substr($jpeg, 0, 2)."\xff\xe1".pack('n', strlen($exif) + 2).$exif.substr($jpeg, 2);
        $url = (new \App\Support\MediaLifecycle)->upload(UploadedFile::fake()->createWithContent('camera.jpg', $jpeg), 'images/services');
        $result = imagecreatefromwebp($this->physical($url));
        [$width, $height] = $orientation >= 5 ? [40, 80] : [80, 40];
        $this->assertSame([$width, $height], [imagesx($result), imagesy($result)]);
        foreach ($corners as $i => $expected) {
            $rgb = imagecolorsforindex($result, imagecolorat($result, $i % 2 ? $width - 5 : 5, $i >= 2 ? $height - 5 : 5));
            foreach (['red', 'green', 'blue'] as $channel => $key) {
                $this->assertEqualsWithDelta($colors[$expected][$channel], $rgb[$key], 20);
            }
        }
    }

    public static function rasterFormats(): array
    {
        return [['png', false], ['png', true], ['webp', false], ['webp', true]];
    }

    #[DataProvider('rasterFormats')]
    public function test_small_transparent_images_keep_alpha_and_are_not_upscaled(string $format, bool $stored): void
    {
        $image = imagecreatetruecolor(80, 40);
        imagealphablending($image, false);
        imagesavealpha($image, true);
        imagefill($image, 0, 0, imagecolorallocatealpha($image, 255, 0, 0, 127));
        imagefilledrectangle($image, 20, 10, 60, 30, imagecolorallocatealpha($image, 0, 200, 0, 63));
        ob_start();
        $format === 'png' ? imagepng($image) : imagewebp($image);
        $source = ob_get_clean();
        $url = (new \App\Support\MediaLifecycle)->upload(UploadedFile::fake()->createWithContent('image.'.$format, $source), $stored ? 'articles' : 'images/services', $stored);
        $result = imagecreatefromwebp($this->physical($url));
        $this->assertSame([80, 40], [imagesx($result), imagesy($result)]);
        $this->assertSame(127, imagecolorsforindex($result, imagecolorat($result, 0, 0))['alpha']);
        $this->assertEqualsWithDelta(63, imagecolorsforindex($result, imagecolorat($result, 40, 20))['alpha'], 1);
    }

    public function test_animated_png_is_rejected_instead_of_silently_flattened(): void
    {
        $image = imagecreatetruecolor(1, 1);
        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        $chunk = 'acTL'.pack('NN', 2, 0);
        $png = substr($png, 0, 33).pack('N', 8).$chunk.pack('N', crc32($chunk)).substr($png, 33);
        $this->postJson(route('admin.services.store'), [
            'name' => 'Animated', 'image' => UploadedFile::fake()->createWithContent('animated.png', $png),
        ])->assertUnprocessable();
        $this->assertSame(0, Service::count());
        $this->assertCount(0, File::allFiles($this->publicRoot));
    }

    public function test_corrupt_gallery_image_rolls_back_earlier_optimized_upload(): void
    {
        $jpeg = $this->jpeg(80, 40);
        $scan = strpos($jpeg, "\xff\xda");
        $corrupt = substr($jpeg, 0, $scan + 2);
        $this->assertNotFalse(getimagesizefromstring($corrupt));
        $this->postJson(route('admin.galleries.store'), [
            'title' => 'Corrupt gallery',
            'before_image' => UploadedFile::fake()->createWithContent('before.jpg', $jpeg),
            'after_image' => UploadedFile::fake()->createWithContent('broken.jpg', $corrupt),
        ])->assertUnprocessable();
        $this->assertSame(0, Gallery::count());
        $this->assertCount(0, File::allFiles($this->publicRoot));
    }

    public function test_gif_is_rejected_explicitly_instead_of_losing_animation(): void
    {
        $this->postJson(route('admin.galleries.store'), [
            'title' => 'GIF', 'image' => UploadedFile::fake()->image('animation.gif'),
        ])->assertUnprocessable()->assertJsonValidationErrors('image');
        $this->assertSame(0, Gallery::count());
        $this->assertCount(0, File::allFiles($this->publicRoot));
    }

    public static function destinations(): array
    {
        return [[false], [true]];
    }

    #[DataProvider('destinations')]
    public function test_storage_failure_preserves_old_media_and_database(bool $stored): void
    {
        $old = $stored ? '/storage/articles/old.jpg' : '/images/services/old.jpg';
        $model = $stored ? Article::class : Service::class;
        $field = $stored ? 'thumbnail' : 'image';
        $directory = $stored ? 'articles' : 'images/services';
        $payload = $stored ? ['title' => 'Old', 'content' => 'Content'] : ['name' => 'Old'];
        $record = $model::create($payload + ['slug' => 'old', $field => $old]);
        // A regular file in place of a directory produces a real write failure, even as root.
        $target = dirname($this->physical($old));
        File::ensureDirectoryExists(dirname($target));
        File::put($target, 'blocked directory');
        $media = new \App\Support\MediaLifecycle;
        try {
            $media->run($record, function () use ($media, $record, $directory, $stored, $field): void {
                $url = $media->upload(UploadedFile::fake()->createWithContent('new.jpg', $this->jpeg(80, 40)), $directory, $stored);
                $media->save($record, [$field => $url]);
            });
            $this->fail('Expected media write failure.');
        } catch (\RuntimeException $exception) {
            $this->assertStringContainsString('Media upload', $exception->getMessage());
        }
        $this->assertSame($old, $record->fresh()->getAttribute($field));
        $this->assertSame('blocked directory', file_get_contents($target));
    }

    public function test_memory_budget_is_checked_before_decode(): void
    {
        $file = UploadedFile::fake()->createWithContent('photo.jpg', $this->jpeg());
        $oldLimit = ini_get('memory_limit');
        ini_set('memory_limit', (string) (memory_get_usage(true) + 16 * 1024 * 1024));
        try {
            (new \App\Support\MediaLifecycle)->upload($file, 'images/services');
            $this->fail('Expected insufficient-memory validation error.');
        } catch (\Illuminate\Validation\ValidationException $exception) {
            $this->assertStringContainsString('lebih kecil', $exception->getMessage());
            $this->assertCount(0, File::allFiles($this->publicRoot));
        } finally {
            ini_set('memory_limit', $oldLimit);
        }
    }

    public function test_missing_webp_encoder_fails_closed_without_saving_original(): void
    {
        $path = $this->publicRoot.'/source.jpg';
        File::put($path, $this->jpeg(80, 40));
        $script = 'require '.var_export(base_path('vendor/autoload.php'), true).'; '
            .'$file = new Illuminate\\Http\\UploadedFile('.var_export($path, true).', "source.jpg", "image/jpeg", null, true); '
            .'try { App\\Support\\ImageOptimizer::webp($file, "image"); exit(2); } '
            .'catch (RuntimeException $e) { echo $e->getMessage(); }';
        $process = new \Symfony\Component\Process\Process([PHP_BINARY, '-d', 'disable_functions=imagewebp', '-r', $script]);
        $process->mustRun();
        $this->assertStringContainsString('PHP GD', $process->getOutput());
        $this->assertCount(1, File::allFiles($this->publicRoot));
    }

    public function test_upload_byte_limit_is_enforced_before_decode(): void
    {
        $file = UploadedFile::fake()->createWithContent('photo.jpg', $this->jpeg(80, 40).str_repeat("\0", 20 * 1024 * 1024));
        try {
            (new \App\Support\MediaLifecycle)->upload($file, 'images/services');
            $this->fail('Expected oversized-file validation error.');
        } catch (\Illuminate\Validation\ValidationException $exception) {
            $this->assertStringContainsString('20 MB', $exception->getMessage());
            $this->assertCount(0, File::allFiles($this->publicRoot));
        }
    }

    public function test_plain_corruption_and_svg_are_not_written(): void
    {
        foreach (['broken.jpg' => 'not an image', 'image.svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"></svg>'] as $name => $contents) {
            try {
                (new \App\Support\MediaLifecycle)->upload(UploadedFile::fake()->createWithContent($name, $contents), 'images/services');
                $this->fail('Expected invalid-format validation error.');
            } catch (\Illuminate\Validation\ValidationException $exception) {
                $this->assertArrayHasKey('image', $exception->errors());
            }
        }
        $this->assertCount(0, File::allFiles($this->publicRoot));
    }

    private function jpeg(int $width = 2400, int $height = 1200): string
    {
        $image = imagecreatetruecolor($width, $height);
        for ($y = 0; $y < $height; $y += 8) {
            $color = imagecolorallocate($image, $y % 256, ($y * 3) % 256, ($y * 7) % 256);
            imagefilledrectangle($image, 0, $y, $width - 1, $y + 7, $color);
        }
        ob_start();
        imagejpeg($image, null, 95);
        return ob_get_clean();
    }

    private function physical(string $url): string
    {
        $path = ltrim((string) parse_url($url, PHP_URL_PATH), '/');
        return str_starts_with($path, 'storage/')
            ? Storage::disk('public')->path(substr($path, 8))
            : public_path($path);
    }

    private function assertOptimized(string $url, string $source, int $width = 1920, int $height = 960): void
    {
        $path = $this->physical($url);
        $this->assertStringEndsWith('.webp', $url);
        $this->assertFileExists($path);
        $size = getimagesize($path);
        $this->assertSame(IMAGETYPE_WEBP, $size[2]);
        $this->assertSame('image/webp', mime_content_type($path));
        $this->assertSame([$width, $height], [$size[0], $size[1]]);
        $this->assertLessThan(strlen($source), filesize($path));
        $this->assertNotFalse(imagecreatefromwebp($path));
    }

    #[DataProvider('resources')]
    public function test_create_and_replace_uploads_store_real_resized_webp(string $model, string $route, string $field, array $payload): void
    {
        $source = $this->jpeg();
        $this->post(route('admin.'.$route.'.store'), $payload + [$field => UploadedFile::fake()->createWithContent('photo.jpg', $source)])
            ->assertSessionHasNoErrors()->assertRedirect();
        $record = $model::firstOrFail();
        $old = $record->getAttribute($field);
        $this->assertOptimized($old, $source);

        $this->put(route('admin.'.$route.'.update', $record), $payload + [$field => UploadedFile::fake()->createWithContent('photo.jpg', $source)])
            ->assertSessionHasNoErrors()->assertRedirect();
        $new = $record->fresh()->getAttribute($field);
        $this->assertNotSame($old, $new);
        $this->assertOptimized($new, $source);
        $this->assertFileDoesNotExist($this->physical($old));
        $this->assertCount(1, File::files(dirname($this->physical($new))));
    }
}
