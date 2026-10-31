<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EquipmentDetailAndCmsTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Drainusantara@admin',
            'email' => 'Drainusantara@admin',
            'password' => Hash::make('Drainusantara123'),
        ]);
    }

    public function test_public_can_view_equipment_detail_page_with_valid_slug(): void
    {
        $equipment = Equipment::create([
            'name' => 'Mesin Rooter Ridgid K-50 Spiral Baja Rotary',
            'slug' => 'mesin-rooter-ridgid-k-50-spiral-baja-rotary',
            'category' => 'Mesin Utama',
            'badge' => '100% Mekanis',
            'short_description' => 'Kabel spiral lentur berputar 400 RPM meluncur di leher angsa.',
            'description' => 'Mesin drain cleaner Ridgid K-50 beroperasi secara mekanis murni tanpa bahan kimia soda api.',
            'specs' => ['Jangkauan: 30 Meter', 'Diameter Pipa: 1.5 - 6 inch'],
            'features' => ['Motor 220V 400 RPM', 'Kabel spiral baja karbon tempa modular'],
            'applications' => ['Wastafel dapur mampet minyak', 'Kloset duduk tersumbat tisu'],
            'safety_k3' => 'Wajib menggunakan sarung tangan anti-lilit dan grounding listrik.',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('equipment.show', $equipment->slug));
        $response->assertOk();

        // Technical content assertions
        $response->assertSee($equipment->name);
        $response->assertSee('100% Mekanis');
        $response->assertSee('Mesin drain cleaner Ridgid K-50 beroperasi secara mekanis murni');
        $response->assertSee('Jangkauan: 30 Meter');
        $response->assertSee('Motor 220V 400 RPM');
        $response->assertSee('Wastafel dapur mampet minyak');
        $response->assertSee('Wajib menggunakan sarung tangan anti-lilit');

        // Dynamic WhatsApp CTA
        $response->assertSee('https://wa.me/', false);
        $response->assertSee(rawurlencode($equipment->name), false);

        // SEO and Breadcrumb
        $response->assertSee(route('equipment.show', $equipment->slug));
        $response->assertSee('BreadcrumbList');
    }

    public function test_public_gets_404_for_invalid_or_inactive_equipment_slug(): void
    {
        // 1. Non-existent slug
        $response = $this->get('/tentang-kami/peralatan/alat-yang-tidak-ada');
        $response->assertNotFound();

        // 2. Inactive equipment
        $inactive = Equipment::create([
            'name' => 'Alat Rahasia Belum Rilis',
            'slug' => 'alat-rahasia-belum-rilis',
            'order' => 99,
            'is_active' => false,
        ]);

        $responseInactive = $this->get(route('equipment.show', $inactive->slug));
        $responseInactive->assertNotFound();
    }

    public function test_legacy_alias_route_redirects_to_detail(): void
    {
        $equipment = Equipment::create([
            'name' => 'Kamera CCTV Pipa Endoskopi 30M',
            'slug' => 'kamera-cctv-pipa-endoskopi-30m',
            'is_active' => true,
        ]);

        $response = $this->get('/peralatan/' . $equipment->slug);
        $response->assertRedirect(route('equipment.show', $equipment->slug));
    }

    public function test_equipment_listing_cards_link_to_detail_pages(): void
    {
        $equipment = Equipment::create([
            'name' => 'Mesin Spiral K-50 Ridgid',
            'slug' => 'mesin-spiral-k-50-ridgid',
            'category' => 'Mesin Utama',
            'short_description' => 'Melancarkan wastafel dan kloset.',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('about.equipment'));
        $response->assertOk();
        $response->assertSee(route('equipment.show', $equipment->slug));
    }

    public function test_admin_can_create_equipment_with_all_detail_fields(): void
    {
        $this->actingAs($this->adminUser);

        $payload = [
            'name' => 'Unit Hydro Jetting 200 Bar',
            'slug' => 'unit-hydro-jetting-200-bar',
            'category' => 'Hydro Jetting',
            'badge' => 'Tekanan Tinggi',
            'short_description' => 'Semburan air bertekanan tinggi 200 bar membilas lemak.',
            'description' => 'Pembersihan pipa skala berat restoran dan industri dengan pompa triplex.',
            'specs' => "Tekanan: 200 Bar\nPanjang Selang: 50 Meter",
            'features' => "Nozel rotary jetting\nPompa triplex heavy-duty",
            'applications' => "Saluran grease trap restoran\nPipa got tertutup komplek",
            'safety_k3' => 'Wajib helm dan face shield tahan tekanan air.',
            'order' => 5,
            'is_active' => '1',
        ];

        $response = $this->post(route('admin.equipments.store'), $payload);
        $response->assertRedirect(route('admin.equipments.index'));

        $this->assertDatabaseHas('equipments', [
            'name' => 'Unit Hydro Jetting 200 Bar',
            'slug' => 'unit-hydro-jetting-200-bar',
            'category' => 'Hydro Jetting',
            'badge' => 'Tekanan Tinggi',
            'is_active' => true,
        ]);

        $saved = Equipment::where('slug', 'unit-hydro-jetting-200-bar')->first();
        $this->assertNotNull($saved);
        $this->assertSame(['Tekanan: 200 Bar', 'Panjang Selang: 50 Meter'], $saved->specs_list);
        $this->assertSame(['Nozel rotary jetting', 'Pompa triplex heavy-duty'], $saved->features_list);
        $this->assertSame(['Saluran grease trap restoran', 'Pipa got tertutup komplek'], $saved->applications_list);
        $this->assertSame('Wajib helm dan face shield tahan tekanan air.', $saved->safety_k3);
    }

    public function test_admin_can_update_equipment_details(): void
    {
        $this->actingAs($this->adminUser);

        $equipment = Equipment::create([
            'name' => 'Kamera Inspeksi Lama',
            'slug' => 'kamera-inspeksi-lama',
            'category' => 'Diagnosis Visual',
            'description' => 'Deskripsi lama.',
            'order' => 2,
            'is_active' => true,
        ]);

        $updatePayload = [
            'name' => 'Kamera CCTV Pipa HD 1080P IP68',
            'slug' => 'kamera-cctv-pipa-hd-1080p-ip68',
            'category' => 'Diagnosis Visual',
            'badge' => 'Sensor HD Safir',
            'short_description' => 'Investigasi titik kebocoran pipa realtime.',
            'description' => 'Resolusi tinggi 1080P dengan lampu LED sorot adjustable lensa kristal safir.',
            'specs' => "Panjang: 30 Meter\nResolusi: 1080P Full HD",
            'features' => "Waterproof IP68\nRekaman video MP4",
            'applications' => "Deteksi pipa pecah\nInvestigasi akar pohon",
            'safety_k3' => 'Desinfeksi unit kamera pasca pengerjaan.',
            'order' => 2,
            'is_active' => '1',
        ];

        $response = $this->put(route('admin.equipments.update', $equipment), $updatePayload);
        $response->assertRedirect(route('admin.equipments.index'));

        $equipment->refresh();
        $this->assertSame('Kamera CCTV Pipa HD 1080P IP68', $equipment->name);
        $this->assertSame('kamera-cctv-pipa-hd-1080p-ip68', $equipment->slug);
        $this->assertSame('Sensor HD Safir', $equipment->badge);
        $this->assertSame(['Waterproof IP68', 'Rekaman video MP4'], $equipment->features_list);
    }
}

