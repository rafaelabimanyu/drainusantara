<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoOrderTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Drainusantara',
            'email' => 'admin@drainusantara.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_first_item_auto_assigns_order_1(): void
    {
        $this->assertEquals(1, Staff::getNextAvailableOrder());
        $this->assertEquals(1, Portfolio::getNextAvailableOrder());
        $this->assertEquals(1, Service::getNextAvailableOrder());
        $this->assertEquals(1, Equipment::getNextAvailableOrder());

        $staff = Staff::create(['name' => 'Staff 1']);
        $this->assertEquals(1, $staff->order);
    }

    public function test_sequential_items_append_to_the_end(): void
    {
        $staff1 = Staff::create(['name' => 'Staff 1']);
        $staff2 = Staff::create(['name' => 'Staff 2']);
        $staff3 = Staff::create(['name' => 'Staff 3']);

        $this->assertEquals(1, $staff1->order);
        $this->assertEquals(2, $staff2->order);
        $this->assertEquals(3, $staff3->order);
        $this->assertEquals(4, Staff::getNextAvailableOrder());
    }

    public function test_deleted_item_in_middle_causes_next_item_to_fill_the_gap(): void
    {
        $staff1 = Staff::create(['name' => 'Staff 1', 'order' => 1]);
        $staff2 = Staff::create(['name' => 'Staff 2', 'order' => 2]);
        $staff3 = Staff::create(['name' => 'Staff 3', 'order' => 3]);
        $staff4 = Staff::create(['name' => 'Staff 4', 'order' => 4]);

        // Delete item #2
        $staff2->delete();

        // Next available order must be 2 (the gap!)
        $this->assertEquals(2, Staff::getNextAvailableOrder());

        // Create new item without passing order
        $newStaff = Staff::create(['name' => 'Staff New']);
        $this->assertEquals(2, $newStaff->order);

        // After filling the gap, next available order should be 5
        $this->assertEquals(5, Staff::getNextAvailableOrder());
    }

    public function test_deleted_item_at_beginning_causes_next_item_to_fill_slot_1(): void
    {
        $staff1 = Staff::create(['name' => 'Staff 1', 'order' => 1]);
        $staff2 = Staff::create(['name' => 'Staff 2', 'order' => 2]);
        $staff3 = Staff::create(['name' => 'Staff 3', 'order' => 3]);

        // Delete item #1
        $staff1->delete();

        // Next available order must be 1
        $this->assertEquals(1, Staff::getNextAvailableOrder());

        $newStaff = Staff::create(['name' => 'Staff Replacement 1']);
        $this->assertEquals(1, $newStaff->order);

        // Next available order should now be 4
        $this->assertEquals(4, Staff::getNextAvailableOrder());
    }

    public function test_admin_create_forms_prefill_calculated_next_order(): void
    {
        Portfolio::create(['client_name' => 'Client 1', 'order' => 1]);
        Portfolio::create(['client_name' => 'Client 2', 'order' => 2]);

        $response = $this->actingAs($this->admin)->get(route('admin.portfolios.create'));
        $response->assertStatus(200);
        $response->assertViewHas('nextOrder', 3);
        $response->assertSee('value="3"', false);
    }

    public function test_portfolio_gap_filling_via_http_controllers(): void
    {
        $p1 = Portfolio::create(['client_name' => 'Client 1', 'order' => 1]);
        $p2 = Portfolio::create(['client_name' => 'Client 2', 'order' => 2]);
        $p3 = Portfolio::create(['client_name' => 'Client 3', 'order' => 3]);

        // Admin deletes portfolio #2
        $this->actingAs($this->admin)->delete(route('admin.portfolios.destroy', $p2));
        $this->assertDatabaseMissing('portfolios', ['id' => $p2->id]);

        // Create form should now suggest order 2
        $createResponse = $this->actingAs($this->admin)->get(route('admin.portfolios.create'));
        $createResponse->assertViewHas('nextOrder', 2);

        // Admin submits form with empty order
        $postResponse = $this->actingAs($this->admin)->post(route('admin.portfolios.store'), [
            'client_name' => 'Client Baru Pengganti #2',
            'client_type' => 'Restoran',
            'location' => 'Jakarta',
            'order' => '',
        ]);
        $postResponse->assertRedirect(route('admin.portfolios.index'));

        $this->assertDatabaseHas('portfolios', [
            'client_name' => 'Client Baru Pengganti #2',
            'order' => 2,
        ]);
    }

    public function test_service_gap_filling_via_http_controllers(): void
    {
        $s1 = Service::create(['name' => 'Layanan 1', 'slug' => 'layanan-1', 'order' => 1]);
        $s2 = Service::create(['name' => 'Layanan 2', 'slug' => 'layanan-2', 'order' => 2]);
        $s3 = Service::create(['name' => 'Layanan 3', 'slug' => 'layanan-3', 'order' => 3]);

        // Admin deletes service #2
        $this->actingAs($this->admin)->delete(route('admin.services.destroy', $s2));

        // Create form should suggest order 2
        $createResponse = $this->actingAs($this->admin)->get(route('admin.services.create'));
        $createResponse->assertViewHas('nextOrder', 2);

        // Admin stores new service without order
        $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'name' => 'Layanan Baru Pengganti #2',
            'order' => '',
        ]);

        $this->assertDatabaseHas('services', [
            'name' => 'Layanan Baru Pengganti #2',
            'order' => 2,
        ]);
    }

    public function test_equipment_gap_filling_via_http_controllers(): void
    {
        $e1 = Equipment::create(['name' => 'Alat 1', 'order' => 1]);
        $e2 = Equipment::create(['name' => 'Alat 2', 'order' => 2]);
        $e3 = Equipment::create(['name' => 'Alat 3', 'order' => 3]);

        // Admin deletes equipment #2
        $this->actingAs($this->admin)->delete(route('admin.equipments.destroy', $e2));

        // Create form should suggest order 2
        $createResponse = $this->actingAs($this->admin)->get(route('admin.equipments.create'));
        $createResponse->assertViewHas('nextOrder', 2);

        // Admin stores new equipment without order
        $this->actingAs($this->admin)->post(route('admin.equipments.store'), [
            'name' => 'Alat Baru Pengganti #2',
            'order' => '',
        ]);

        $this->assertDatabaseHas('equipments', [
            'name' => 'Alat Baru Pengganti #2',
            'order' => 2,
        ]);
    }
}
