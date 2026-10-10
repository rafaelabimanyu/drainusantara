<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminEquipmentTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'email' => 'admin@drainusantara.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_admin_can_view_equipments_index(): void
    {
        $this->actingAs($this->adminUser);

        Equipment::create([
            'name' => 'Mesin Spiral Rotary Ridgid K-50',
            'category' => 'Mesin Utama',
            'badge' => '100% Mekanis',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/admin/equipments');
        $response->assertStatus(200);
        $response->assertSee('Peralatan &amp; Mesin Armada', false);
        $response->assertSee('Mesin Spiral Rotary Ridgid K-50');
    }

    public function test_admin_can_create_equipment_with_image_upload(): void
    {
        $this->actingAs($this->adminUser);

        $testFile = UploadedFile::fake()->image('mesin-test-rooter.jpg', 600, 400);

        $response = $this->post('/admin/equipments', [
            'name' => 'Mesin Drain Rooter Pro 400',
            'category' => 'Mesin Utama',
            'badge' => 'Torsi Tinggi',
            'image' => $testFile,
            'short_description' => 'Mesin pemutar spiral baja torsi tinggi.',
            'specs' => "Jangkauan 30 Meter\nPipa 4 Inci",
            'order' => 2,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/equipments');
        $equipment = Equipment::where('name', 'Mesin Drain Rooter Pro 400')->first();
        $this->assertNotNull($equipment);
        $this->assertStringContainsString('/assets/TOOLKIT/', $equipment->image);
        $this->assertFileExists(public_path(ltrim($equipment->image, '/')));

        // Clean up
        @unlink(public_path(ltrim($equipment->image, '/')));
    }

    public function test_admin_equipment_destroy_deletes_image_file(): void
    {
        $this->actingAs($this->adminUser);

        $testFile = UploadedFile::fake()->image('alat-akan-dihapus.jpg', 600, 400);

        $response = $this->post('/admin/equipments', [
            'name' => 'Alat Untuk Dihapus',
            'image' => $testFile,
        ]);

        $response->assertRedirect('/admin/equipments');
        $equipment = Equipment::where('name', 'Alat Untuk Dihapus')->first();
        $this->assertNotNull($equipment);
        $this->assertFileExists(public_path(ltrim($equipment->image, '/')));

        // Hapus via CMS
        $deleteResponse = $this->delete("/admin/equipments/{$equipment->id}");
        $deleteResponse->assertRedirect('/admin/equipments');
        $this->assertDatabaseMissing('equipments', ['id' => $equipment->id]);

        // Verifikasi file fisik di public/assets/TOOLKIT otomatis terhapus
        $this->assertFileDoesNotExist(public_path(ltrim($equipment->image, '/')));
    }

    public function test_admin_equipment_update_replaces_old_image(): void
    {
        $this->actingAs($this->adminUser);

        $fileOld = UploadedFile::fake()->image('gambar-lama-alat.jpg', 600, 400);
        $this->post('/admin/equipments', [
            'name' => 'Unit Kamera Diagnosa',
            'image' => $fileOld,
        ]);

        $equipment = Equipment::where('name', 'Unit Kamera Diagnosa')->first();
        $this->assertNotNull($equipment);
        $oldPath = public_path(ltrim($equipment->image, '/'));
        $this->assertFileExists($oldPath);

        // Update dengan file baru
        $fileNew = UploadedFile::fake()->image('gambar-baru-alat.jpg', 600, 400);
        $updateResponse = $this->put("/admin/equipments/{$equipment->id}", [
            'name' => 'Unit Kamera Diagnosa Updated',
            'image' => $fileNew,
        ]);

        $updateResponse->assertRedirect('/admin/equipments');
        $this->assertFileDoesNotExist($oldPath);
        $this->assertFileExists(public_path(ltrim($equipment->fresh()->image, '/')));

        // Clean up
        @unlink(public_path(ltrim($equipment->fresh()->image, '/')));
    }
}
