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

    public function test_sync_from_master_creates_all_districts(): void
    {
        $this->assertEquals(0, CoverageArea::count());

        $result = CoverageArea::syncFromMaster();

        $this->assertEquals(132, $result['total']);
        $this->assertEquals(132, $result['created']);
        $this->assertEquals(0, $result['existing']);
        $this->assertEquals(132, CoverageArea::count());

        // Verify Ciracas in Jakarta Timur was created
        $ciracas = CoverageArea::where('city', 'Jakarta Timur')
            ->where('district', 'Ciracas')
            ->first();

        $this->assertNotNull($ciracas);
        $this->assertEquals('jakarta-timur-ciracas', $ciracas->slug);
        $this->assertTrue($ciracas->is_active);

        // Run sync again to verify idempotency
        $secondResult = CoverageArea::syncFromMaster();
        $this->assertEquals(0, $secondResult['created']);
        $this->assertEquals(132, $secondResult['existing']);
        $this->assertEquals(132, CoverageArea::count());
    }

    public function test_admin_can_trigger_sync_route(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->post(route('admin.coverage-areas.sync'));

        $response->assertRedirect(route('admin.coverage-areas.index'));
        $response->assertSessionHas('success');

        $this->assertEquals(132, CoverageArea::count());
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

