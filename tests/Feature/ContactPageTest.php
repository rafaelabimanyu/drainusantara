<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_contact_page(): void
    {
        $response = $this->get(route('contact'));
        $response->assertOk();
        $response->assertSee('Hubungi Posko Teknisi Drainusantara');
        $response->assertSee('0856-0900-9009');
        $response->assertSee('Form Permohonan Layanan');
    }

    public function test_guest_can_submit_contact_form(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Bpk. Hendra Gunawan',
            'phone' => '081234567890',
            'city' => 'Kota Bandung',
            'district' => 'Coblong',
            'service_type' => 'Wastafel & Cuci Piring',
            'property_type' => 'Rumah Tinggal',
            'message' => 'Saluran cuci piring meluap sejak kemarin sore, butuh penanganan segera.',
            'website_url' => '', // empty honeypot
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('direct_wa_url');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Bpk. Hendra Gunawan',
            'phone' => '081234567890',
            'city' => 'Kota Bandung',
            'status' => 'new',
        ]);
    }

    public function test_honeypot_silently_ignores_spam_bots(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Spam Bot',
            'phone' => '0899999999',
            'message' => 'Spam content',
            'website_url' => 'https://spam-link.com', // filled honeypot
        ]);

        $response->assertRedirect(route('contact'));
        $this->assertDatabaseMissing('contact_messages', [
            'name' => 'Spam Bot',
        ]);
    }

    public function test_guest_cannot_access_contacts_cms(): void
    {
        $response = $this->get(route('admin.contacts.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_and_manage_contacts(): void
    {
        $admin = User::factory()->create();
        $message = ContactMessage::create([
            'name' => 'Ibu Rina',
            'phone' => '087788990011',
            'city' => 'Kota Semarang',
            'district' => 'Banyumanik',
            'service_type' => 'Kloset & WC Meluap',
            'property_type' => 'Rumah Tinggal',
            'message' => 'Kloset lantai 1 meluap saat disiram.',
            'status' => 'new',
        ]);

        // List
        $responseList = $this->actingAs($admin)->get(route('admin.contacts.index'));
        $responseList->assertOk();
        $responseList->assertSee('Ibu Rina');
        $responseList->assertSee('087788990011');

        // Show
        $responseShow = $this->actingAs($admin)->get(route('admin.contacts.show', $message));
        $responseShow->assertOk();
        $responseShow->assertSee('Kloset lantai 1 meluap saat disiram.');

        // Update status & notes
        $responseUpdate = $this->actingAs($admin)->put(route('admin.contacts.update', $message), [
            'status' => 'in_progress',
            'admin_notes' => 'Teknisi Joko armada Semarang sedang meluncur.',
        ]);
        $responseUpdate->assertRedirect();
        $responseUpdate->assertSessionHas('success');

        $message->refresh();
        $this->assertEquals('in_progress', $message->status);
        $this->assertEquals('Teknisi Joko armada Semarang sedang meluncur.', $message->admin_notes);

        // Delete
        $responseDelete = $this->actingAs($admin)->delete(route('admin.contacts.destroy', $message));
        $responseDelete->assertRedirect(route('admin.contacts.index'));
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }
}
