<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryEnhancementsTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'email' => 'admin@drainusantara.id',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_gallery_model_supports_new_fields_and_accessors(): void
    {
        $gallery = Gallery::create([
            'title' => 'Pelancaran Pipa Wastafel Dapur Resto',
            'slug' => 'pelancaran-pipa-wastafel-dapur-resto',
            'category' => 'fnb',
            'location' => 'Kelapa Gading, Jakarta Utara',
            'drain_type' => 'Pipa Wastafel Cuci Piring 2 Inch',
            'method' => 'Spiral Rotary Ridgid K-50',
            'price' => 450000,
            'duration' => '45 Menit',
            'diagnosis' => 'Endapan minyak beku tebal sepanjang pipa.',
            'before_image' => '/images/before.webp',
            'after_image' => '/images/after.webp',
            'image' => '/images/main.webp',
            'description' => 'Pembersihan pipa pembuangan dari endapan minyak.',
            'is_active' => true,
        ]);

        $this->assertEquals('Restoran & Kafe (FnB)', $gallery->category_label);
        $this->assertEquals('Rp 450.000', $gallery->formatted_price);
        $this->assertTrue($gallery->hasBeforeAfter());
        $this->assertTrue($gallery->isB2b());
        $this->assertFalse($gallery->isRumahan());

        $singleImageGallery = new Gallery([
            'before_image' => null,
            'after_image' => null,
            'image' => '/images/single.webp',
        ]);
        $this->assertFalse($singleImageGallery->hasBeforeAfter());
        $this->assertEquals('/images/single.webp', $singleImageGallery->main_image);
    }

    public function test_admin_can_create_gallery_with_new_fields(): void
    {
        $this->actingAs($this->adminUser);

        $service = Service::create([
            'name' => 'Wastafel Cuci Piring Mampet',
            'slug' => 'wastafel-cuci-piring-mampet',
            'is_active' => true,
        ]);

        $postData = [
            'title' => 'Kuras Perangkap Lemak Restoran Seafood',
            'category' => 'fnb',
            'service_id' => $service->id,
            'location' => 'Muara Karang, Jakarta Utara',
            'drain_type' => 'Grease Trap Stainless 60L',
            'method' => 'Pembersihan Baffle & Kuras Lemak Mekanis',
            'price' => 500000,
            'duration' => '1 Jam',
            'diagnosis' => 'Kerak minyak jenuh beku dan ampas makanan menumpuk.',
            'description' => 'Pembersihan berkala perangkap lemak restoran seafood.',
            'is_active' => '1',
        ];

        $response = $this->post(route('admin.galleries.store'), $postData);

        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseHas('galleries', [
            'title' => 'Kuras Perangkap Lemak Restoran Seafood',
            'category' => 'fnb',
            'location' => 'Muara Karang, Jakarta Utara',
            'drain_type' => 'Grease Trap Stainless 60L',
            'method' => 'Pembersihan Baffle & Kuras Lemak Mekanis',
            'price' => 500000,
            'duration' => '1 Jam',
            'diagnosis' => 'Kerak minyak jenuh beku dan ampas makanan menumpuk.',
        ]);
    }

    public function test_admin_can_update_gallery_with_new_fields(): void
    {
        $this->actingAs($this->adminUser);

        $gallery = Gallery::create([
            'title' => 'Pipa Talang Air Ruko',
            'slug' => 'pipa-talang-air-ruko',
            'category' => 'ruko',
            'location' => 'Tangerang',
            'price' => 300000,
            'is_active' => true,
        ]);

        $updateData = [
            'title' => 'Pipa Talang Air Ruko 3 Lantai',
            'category' => 'ruko',
            'location' => 'Gading Serpong, Tangerang',
            'drain_type' => 'Pipa Talang Vertikal 3 Inch',
            'method' => 'Spiral Baja Ridgid K-60',
            'price' => 350000,
            'duration' => '45 Menit',
            'diagnosis' => 'Dedaunan kering dan endapan lumut menyumbat belokan bawah.',
            'description' => 'Pembersihan pipa talang vertikal ruko 3 lantai.',
            'is_active' => '1',
        ];

        $response = $this->put(route('admin.galleries.update', $gallery), $updateData);

        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'title' => 'Pipa Talang Air Ruko 3 Lantai',
            'price' => 350000,
            'drain_type' => 'Pipa Talang Vertikal 3 Inch',
            'method' => 'Spiral Baja Ridgid K-60',
        ]);
    }

    public function test_frontend_gallery_page_renders_hero_search_and_categories(): void
    {
        Gallery::create([
            'title' => 'Pelancaran Pipa Wastafel Dapur Restoran',
            'slug' => 'pelancaran-pipa-wastafel-dapur-restoran',
            'category' => 'fnb',
            'location' => 'Kelapa Gading, Jakarta Utara',
            'drain_type' => 'Pipa Wastafel 2 Inch',
            'method' => 'Spiral Rotary Ridgid K-50',
            'price' => 450000,
            'duration' => '45 Menit',
            'diagnosis' => 'Endapan lemak beku.',
            'image' => '/images/foto.webp',
            'description' => 'Pembersihan saluran sink restoran dari minyak beku.',
            'is_active' => true,
        ]);

        $response = $this->get(route('gallery'));

        $response->assertStatus(200);
        $response->assertSee('Galeri Hasil Pengerjaan');
        $response->assertSee('Tanpa Bongkar Keramik');
        $response->assertSee('Garansi Nota 30 Hari');
        $response->assertSee('Tuntas Cepat');
        $response->assertSee('Bebas Bahan Kimia');
        $response->assertSee('Restoran &amp; Kafe (FnB)', false);
        $response->assertSee('Kelapa Gading, Jakarta Utara');
        $response->assertSee('Pelancaran Pipa Wastafel Dapur Restoran');
        $response->assertSee('searchQuery');
    }

    public function test_frontend_case_study_detail_page_shows_before_after_when_available(): void
    {
        $service = Service::create([
            'name' => 'Floor Drain Kamar Mandi',
            'slug' => 'floor-drain-kamar-mandi',
            'is_active' => true,
        ]);

        $gallery = Gallery::create([
            'title' => 'Pelancaran Saluran Floor Drain Kamar Mandi',
            'slug' => 'pelancaran-saluran-floor-drain-kamar-mandi',
            'category' => 'rumahan',
            'service_id' => $service->id,
            'location' => 'BSD City, Tangerang Selatan',
            'drain_type' => 'Floor Drain 2.5 Inch',
            'method' => 'Spiral Rotary Ridgid K-50',
            'price' => 300000,
            'duration' => '30 Menit',
            'diagnosis' => 'Anyaman rambut dan kerak busa sabun tebal.',
            'before_image' => '/images/before.webp',
            'after_image' => '/images/after.webp',
            'description' => 'Penanganan saluran kamar mandi mampet di BSD.',
            'is_active' => true,
        ]);

        $response = $this->get(route('case-study.show', $gallery->slug));

        $response->assertStatus(200);
        $response->assertSee('Kondisi Awal (Tersumbat)');
        $response->assertSee('Hasil Akhir (Lancar)');
        $response->assertSee('Lembar Data Teknis &amp; Diagnosis Pengerjaan', false);
        $response->assertSee('Spiral Rotary Ridgid K-50');
        $response->assertSee('Floor Drain 2.5 Inch');
        $response->assertSee('Floor Drain Kamar Mandi');
        $response->assertSee('/#layanan');
        $response->assertSee('Rp 300.000');
        $response->assertSee('30 Menit');
        $response->assertSee('BSD City, Tangerang Selatan');
        $response->assertSee('Anyaman rambut dan kerak busa sabun tebal.');
    }

    public function test_frontend_case_study_detail_page_shows_single_photo_without_empty_placeholders(): void
    {
        $gallery = Gallery::create([
            'title' => 'Inspeksi Kamera CCTV Pipa Bawah Tanah Ruko',
            'slug' => 'inspeksi-kamera-cctv-pipa-bawah-tanah-ruko',
            'category' => 'ruko',
            'location' => 'Simpang Lima, Kota Semarang',
            'drain_type' => 'Pipa Bawah Tanah 4 Inch',
            'method' => 'Kamera Endoskopi CCTV IP68',
            'price' => 650000,
            'duration' => '1.5 Jam',
            'diagnosis' => 'Akar pohon bintaro menembus sambungan pipa.',
            'before_image' => null,
            'after_image' => null,
            'image' => '/images/cctv-single.webp',
            'description' => 'Inspeksi visual pipa saluran air kotor ruko.',
            'is_active' => true,
        ]);

        $response = $this->get(route('case-study.show', $gallery->slug));

        $response->assertStatus(200);
        $response->assertSee('Foto Dokumentasi Pelaksanaan Teknis di Lapangan');
        $response->assertDontSee('Foto sebelum pengerjaan belum tersedia');
        $response->assertDontSee('Foto sesudah pengerjaan belum tersedia');
        $response->assertSee('Kamera Endoskopi CCTV IP68');
        $response->assertSee('Pipa Bawah Tanah 4 Inch');
        $response->assertSee('Rp 650.000');
        $response->assertSee('1.5 Jam');
        $response->assertSee('Simpang Lima, Kota Semarang');
        $response->assertSee('Akar pohon bintaro menembus sambungan pipa.');
    }

    public function test_frontend_case_study_detail_page_renders_mobile_navbar_dock(): void
    {
        $gallery = Gallery::create([
            'title' => 'Pembersihan Pipa Saluran Dapur Rumah',
            'slug' => 'pembersihan-pipa-saluran-dapur-rumah',
            'category' => 'rumahan',
            'location' => 'Jakarta Selatan',
            'is_active' => true,
        ]);

        $response = $this->get(route('case-study.show', $gallery->slug));

        $response->assertStatus(200);
        $response->assertDontSee('.mobile-nav-dock { display: none !important; }', false);
        $response->assertSee('mobile-nav-dock', false);
        $response->assertSee('Navigasi Mobile Floating Dock');
        $response->assertSee('Area - Cari Wilayah');
        $response->assertSee('Menu Lengkap');
    }

    public function test_frontend_case_study_detail_page_renders_related_case_studies_carousel(): void
    {
        $main = Gallery::create([
            'title' => 'Pembersihan Pipa Saluran Dapur Rumah',
            'slug' => 'pembersihan-pipa-saluran-dapur-rumah',
            'category' => 'rumahan',
            'location' => 'Jakarta Selatan',
            'is_active' => true,
        ]);

        $related = Gallery::create([
            'title' => 'Pembersihan Pipa Kamar Mandi Rumah',
            'slug' => 'pembersihan-pipa-kamar-mandi-rumah',
            'category' => 'rumahan',
            'location' => 'Jakarta Barat',
            'is_active' => true,
        ]);

        $response = $this->get(route('case-study.show', $main->slug));
        $response->assertStatus(200);
        $response->assertSee('Studi Kasus Lainnya');
        $response->assertSee('snap-x snap-mandatory', false);
        $response->assertSee('Pembersihan Pipa Kamar Mandi Rumah');
    }
}

