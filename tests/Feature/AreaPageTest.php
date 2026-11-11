<?php

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_area_page_renders_with_seeded_coverage_area(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'meta_title' => 'Jasa Saluran Mampet di Tebet, Jakarta Selatan - Drainusantara Bergaransi',
            'meta_description' => 'Jasa pelancaran pipa wastafel di Tebet.',
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Wastafel Mampet',
            'slug' => 'wastafel-mampet',
            'price_starting_from' => 400000,
            'is_active' => true,
        ]);

        $response = $this->get('/area/jakarta-selatan/tebet');

        $response->assertStatus(200);
        $response->assertSee('Jasa Saluran Pipa Mampet', false);
        $response->assertSee('Tebet');
        $response->assertSee('Jakarta Selatan');
        $response->assertSee('Panggil Teknisi Sekarang');
        $response->assertSee('Metode Tanpa Bongkar');
        $response->assertSee('Mulai Rp 400.000');
    }

    public function test_area_page_renders_valid_unseeded_district_without_persisting_it(): void
    {
        $response = $this->get('/area/semarang/banyumanik');

        $response->assertStatus(200);
        $response->assertSee('Banyumanik');
        $response->assertSee('Semarang');
        $response->assertSee('Panggil Teknisi Sekarang');
        $response->assertSee('Mulai Rp 400.000');
        $this->assertDatabaseCount('coverage_areas', 0);
    }

    public function test_area_page_resolves_aliases_and_regions(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'meta_title' => 'Jasa Saluran Mampet di Tebet, Jakarta Selatan - Drainusantara Bergaransi',
            'meta_description' => 'Jasa pelancaran pipa wastafel di Tebet.',
            'is_active' => true,
        ]);

        CoverageArea::create([
            'city' => 'Depok & Cinere',
            'district' => 'Cinere',
            'slug' => 'depok-cinere-cinere',
            'meta_title' => 'Jasa Saluran Mampet di Cinere, Depok & Cinere - Drainusantara Bergaransi',
            'is_active' => true,
        ]);

        // Alias jaksel di-301 ke slug kanonik (hindari duplicate content)
        $responseJaksel = $this->get('/area/jaksel/tebet');
        $responseJaksel->assertStatus(301);
        $responseJaksel->assertRedirect('/area/jakarta-selatan/tebet');

        $canonical = $this->get('/area/jakarta-selatan/tebet');
        $canonical->assertStatus(200);
        $canonical->assertSee('Jakarta Selatan');
        $canonical->assertSee('Tebet');

        // Test Depok & Cinere
        $responseDepok = $this->get('/area/depok-cinere/cinere');
        $responseDepok->assertStatus(200);
        $responseDepok->assertSee('Depok &amp; Cinere', false);
        $responseDepok->assertSee('Cinere');

        // Test Bandar Lampung
        $responseLampung = $this->get('/area/bandar-lampung/kedaton');
        $responseLampung->assertStatus(200);
        $responseLampung->assertSee('Bandar Lampung');
        $responseLampung->assertSee('Kedaton');
    }

    public function test_province_page_renders_with_new_sections_order(): void
    {
        $response = $this->get('/area/provinsi/dki-jakarta');

        $response->assertStatus(200);
        $response->assertSee('Jasa Saluran Pipa Mampet');
        $response->assertSee('DKI Jakarta');

        // Section 1: Layanan
        $response->assertSee('id="layanan"', false);
        $response->assertSee('Layanan Saluran Pipa Mampet di DKI Jakarta');

        // Section 2: Dokumentasi
        $response->assertSee('id="dokumentasi"', false);
        $response->assertSee('Hasil Pengerjaan Teknisi di Lapangan');

        // Section 3: Peralatan
        $response->assertSee('id="peralatan-armada"', false);
        $response->assertSee('Peralatan Canggih Siaga di Provinsi DKI Jakarta');

        // Section 4: Wilayah Layanan (Kecamatan yang dilayani)
        $response->assertSee('id="wilayah-layanan"', false);
        $response->assertSee('Pilih Kota atau Kabupaten Anda di DKI Jakarta');
    }

    public function test_area_page_displays_custom_hero_image_and_custom_faqs(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'meta_title' => 'Jasa Saluran Mampet di Tebet, Jakarta Selatan',
            'hero_image' => 'images/areas/tebet-landmark-custom.webp',
            'faqs' => [
                [
                    'question' => 'Berapa biaya kuras pipa di Tebet Barat?',
                    'answer' => 'Biaya penanganan di Tebet Barat mulai Rp 400.000 bergaransi 30 hari.',
                ],
                [
                    'question' => 'Apakah melayani ruko di Jalan Tebet Raya?',
                    'answer' => 'Ya, kami melayani ruko kuliner dan komersial di sepanjang Jalan Tebet Raya.',
                ],
            ],
            'is_active' => true,
        ]);

        $response = $this->get('/area/jakarta-selatan/tebet');

        $response->assertStatus(200);
        $response->assertSee('images/areas/tebet-landmark-custom.webp');
        $response->assertSee('Berapa biaya kuras pipa di Tebet Barat?');
        $response->assertSee('Biaya penanganan di Tebet Barat mulai Rp 400.000 bergaransi 30 hari.');
        $response->assertSee('Apakah melayani ruko di Jalan Tebet Raya?');
        $response->assertSee('Plumber');
    }

    public function test_area_page_displays_dynamic_fallback_faqs(): void
    {
        $response = $this->get('/area/semarang/banyumanik');

        $response->assertStatus(200);
        $response->assertSee('Pertanyaan Seputar Layanan di Banyumanik');
        $response->assertSee('Berapa lama estimasi teknisi Drainusantara tiba di area Banyumanik, Kota Semarang?');
        $response->assertSee('Apakah pengerjaan saluran mampet di Banyumanik membongkar lantai keramik?');
        $response->assertSee('Plumber');
    }
}
