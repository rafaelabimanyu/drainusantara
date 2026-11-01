<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoverageAreaLandingEnhancedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure at least one service and one equipment exist
        if (Service::count() === 0) {
            Service::create([
                'name' => 'Wastafel Cuci Piring',
                'slug' => 'wastafel-cuci-piring',
                'short_description' => 'Pelancaran wastafel mampet',
                'price_starting_from' => 400000,
                'is_active' => true,
            ]);
        }

        if (Equipment::count() === 0) {
            Equipment::create([
                'name' => 'Mesin Spiral Rotary Ridgid K-6200',
                'slug' => 'mesin-spiral-rotary-ridgid-k6200',
                'badge' => 'PENGHANCUR LEMAK BEKU',
                'short_description' => 'Motor torsi tinggi kabel baja tempered 16mm-20mm',
                'is_active' => true,
            ]);
        }

        if (Article::count() === 0) {
            Article::create([
                'title' => 'Cara Mengatasi Saluran Pipa Mampet',
                'slug' => 'cara-mengatasi-saluran-pipa-mampet',
                'excerpt' => 'Panduan lengkap pelancaran pipa tanpa bongkar',
                'content' => 'Langkah-langkah teknis penanganan saluran pipa mampet...',
                'category' => 'edukasi',
                'is_published' => true,
                'published_at' => now(),
            ]);
        }
    }

    public function test_district_landing_page_renders_all_required_differentiated_sections(): void
    {
        $area = CoverageArea::firstOrCreate(
            ['city' => 'Jakarta Selatan', 'district' => 'Tebet'],
            [
                'slug' => 'jakarta-selatan-tebet',
                'starting_price' => 450000,
                'posko_name' => 'Posko Siaga Drainusantara Unit Tebet',
                'posko_address' => 'Jl. Tebet Barat No. 12, Jakarta Selatan',
                'posko_coverage_radius' => 'Radius 15 KM • Respon 30 Menit',
                'cta_headline' => 'Saluran Air di Tebet Tersumbat Hari Ini?',
                'cta_button_text' => 'Panggil Teknisi Tebet Sekarang',
                'geo_keywords' => 'saluran mampet tebet, wastafel tebet, sedot wc tebet',
                'latitude' => -6.2297465,
                'longitude' => 106.8553214,
                'is_active' => true,
            ]
        );

        $response = $this->get('/area/jakarta-selatan/tebet');

        $response->assertStatus(200);

        // 1. Differentiated Starting Price & Hero CTA
        $response->assertSee('Rp 450.000', false);
        $response->assertSee('Panggil Teknisi Tebet Sekarang', false);
        $response->assertSee('Saluran Air di Tebet Tersumbat Hari Ini?', false);

        // 2. Horizontal Carousels for Services & Equipment
        $response->assertSee('id="layanan-area"', false);
        $response->assertSee('id="peralatan-area"', false);
        $response->assertSee('Mesin Spiral Rotary Ridgid K-6200', false);

        // 3. Service Categories
        $response->assertSee('Rumahan / Residensial', false);
        $response->assertSee('Restoran &amp; FnB / Kafe', false);
        $response->assertSee('Gedung &amp; Perkantoran', false);

        // 4. Comparison Table (Tukang Konvensional vs Drainusantara)
        $response->assertSee('Tukang Konvensional vs Standar Drainusantara', false);
        $response->assertSee('Metode Pengerjaan', false);
        $response->assertSee('Keamanan Pipa PVC', false);

        // 5. Posko Armada Location Section
        $response->assertSee('Posko Siaga Drainusantara Unit Tebet', false);
        $response->assertSee('Jl. Tebet Barat No. 12', false);

        // 6. Gallery and Blog sections
        $response->assertSee('Dokumentasi Pengerjaan di Lapangan', false);
        $response->assertSee('Artikel &amp; Panduan Saluran Air Bersih', false);

        // 7. Supporting tags at bottom section
        $response->assertSee('Cakupan Area Sekitar Tebet, Jakarta Selatan', false);

        // 8. Hidden Geo SEO meta tags in <head> without visible tag cloud
        $response->assertSee('name="geo.placename" content="Tebet, Jakarta Selatan"', false);
        $response->assertSee('name="geo.position" content="-6.2297465;106.8553214"', false);
        $response->assertSee('name="ICBM" content="-6.2297465, 106.8553214"', false);
    }

    public function test_city_landing_page_renders_rich_sections_and_area_catalog(): void
    {
        $response = $this->get('/area/jakarta-selatan');

        $response->assertStatus(200);

        // City Hero & Sections
        $response->assertSee('Jasa Saluran Mampet di <span class="text-sky-700">Jakarta Selatan</span>', false);
        $response->assertSee('id="layanan-kota"', false);
        $response->assertSee('id="peralatan-kota"', false);
        $response->assertSee('Tukang Konvensional vs Standar Drainusantara', false);
        $response->assertSee('POSKO UTAMA ARMADA', false);
        $response->assertSee('Daftar Area Layanan di Jakarta Selatan', false);

        // Verify /area/jakarta-timur also works without any SQL errors
        $responseJaktim = $this->get('/area/jakarta-timur');
        $responseJaktim->assertStatus(200);
        $responseJaktim->assertSee('Jakarta Timur', false);
    }

    public function test_admin_can_update_coverage_area_custom_landing_fields(): void
    {
        $user = User::factory()->create();

        $area = CoverageArea::firstOrCreate(
            ['city' => 'Jakarta Timur', 'district' => 'Matraman'],
            [
                'slug' => 'jakarta-timur-matraman',
                'is_active' => true,
            ]
        );

        $response = $this->actingAs($user)->put(route('admin.coverage-areas.update', $area), [
            'city' => 'Jakarta Timur',
            'district' => 'Matraman',
            'starting_price' => 500000,
            'posko_name' => 'Posko Matraman Raya',
            'posko_address' => 'Jl. Matraman Raya No. 45',
            'posko_coverage_radius' => 'Radius 10 KM',
            'cta_headline' => 'Butuh Pelancar Pipa di Matraman?',
            'cta_button_text' => 'Panggil Teknisi Matraman',
            'cta_whatsapp_text' => 'Halo teknisi di Matraman, pipa saya tersumbat.',
            'geo_keywords' => 'pipa mampet matraman, saluran mampet matraman',
            'latitude' => -6.2088,
            'longitude' => 106.8584,
            'supporting_tags' => 'Utan Kayu Utara, Utan Kayu Selatan, Pisangan Baru, Pal Meriam, Kebon Manggis',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.coverage-areas.index'));

        $area->refresh();
        $this->assertEquals(500000, $area->starting_price);
        $this->assertEquals('Posko Matraman Raya', $area->posko_name);
        $this->assertEquals('Panggil Teknisi Matraman', $area->cta_button_text);
        $this->assertContains('Utan Kayu Utara', $area->supporting_tags);
        $this->assertEquals(-6.2088, $area->latitude);
    }
}
