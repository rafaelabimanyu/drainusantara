<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoverageAreaSyncTest extends TestCase
{
    use RefreshDatabase;

    private function expectedTotalCoverageAreas(): int
    {
        $all = \App\Services\RegionService::all();
        $total = count($all);
        foreach ($all as $province) {
            $total += count($province['cities']);
            foreach ($province['cities'] as $city) {
                $total += count($city['districts']);
            }
        }

        return $total;
    }

    public function test_sync_from_master_creates_all_districts(): void
    {
        $this->assertEquals(0, CoverageArea::count());

        $result = CoverageArea::syncFromMaster();

        $expectedTotal = $this->expectedTotalCoverageAreas();
        $this->assertEquals($expectedTotal, $result['total']);
        $this->assertEquals($expectedTotal, $result['created']);
        $this->assertEquals(0, $result['existing']);
        $this->assertEquals($expectedTotal, CoverageArea::count());

        // Verify Ciracas in Jakarta Timur was created
        $ciracas = CoverageArea::where('city', 'Jakarta Timur')
            ->where('district', 'Ciracas')
            ->first();

        $this->assertNotNull($ciracas);
        $this->assertEquals('jakarta-timur-ciracas', $ciracas->slug);
        $this->assertTrue($ciracas->is_active);

        // Verify Soreang in Kabupaten Bandung was created
        $soreang = CoverageArea::where('city', 'Kabupaten Bandung')
            ->where('district', 'Soreang')
            ->first();
        $this->assertNotNull($soreang);
        $this->assertTrue($soreang->is_active);

        // Verify Mranggen in Demak was created
        $mranggen = CoverageArea::where('city', 'Kabupaten Demak')
            ->where('district', 'Mranggen')
            ->first();
        $this->assertNotNull($mranggen);

        // Run sync again to verify idempotency
        $secondResult = CoverageArea::syncFromMaster();
        $this->assertEquals(0, $secondResult['created']);
        $this->assertEquals($expectedTotal, $secondResult['existing']);
        $this->assertEquals($expectedTotal, CoverageArea::count());
    }

    public function test_admin_can_trigger_sync_route(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->post(route('admin.coverage-areas.sync'));

        $response->assertRedirect(route('admin.coverage-areas.index'));
        $response->assertSessionHas('success');

        $this->assertEquals($this->expectedTotalCoverageAreas(), CoverageArea::count());
    }

    public function test_guest_cannot_trigger_sync_route(): void
    {
        $response = $this->post(route('admin.coverage-areas.sync'));

        $response->assertRedirect(route('login'));
        $this->assertEquals(0, CoverageArea::count());
    }

    public function test_admin_index_filters_by_city(): void
    {
        $admin = User::factory()->create();
        CoverageArea::syncFromMaster();

        // Filter by Jakarta Timur
        $response = $this->actingAs($admin)
            ->get(route('admin.coverage-areas.index', ['city' => 'Jakarta Timur']));

        $response->assertOk();
        $response->assertSee('Ciracas');
        $response->assertSee('Duren Sawit');
        $response->assertSee('Cakung');
    }
}

