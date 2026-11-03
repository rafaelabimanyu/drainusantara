<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/**
 * Every media field must accept exactly what the optimizer can process.
 *
 * Regression guard for the drift where controllers declared "svg" and "gif" as
 * allowed uploads that ImageOptimizer then rejected after validation passed.
 */
class ImageUploadRulesTest extends TestCase
{
    use DatabaseMigrations;

    private string $publicRoot;

    private string $originalPublicRoot;

    protected function setUp(): void
    {
        parent::setUp();
        // Keep uploads out of the real public/ directory during tests.
        $this->originalPublicRoot = public_path();
        $this->publicRoot = sys_get_temp_dir().'/image-rules-'.bin2hex(random_bytes(8));
        \Illuminate\Support\Facades\File::ensureDirectoryExists($this->publicRoot);
        $this->app->usePublicPath($this->publicRoot);
    }

    protected function tearDown(): void
    {
        $this->app->usePublicPath($this->originalPublicRoot);
        \Illuminate\Support\Facades\File::deleteDirectory($this->publicRoot);
        parent::tearDown();
    }

    private function actingAsAdmin(): void
    {
        $this->actingAs(User::factory()->create());
    }

    private function jpeg(int $width = 400, int $height = 300): string
    {
        $image = imagecreatetruecolor($width, $height);
        imagefilledrectangle($image, 0, 0, $width - 1, $height - 1, imagecolorallocate($image, 12, 74, 110));
        ob_start();
        imagejpeg($image, null, 90);

        return (string) ob_get_clean();
    }

    public function test_svg_upload_is_rejected_by_the_service_form(): void
    {
        $this->actingAsAdmin();

        $this->post(route('admin.services.store'), [
            'name' => 'Layanan SVG',
            'image' => UploadedFile::fake()->createWithContent(
                'logo.svg',
                '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"></svg>',
            ),
        ])->assertSessionHasErrors('image');

        $this->assertSame(0, Service::count());
    }

    public function test_gif_upload_is_rejected_by_the_gallery_form(): void
    {
        $this->actingAsAdmin();
        $gif = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');

        $this->post(route('admin.galleries.store'), [
            'title' => 'Galeri GIF',
            'before_image' => UploadedFile::fake()->createWithContent('before.gif', $gif),
        ])->assertSessionHasErrors('before_image');

        $this->assertSame(0, Gallery::count());
    }

    public function test_upload_above_twenty_megabytes_is_rejected_by_the_rule(): void
    {
        $this->actingAsAdmin();
        $payload = $this->jpeg().str_repeat("\0", 20 * 1024 * 1024);

        $response = $this->post(route('admin.services.store'), [
            'name' => 'Layanan Kebesaran',
            'image' => UploadedFile::fake()->createWithContent('besar.jpg', $payload),
        ]);

        $response->assertSessionHasErrors(['image' => 'Ukuran gambar melebihi batas maksimal 20 MB.']);
        $this->assertSame(0, Service::count());
    }

    public function test_supported_image_still_saves_through_the_same_rule(): void
    {
        $this->actingAsAdmin();

        $this->post(route('admin.services.store'), [
            'name' => 'Layanan Valid',
            'image' => UploadedFile::fake()->createWithContent('foto.jpg', $this->jpeg()),
        ])->assertSessionHasNoErrors()->assertRedirect();

        $service = Service::firstOrFail();
        $this->assertStringEndsWith('.webp', $service->image);
    }
}