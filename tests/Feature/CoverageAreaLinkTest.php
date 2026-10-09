<?php

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoverageAreaLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_area_links_use_canonical_city_slug(): void
    {
        CoverageArea::create(['city' => 'Kota Semarang', 'district' => 'Banyumanik', 'slug' => 'semarang-banyumanik', 'is_active' => true]);
        $this->actingAs(User::factory()->create());

        foreach (['/admin', '/admin/coverage-areas'] as $path) {
            $this->get($path)->assertOk()->assertSee('href="'.route('area.detail', ['city' => 'semarang', 'district' => 'banyumanik']).'"', false);
        }

        $this->get('/area/semarang/banyumanik')->assertOk();
    }

    public function test_unavailable_areas_have_no_public_link(): void
    {
        $this->assertNull((new CoverageArea(['city' => 'Unknown', 'district' => 'Unknown', 'is_active' => true]))->publicUrl());
        $this->assertNull((new CoverageArea(['city' => 'Jakarta Selatan', 'district' => 'Unknown', 'is_active' => true]))->publicUrl());
        $this->assertNull((new CoverageArea(['city' => 'Jakarta Selatan', 'district' => 'Tebet', 'is_active' => false]))->publicUrl());
    }
}
