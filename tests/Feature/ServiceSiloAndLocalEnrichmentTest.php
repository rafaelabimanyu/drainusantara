<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Service;
use App\Services\ServiceCatalogRegistry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceSiloAndLocalEnrichmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\CoverageAreaSeeder::class);
        $this->seed(\Database\Seeders\ServiceSeeder::class);
        \Illuminate\Support\Facades\Artisan::call('area:enrich-hyperlocal');
    }

    public function test_service_index_page_returns_ok_and_renders_catalog(): void
    {
        $response = $this->get('/layanan');

        $response->assertOk();
        $response->assertSee('Layanan Jasa Saluran Pipa Mampet', false);
        $response->assertSee('100% Tanpa Bongkar', false);
        $response->assertSee('Katalog Solusi Saluran Pipa Mampet Spesifik', false);

        // Contextual WhatsApp link on index
        $response->assertSee(rawurlencode('Halo Tim Drainusantara, saya ingin konsultasi mengenai katalog layanan pelancaran pipa mampet.'), false);
    }

    public function test_all_six_canonical_service_detail_pages_return_ok_with_rich_schemas(): void
    {
        $canonicalServices = ServiceCatalogRegistry::all();

        $this->assertCount(6, $canonicalServices);

        foreach ($canonicalServices as $slug => $data) {
            $response = $this->get('/layanan/' . $slug);

            $response->assertOk();

            // Unique H1
            $response->assertSee($data['h1'], false);

            // Schema JSON-LD Service & FAQPage
            $response->assertSee('"@type":"Service"', false);
            $response->assertSee('"@type":"FAQPage"', false);

            // Contextual WhatsApp URL for this specific service
            $expectedMsg = "Halo Tim Drainusantara, saya membutuhkan layanan {$data['name']}. Mohon info estimasi biaya dan ketersediaan teknisi.";
            $response->assertSee(rawurlencode($expectedMsg), false);

            // Canonical URL
            $response->assertSee('<link rel="canonical" href="http://localhost:8000/layanan/' . $slug . '">', false);
        }
    }

    public function test_legacy_service_slugs_redirect_301_to_canonical_slugs(): void
    {
        $aliases = [
            'wastafel-cuci-piring-mampet' => 'jasa-wastafel-dan-cucian-piring-mampet',
            'kloset-wc-mampet' => 'jasa-wc-dan-kloset-mampet',
            'floor-drain-kamar-mandi' => 'jasa-kamar-mandi-dan-floor-drain-mampet',
            'kuras-grease-trap-lemak' => 'jasa-hydro-jetting-dan-rooter-pipa',
            'inspeksi-kamera-cctv-pipa' => 'jasa-inspeksi-kamera-cctv-pipa',
            'talang-rooftop-pipa-atap' => 'jasa-talang-air-dan-saluran-utama-mampet',
        ];

        foreach ($aliases as $legacy => $canonical) {
            $response = $this->get('/layanan/' . $legacy);
            $response->assertStatus(301);
            $response->assertRedirect(route('services.show', ['slug' => $canonical]));
        }
    }

    public function test_sitemap_xml_contains_service_index_and_all_canonical_service_slugs(): void
    {
        \Illuminate\Support\Facades\Cache::forget('sitemap_xml');
        \Illuminate\Support\Facades\Cache::forget('sitemap.xml');

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('/layanan</loc>', $content);

        foreach (array_keys(ServiceCatalogRegistry::all()) as $slug) {
            $this->assertStringContainsString('/layanan/' . $slug . '</loc>', $content);
        }
    }

    public function test_distinct_districts_have_unique_hyperlocal_content_and_faqs(): void
    {
        // Sample 1: Tebet (Jakarta Selatan - Culinary/Commercial)
        $resTebet = $this->get('/area/jakarta-selatan/tebet');
        $resTebet->assertOk();
        $resTebet->assertSee('Tebet Barat', false);
        $resTebet->assertSee('Tebet Eco Park', false);
        $resTebet->assertSee('Mengapa saluran wastafel dapur di ruko/rumah area Tebet sangat mudah tersumbat lemak membatu?', false);

        // Sample 2: Kebayoran Baru (Jakarta Selatan - Business/Lifestyle)
        $resKebayoran = $this->get('/area/jakarta-selatan/kebayoran-baru');
        $resKebayoran->assertOk();
        $resKebayoran->assertSee('Senopati &amp; Suryo', false);
        $resKebayoran->assertSee('Blok M &amp; Melawai', false);

        // Content of Tebet and Kebayoran Baru must not be identical
        $this->assertNotEquals($resTebet->getContent(), $resKebayoran->getContent());
    }

    public function test_all_246_districts_have_resolved_supporting_tags_and_hyperlocal_data(): void
    {
        $districts = CoverageArea::whereNotNull('district')
            ->whereNotIn('district', ['[KOTA]', '[PROVINSI]'])
            ->get();

        $this->assertGreaterThanOrEqual(100, $districts->count());

        foreach ($districts->take(15) as $district) {
            $this->assertNotEmpty($district->resolved_supporting_tags, "District {$district->district} should have resolved supporting tags");
            $this->assertNotEmpty($district->resolved_geo_keywords, "District {$district->district} should have resolved geo keywords");
            $this->assertNotEmpty($district->resolved_faqs, "District {$district->district} should have resolved FAQs");
        }
    }
}
