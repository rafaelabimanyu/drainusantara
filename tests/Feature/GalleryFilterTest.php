<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryFilterTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Service $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Drainusantara',
            'email' => 'admin@drainusantara.com',
            'password' => bcrypt('password123'),
        ]);

        $this->service = Service::create([
            'name' => 'Wastafel & Cuci Piring',
            'slug' => 'wastafel-cuci-piring',
            'price_starting_from' => 400000,
            'is_active' => true,
        ]);
    }

    public function test_gallery_page_renders_single_photo_documentation_and_sector_filter_tabs(): void
    {
        Gallery::create([
            'title' => 'Pelancaran Pipa Sink Resto F&B',
            'category' => 'b2b',
            'service_id' => $this->service->id,
            'image' => 'https://images.unsplash.com/photo-1585704032915-c3400ca199e7',
            'description' => 'Pembersihan pipa lemak tanpa bongkar keramik.',
            'is_active' => true,
            'order' => 1,
        ]);

        Gallery::create([
            'title' => 'Penarikan Sumbatan Kloset Rumah Tinggal',
            'category' => 'rumahan',
            'service_id' => $this->service->id,
            'image' => 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd',
            'description' => 'Penarikan benda asing dari leher angsa kloset.',
            'is_active' => true,
            'order' => 2,
        ]);

        $response = $this->get('/galeri');

        $response->assertStatus(200);
        $response->assertSee('Semua Sektor');
        $response->assertSee('Rumahan / Residensial');
        $response->assertSee('B2B / Komersial');
        $response->assertSee('Pelancaran Pipa Sink Resto F&B');
        $response->assertSee('Penarikan Sumbatan Kloset Rumah Tinggal');
        $response->assertSee('B2B Komersial');
        $response->assertSee('Rumahan Residensial');
        // Verify split Before/After is absent
        $response->assertDontSee('SEBELUM (MAMPET)');
        $response->assertDontSee('SESUDAH (PLONG)');
    }

    public function test_landing_page_renders_single_photo_documentation_with_category_filters(): void
    {
        Gallery::create([
            'title' => 'Proyek Khusus Dapur Kafe Komersial',
            'category' => 'b2b',
            'service_id' => $this->service->id,
            'image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f',
            'description' => 'Pembersihan saluran grease trap pipa restoran.',
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="dokumentasi"', false);
        $response->assertSee('id="galeri-before-after"', false);
        $response->assertSee('Hasil Pengerjaan Teknisi Drainusantara');
        $response->assertSee('Semua Sektor');
        $response->assertSee('Rumahan / Residensial');
        $response->assertSee('B2B / Komersial');
        $response->assertSee('Proyek Khusus Dapur Kafe Komersial');
        $response->assertSee('B2B Komersial');
    }

    public function test_admin_can_create_gallery_with_rumahan_or_b2b_category(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/galleries', [
            'title' => 'Pembersihan Pipa Hotel Bintang 4',
            'category' => 'b2b',
            'service_id' => $this->service->id,
            'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945',
            'description' => 'Pembersihan pipa saluran air kamar mandi hotel.',
            'order' => 1,
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/galleries');
        $this->assertDatabaseHas('galleries', [
            'title' => 'Pembersihan Pipa Hotel Bintang 4',
            'category' => 'b2b',
        ]);
    }

    public function test_admin_validation_rejects_invalid_gallery_category(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/galleries', [
            'title' => 'Pembersihan Pipa Invalid',
            'category' => 'industri_berat', // not in: rumahan, b2b
            'service_id' => $this->service->id,
            'description' => 'Deskripsi testing.',
            'order' => 1,
            'is_active' => 1,
        ]);

        $response->assertSessionHasErrors(['category']);
    }

    public function test_admin_can_update_gallery_category(): void
    {
        $gallery = Gallery::create([
            'title' => 'Saluran Rumah Tangga',
            'category' => 'rumahan',
            'service_id' => $this->service->id,
            'image' => 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd',
            'description' => 'Saluran pipa dapur hunian.',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/galleries/{$gallery->id}", [
            'title' => 'Saluran Diubah Menjadi Komersial',
            'category' => 'b2b',
            'service_id' => $this->service->id,
            'image' => 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd',
            'description' => 'Saluran pipa dapur resto.',
            'order' => 1,
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/galleries');
        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'category' => 'b2b',
            'title' => 'Saluran Diubah Menjadi Komersial',
        ]);
    }

    public function test_landing_page_shows_at_most_three_galleries_from_database(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Gallery::create([
                'title' => "Proyek Dokumentasi {$i}",
                'category' => $i % 2 === 0 ? 'b2b' : 'rumahan',
                'service_id' => $this->service->id,
                'image' => "https://images.unsplash.com/photo-{$i}",
                'description' => "Deskripsi proyek {$i}",
                'is_active' => true,
                'order' => $i,
            ]);
        }

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Proyek Dokumentasi 1');
        $response->assertSee('Proyek Dokumentasi 2');
        $response->assertSee('Proyek Dokumentasi 3');
        $response->assertDontSee('Proyek Dokumentasi 4');
        $response->assertDontSee('Proyek Dokumentasi 5');
    }

    public function test_landing_and_gallery_pages_show_empty_state_when_database_is_empty(): void
    {
        // 1. Landing page with 0 galleries
        $responseHome = $this->get('/');
        $responseHome->assertStatus(200);
        $responseHome->assertSee('Dokumentasi Belum Tersedia');
        // Ensure old hardcoded dummy title is never displayed
        $responseHome->assertDontSee('Pelancaran Pipa Wastafel Dapur Restoran');

        // 2. Gallery page with 0 galleries
        $responseGallery = $this->get('/galeri');
        $responseGallery->assertStatus(200);
        $responseGallery->assertSee('Dokumentasi Belum Tersedia');
        $responseGallery->assertDontSee('Semua Sektor (');
    }
}
