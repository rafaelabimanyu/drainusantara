<?php

namespace Tests\Feature;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StaffTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Drainusantara',
            'email' => 'admin@drainusantara.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_unauthenticated_user_cannot_access_staff_admin(): void
    {
        $response = $this->get('/admin/staff');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_staff_index(): void
    {
        Staff::create([
            'name' => 'Agus Santoso',
            'role' => 'Teknisi Senior Rooter',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/staff');

        $response->assertStatus(200);
        $response->assertSee('Staff &amp; Teknisi Lapangan', false);
        $response->assertSee('Agus Santoso');
        $response->assertSee('Tambah Staff');
    }

    public function test_admin_can_view_create_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/staff/create');

        $response->assertStatus(200);
        $response->assertSee('Tambah Staff &amp; Teknisi Lapangan', false);
        $response->assertSee('name');
    }

    public function test_admin_can_store_staff(): void
    {
        $data = [
            'name' => 'Fajar Nugraha',
            'role' => 'Teknisi Hydro-Jetting Pipa',
            'initials' => 'FN',
            'order' => 1,
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/staff', $data);

        $response->assertRedirect('/admin/staff');
        $this->assertDatabaseHas('staff', [
            'name' => 'Fajar Nugraha',
            'role' => 'Teknisi Hydro-Jetting Pipa',
            'initials' => 'FN',
        ]);
    }

    public function test_admin_can_view_edit_form(): void
    {
        $staff = Staff::create([
            'name' => 'Eko Prasetyo',
            'role' => 'Teknisi CCTV Pipa',
            'order' => 2,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/staff/{$staff->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Staff: Eko Prasetyo');
        $response->assertSee('Eko Prasetyo');
    }

    public function test_admin_can_update_staff(): void
    {
        $staff = Staff::create([
            'name' => 'Eko Prasetyo',
            'role' => 'Teknisi CCTV Pipa',
            'order' => 2,
            'is_active' => true,
        ]);

        $updateData = [
            'name' => 'Eko Prasetyo S.T.',
            'role' => 'Lead Technician CCTV Pipa',
            'order' => 3,
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->admin)->put("/admin/staff/{$staff->id}", $updateData);

        $response->assertRedirect('/admin/staff');
        $this->assertDatabaseHas('staff', [
            'id' => $staff->id,
            'name' => 'Eko Prasetyo S.T.',
            'role' => 'Lead Technician CCTV Pipa',
        ]);
    }

    public function test_admin_can_delete_staff(): void
    {
        $staff = Staff::create([
            'name' => 'Staff Uji Hapus',
            'role' => 'Percobaan',
            'order' => 99,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/staff/{$staff->id}");

        $response->assertRedirect('/admin/staff');
        $this->assertDatabaseMissing('staff', [
            'id' => $staff->id,
        ]);
    }

    public function test_admin_can_upload_staff_photo(): void
    {
        $photo = UploadedFile::fake()->image('teknisi-fajar.webp', 400, 400);

        $response = $this->actingAs($this->admin)->post('/admin/staff', [
            'name' => 'Fajar Teknisi',
            'photo' => $photo,
        ]);

        $response->assertRedirect('/admin/staff');
        $staff = Staff::where('name', 'Fajar Teknisi')->first();
        $this->assertNotNull($staff);
        $this->assertNotNull($staff->photo);
        $this->assertStringContainsString('teknisi-fajar.webp', $staff->photo);

        $relativePath = ltrim(parse_url($staff->photo, PHP_URL_PATH), '/');
        $this->assertFileExists(public_path($relativePath));

        // Clean up
        @unlink(public_path($relativePath));
    }

    public function test_tentang_kami_staff_redirects_to_profil_section(): void
    {
        $response = $this->get('/tentang-kami/staff');
        $response->assertRedirect('/tentang-kami/profil#staff-kami');
    }

    public function test_profil_page_renders_dynamic_staff_from_database(): void
    {
        Staff::create([
            'name' => 'Joko Susilo',
            'role' => 'Spesialis Spiral Baja',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/tentang-kami/profil');
        $response->assertStatus(200);
        $response->assertSee('Staff &amp; Teknisi Lapangan Siaga', false);
        $response->assertSee('Joko Susilo');
    }
}
