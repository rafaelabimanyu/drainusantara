<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\CoverageArea;
use App\Services\AreaImageResolver;
use App\Services\RegionService;
use Tests\TestCase;

class AreaImageResolverTest extends TestCase
{
    public function test_encode_path_handles_spaces_and_slashes(): void
    {
        $input = 'images/areas/DKI JAKARTA/KECAMATAN JAKARTA SELATAN/tebet.jpg';
        $encoded = AreaImageResolver::encodePath($input);

        $this->assertSame('images/areas/DKI%20JAKARTA/KECAMATAN%20JAKARTA%20SELATAN/tebet.jpg', $encoded);

        // Windows backslash normalization
        $winInput = 'images\\areas\\JAWA TENGAH\\SEMARANG\\semarang.jpg';
        $winEncoded = AreaImageResolver::encodePath($winInput);

        $this->assertSame('images/areas/JAWA%20TENGAH/SEMARANG/semarang.jpg', $winEncoded);
    }

    public function test_resolve_dedicated_district_photo(): void
    {
        // Tebet in Jakarta Selatan
        $resolved = AreaImageResolver::resolve(null, 'dki-jakarta', 'jakarta-selatan', 'Tebet');

        $this->assertSame('district_asset', $resolved['source']);
        $this->assertStringContainsString('tebet.jpg', $resolved['path']);
        $this->assertFileExists(public_path($resolved['path']));
        $this->assertStringContainsString('DKI%20JAKARTA', $resolved['url']);
        $this->assertStringContainsString('tebet.jpg', $resolved['url']);
    }

    public function test_resolve_dedicated_city_photo(): void
    {
        // Semarang city level
        $resolved = AreaImageResolver::resolve(null, 'jawa-tengah', 'semarang');

        $this->assertSame('city_asset', $resolved['source']);
        $this->assertStringContainsString('semarang.jpg', $resolved['path']);
        $this->assertFileExists(public_path($resolved['path']));
    }

    public function test_resolve_dedicated_province_photo(): void
    {
        // DKI Jakarta province level
        $resolved = AreaImageResolver::resolve(null, 'dki-jakarta');

        $this->assertSame('province_asset', $resolved['source']);
        $this->assertFileExists(public_path($resolved['path']));
    }

    public function test_fallback_to_default_fleet_for_unmapped_regions(): void
    {
        // Bali (no dedicated local folder currently in images/areas)
        $resolved = AreaImageResolver::resolve(null, 'bali', 'denpasar', 'Denpasar Barat');

        $this->assertSame('default_fleet', $resolved['source']);
        $this->assertSame(AreaImageResolver::DEFAULT_IMAGE, $resolved['path']);
        $this->assertFileExists(public_path($resolved['path']));
    }

    public function test_custom_cms_upload_has_top_priority(): void
    {
        $area = new CoverageArea([
            'province_name' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
            'hero_image' => 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
        ]);

        $resolved = AreaImageResolver::resolve($area);

        $this->assertSame('cms_custom', $resolved['source']);
        $this->assertSame('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp', $resolved['path']);
    }

    public function test_coverage_area_model_accessors(): void
    {
        $area = new CoverageArea([
            'province_name' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'jakarta-selatan-tebet',
        ]);

        $heroUrl = $area->resolved_hero_image;
        $presenceUrl = $area->resolved_presence_image;
        $source = $area->image_source;

        $this->assertNotEmpty($heroUrl);
        $this->assertNotEmpty($presenceUrl);
        $this->assertSame('district_asset', $source);
        $this->assertStringContainsString('tebet.jpg', $heroUrl);
    }

    public function test_region_service_resolve_area_image_helper(): void
    {
        $url = RegionService::resolveAreaImage('dki-jakarta', 'jakarta-selatan', 'Tebet');

        $this->assertNotEmpty($url);
        $this->assertStringContainsString('tebet.jpg', $url);
        $this->assertStringContainsString('DKI%20JAKARTA', $url);
    }
}

