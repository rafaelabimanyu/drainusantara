<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Service;
use App\Services\RegionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class GeoSeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (Service::count() === 0) {
            Service::create([
                'name' => 'Wastafel Cuci Piring',
                'slug' => 'wastafel-cuci-piring',
                'short_description' => 'Pelancaran wastafel mampet',
                'price_starting_from' => 400000,
                'is_active' => true,
            ]);
        }
    }

    public function test_district_page_renders_iso3166_and_centroid_geotags(): void
    {
        // District without explicit DB coordinates to test auto-centroid fallback
        $area = CoverageArea::create([
            'city' => 'Jakarta Timur',
            'district' => 'Matraman',
            'slug' => 'jakarta-timur-matraman',
            'is_active' => true,
        ]);

        $response = $this->get('/area/jakarta-timur/matraman');
        $response->assertOk();

        // 1. ISO 3166-2 Province Code for DKI Jakarta is ID-JK
        $response->assertSee('<meta name="geo.region" content="ID-JK">', false);
        $response->assertSee('<meta name="geo.placename" content="Matraman, Jakarta Timur">', false);

        // 2. Auto-centroid coordinates are rendered
        $coords = $area->resolved_coordinates;
        $response->assertSee('<meta name="geo.position" content="' . $coords['lat'] . ';' . $coords['lng'] . '">', false);
        $response->assertSee('<meta name="ICBM" content="' . $coords['lat'] . ', ' . $coords['lng'] . '">', false);

        // 3. OpenGraph Location Tags
        $response->assertSee('<meta property="og:latitude" content="' . $coords['lat'] . '">', false);
        $response->assertSee('<meta property="og:longitude" content="' . $coords['lng'] . '">', false);
        $response->assertSee('<meta property="og:locality" content="Matraman">', false);
        $response->assertSee('<meta property="og:region" content="Jakarta Timur">', false);
        $response->assertSee('<meta property="og:country-name" content="Indonesia">', false);

        // 4. Schema.org JSON-LD Enriched Attributes
        $response->assertSee('"@type":"Plumber"', false);
        $response->assertSee('"@type":"GeoCoordinates"', false);
        $response->assertSee('"latitude":' . $coords['lat'], false);
        $response->assertSee('"longitude":' . $coords['lng'], false);
        $response->assertSee('PT JAWA JAYA ROOTER', false);
        $response->assertSee('"@type":"OfferCatalog"', false);
        $response->assertSee('"@type":"OpeningHoursSpecification"', false);
        $response->assertSee('"@type":"AdministrativeArea"', false);
    }

    public function test_district_page_preserves_custom_database_coordinates(): void
    {
        CoverageArea::create([
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'latitude' => -6.2297465,
            'longitude' => 106.8553214,
            'is_active' => true,
        ]);

        $response = $this->get('/area/jakarta-selatan/tebet');
        $response->assertOk();

        $response->assertSee('<meta name="geo.region" content="ID-JK">', false);
        $response->assertSee('<meta name="geo.position" content="-6.2297465;106.8553214">', false);
        $response->assertSee('<meta name="ICBM" content="-6.2297465, 106.8553214">', false);
        $response->assertSee('<meta property="og:latitude" content="-6.2297465">', false);
        $response->assertSee('<meta property="og:longitude" content="106.8553214">', false);
    }

    public function test_city_page_renders_iso3166_and_structured_subdistricts_schema(): void
    {
        $response = $this->get('/area/jakarta-selatan');
        $response->assertOk();

        // ISO 3166-2 for DKI Jakarta
        $response->assertSee('<meta name="geo.region" content="ID-JK">', false);
        $response->assertSee('<meta name="geo.placename" content="Jakarta Selatan, DKI Jakarta">', false);
        $response->assertSee('name="geo.position"', false);
        $response->assertSee('name="ICBM"', false);
        $response->assertSee('property="og:latitude"', false);

        // Schema areaServed includes structured subdistricts
        $response->assertSee('Kecamatan Tebet', false);
        $response->assertSee('Kecamatan Cilandak', false);
        $response->assertSee('PT JAWA JAYA ROOTER', false);
        $response->assertSee('"@type":"OfferCatalog"', false);
    }

    public function test_province_page_renders_iso3166_geotags(): void
    {
        // Jawa Barat => ID-JB
        $response = $this->get(route('area.province', ['province' => 'jawa-barat']));
        $response->assertOk();

        $response->assertSee('<meta name="geo.region" content="ID-JB">', false);
        $response->assertSee('<meta name="geo.placename" content="Jawa Barat, Indonesia">', false);
        $response->assertSee('name="geo.position"', false);
        $response->assertSee('name="ICBM"', false);
        $response->assertSee('property="og:latitude"', false);
        $response->assertSee('property="og:longitude"', false);
    }

    public function test_banten_and_central_java_and_lampung_iso_codes(): void
    {
        $banten = $this->get(route('area.province', ['province' => 'banten']));
        $banten->assertOk();
        $banten->assertSee('<meta name="geo.region" content="ID-BT">', false);

        $jawaTengah = $this->get(route('area.province', ['province' => 'jawa-tengah']));
        $jawaTengah->assertOk();
        $jawaTengah->assertSee('<meta name="geo.region" content="ID-JT">', false);

        $lampung = $this->get(route('area.province', ['province' => 'lampung']));
        $lampung->assertOk();
        $lampung->assertSee('<meta name="geo.region" content="ID-LA">', false);

        $bali = $this->get(route('area.province', ['province' => 'bali']));
        $bali->assertOk();
        $bali->assertSee('<meta name="geo.region" content="ID-BA">', false);
    }

    public function test_bali_page_renders_accurate_bali_centroid_coordinates(): void
    {
        $response = $this->get('/area/kota-denpasar/sanur');
        $response->assertOk();

        $response->assertSee('<meta name="geo.region" content="ID-BA">', false);
        $response->assertSee('<meta name="geo.placename" content="Sanur, Kota Denpasar">', false);
        $response->assertSee('<meta name="geo.position" content="-8.6882;115.2625">', false);
        $response->assertSee('<meta name="ICBM" content="-8.6882, 115.2625">', false);
        $response->assertSee('"@type":"AggregateRating"', false);
        $response->assertSee('"ratingValue":"4.9"', false);
    }

    public function test_layout_avoids_duplicate_conflicting_geo_tags_on_area_pages(): void
    {
        $response = $this->get('/area/jakarta-selatan');
        $response->assertOk();

        $content = $response->getContent();
        $this->assertSame(1, substr_count($content, 'name="geo.region"'));
        $this->assertSame(1, substr_count($content, 'name="geo.position"'));
        $this->assertStringContainsString('hreflang="id"', $content);
        $this->assertStringContainsString('hreflang="x-default"', $content);
    }

    public function test_ai_catalog_contains_enriched_city_fleet_data(): void
    {
        $response = $this->get('/.well-known/ai-catalog.json');
        $response->assertOk();

        $data = $response->json();
        $this->assertNotEmpty($data['entries']);

        $geoEntry = collect($data['entries'])->firstWhere('identifier', 'urn:air:drainusantara.id:geo:coverage-areas');
        $this->assertNotNull($geoEntry);
        $this->assertArrayHasKey('cities', $geoEntry['data']);
        $this->assertNotEmpty($geoEntry['data']['cities']);

        $cityNames = collect($geoEntry['data']['cities'])->pluck('city')->all();
        $this->assertContains('Jakarta Selatan', $cityNames);
        $this->assertContains('Bogor', $cityNames);
        $this->assertContains('Kota Semarang', $cityNames);
        $this->assertContains('Bandar Lampung', $cityNames);
    }

    public function test_schema_plumber_component_renders_complete_local_business_data(): void
    {
        $rendered = Blade::render('<x-schema.plumber city-slug="bandung" district="dago" />');

        $this->assertStringContainsString('<script type="application/ld+json">', $rendered);
        $this->assertStringContainsString('PT JAWA JAYA ROOTER', $rendered);
        $this->assertStringContainsString('+6285609009009', $rendered);
        $this->assertStringContainsString('Mo-Su 00:00-24:00', $rendered);
        $this->assertStringContainsString('"ratingValue": "4.9"', $rendered);
        $this->assertStringContainsString('"@type": "OfferCatalog"', $rendered);
        $this->assertStringContainsString('"@type": "GeoCoordinates"', $rendered);

        $centroid = RegionService::centroid('bandung', 'dago');
        $this->assertStringContainsString('"latitude": ' . $centroid['lat'], $rendered);
        $this->assertStringContainsString('"longitude": ' . $centroid['lng'], $rendered);

        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $rendered, $matches);
        $this->assertNotEmpty($matches[1]);
        $json = json_decode(trim($matches[1]), true);
        $this->assertIsArray($json);
        $this->assertSame('Plumber', $json['@type']);
        $this->assertSame('PT JAWA JAYA ROOTER', $json['name']);
        $this->assertSame('+6285609009009', $json['telephone']);
        $this->assertSame('4.9', $json['aggregateRating']['ratingValue']);
        $this->assertSame($centroid['lat'], $json['geo']['latitude']);
        $this->assertSame($centroid['lng'], $json['geo']['longitude']);
        $this->assertSame('Layanan Pelancaran Pipa Mampet', $json['hasOfferCatalog']['name']);
    }
}
