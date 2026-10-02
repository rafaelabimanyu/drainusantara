<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminServiceTest extends TestCase
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

    public function test_admin_can_view_services_index(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.services.index'));
        $response->assertStatus(200);
        $response->assertSee('Katalog Layanan');
    }

    public function test_admin_can_upload_service_image_to_public_images_services(): void
    {
        $fakeImage = UploadedFile::fake()->image('custom-layanan-test.webp', 400, 300);

        $response = $this->actingAs($this->adminUser)->post(route('admin.services.store'), [
            'name' => 'Layanan Pipa Wastafel Unik',
            'price_starting_from' => 350000,
            'short_description' => 'Deskripsi layanan tes',
            'is_active' => 1,
            'image' => $fakeImage,
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', [
            'name' => 'Layanan Pipa Wastafel Unik',
            'image' => '/images/services/custom-layanan-test.webp',
        ]);

        $savedFilePath = public_path('images/services/custom-layanan-test.webp');
        $this->assertFileExists($savedFilePath);

        // Cleanup
        if (file_exists($savedFilePath)) {
            @unlink($savedFilePath);
        }
    }

    public function test_admin_can_update_service_image_and_old_file_is_cleaned_up(): void
    {
        // First create a service with an initial uploaded image
        $initialImage = UploadedFile::fake()->image('service-old-test.webp', 400, 300);
        $this->actingAs($this->adminUser)->post(route('admin.services.store'), [
            'name' => 'Layanan Ganti Foto',
            'price_starting_from' => 300000,
            'image' => $initialImage,
        ]);

        $service = Service::where('name', 'Layanan Ganti Foto')->firstOrFail();
        $oldPath = public_path('images/services/service-old-test.webp');
        $this->assertFileExists($oldPath);

        // Now update with a new image
        $newImage = UploadedFile::fake()->image('service-new-test.webp', 400, 300);
        $response = $this->actingAs($this->adminUser)->put(route('admin.services.update', $service), [
            'name' => 'Layanan Ganti Foto',
            'price_starting_from' => 350000,
            'image' => $newImage,
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'image' => '/images/services/service-new-test.webp',
        ]);

        $newPath = public_path('images/services/service-new-test.webp');
        $this->assertFileExists($newPath);
        // Old custom file should have been cleaned up
        $this->assertFileDoesNotExist($oldPath);

        // Cleanup new file
        if (file_exists($newPath)) {
            @unlink($newPath);
        }
    }
}
