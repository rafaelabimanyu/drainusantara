<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
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

    public function test_landing_page_renders_b2b_portfolio_section(): void
    {
        Portfolio::create([
            'client_name' => "D'Cost Seafood",
            'client_type' => 'Restoran & F&B Komersial',
            'location' => 'Mall Kelapa Gading',
            'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4',
            'project_title' => 'Pengurasan Grease Trap',
            'description' => 'Pembersihan pipa lemak tanpa bongkar.',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Dipercaya Perusahaan F&amp;B, Perhotelan &amp; Gedung Bertingkat', false);
        $response->assertSee('D&#039;Cost Seafood', false);
        $response->assertSee('blur-[1px]', false);
        $response->assertSee('Bebas Bongkar');
    }

    public function test_unauthenticated_user_cannot_access_admin_portfolios(): void
    {
        $response = $this->get('/admin/portfolios');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_portfolios_index(): void
    {
        Portfolio::create([
            'client_name' => 'The Alana Hotel',
            'client_type' => 'Perhotelan',
            'location' => 'Sentul City',
            'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945',
            'project_title' => 'Pelancaran Saluran Kamar Mandi',
            'description' => 'Pengerjaan hening bergaransi.',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/portfolios');

        $response->assertStatus(200);
        $response->assertSee('Portofolio Klien B2B &amp; Komersial', false);
        $response->assertSee('The Alana Hotel');
        $response->assertSee('Tambah Klien B2B');
    }

    public function test_admin_can_view_create_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/portfolios/create');

        $response->assertStatus(200);
        $response->assertSee('Tambah Portofolio Klien B2B');
        $response->assertSee('client_name');
    }

    public function test_admin_can_store_portfolio(): void
    {
        $data = [
            'client_name' => 'Starbucks Reserve',
            'client_type' => 'Kafe & Restoran',
            'location' => 'Grand Indonesia, Jakarta Pusat',
            'project_title' => 'Pelancaran Pipa Wastafel Barista',
            'description' => 'Pembersihan endapan ampas kopi dan lemak susu.',
            'image_url' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb',
            'order' => 2,
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/portfolios', $data);

        $response->assertRedirect('/admin/portfolios');
        $this->assertDatabaseHas('portfolios', [
            'client_name' => 'Starbucks Reserve',
            'location' => 'Grand Indonesia, Jakarta Pusat',
        ]);
    }

    public function test_admin_can_view_edit_form(): void
    {
        $portfolio = Portfolio::create([
            'client_name' => 'Living World Mall',
            'client_type' => 'Mall',
            'location' => 'Alam Sutera',
            'project_title' => 'Pembersihan Manhole',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/portfolios/{$portfolio->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Portofolio Klien B2B');
        $response->assertSee('Living World Mall');
    }

    public function test_admin_can_update_portfolio(): void
    {
        $portfolio = Portfolio::create([
            'client_name' => 'Menara Sudirman',
            'client_type' => 'Perkantoran',
            'location' => 'SCBD',
            'project_title' => 'Talang Rooftop',
            'order' => 1,
            'is_active' => true,
        ]);

        $updateData = [
            'client_name' => 'Menara Sudirman SCBD',
            'client_type' => 'Gedung Perkantoran',
            'location' => 'SCBD, Jakarta Selatan',
            'project_title' => 'Pipa Talang Air Hujan Rooftop 18 Lantai',
            'description' => 'Pembersihan lumut dak beton tuntas.',
            'order' => 3,
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->admin)->put("/admin/portfolios/{$portfolio->id}", $updateData);

        $response->assertRedirect('/admin/portfolios');
        $this->assertDatabaseHas('portfolios', [
            'id' => $portfolio->id,
            'client_name' => 'Menara Sudirman SCBD',
            'order' => 3,
        ]);
    }

    public function test_admin_can_delete_portfolio(): void
    {
        $portfolio = Portfolio::create([
            'client_name' => 'Klien Untuk Dihapus',
            'client_type' => 'Testing',
            'order' => 99,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/portfolios/{$portfolio->id}");

        $response->assertRedirect('/admin/portfolios');
        $this->assertDatabaseMissing('portfolios', [
            'id' => $portfolio->id,
        ]);
    }
}
