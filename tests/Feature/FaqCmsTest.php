<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_faq_admin(): void
    {
        $this->get(route('admin.faqs.index'))->assertRedirect(route('login'));
        $this->get(route('admin.faqs.create'))->assertRedirect(route('login'));
    }

    public function test_admin_can_view_faq_index_and_create_form(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.faqs.index'))
            ->assertOk()
            ->assertSee('Pusat Tanya Jawab (FAQ)')
            ->assertSee('Tambah FAQ Baru');

        $this->actingAs($admin)
            ->get(route('admin.faqs.create'))
            ->assertOk()
            ->assertSee('Tambah Pertanyaan & Jawaban (FAQ)');
    }

    public function test_admin_can_store_and_update_faq(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.faqs.store'), [
            'question' => 'Apakah aman untuk pipa PVC?',
            'answer' => 'Sangat aman menggunakan spiral rotary Ridgid.',
            'category' => 'teknis',
            'order' => 1,
            'is_active' => '1',
            'is_featured' => '1',
        ]);

        $response->assertRedirect(route('admin.faqs.index'));

        $faq = Faq::where('question', 'Apakah aman untuk pipa PVC?')->first();
        $this->assertNotNull($faq);
        $this->assertTrue($faq->is_active);
        $this->assertTrue($faq->is_featured);

        $updateResponse = $this->actingAs($admin)->put(route('admin.faqs.update', $faq), [
            'question' => 'Apakah aman untuk pipa PVC hunian?',
            'answer' => 'Sangat aman dan teruji tanpa soda api.',
            'category' => 'teknis',
            'order' => 2,
            'is_active' => '1',
            'is_featured' => '0',
        ]);

        $updateResponse->assertRedirect(route('admin.faqs.index'));
        $faq->refresh();
        $this->assertSame('Apakah aman untuk pipa PVC hunian?', $faq->question);
        $this->assertFalse($faq->is_featured);
    }

    public function test_admin_can_toggle_and_delete_faq(): void
    {
        $admin = User::factory()->create();
        $faq = Faq::create([
            'question' => 'Pertanyaan Toggle',
            'answer' => 'Jawaban Toggle',
            'category' => 'umum',
            'order' => 1,
            'is_active' => true,
        ]);

        $this->actingAs($admin)->post(route('admin.faqs.toggle', $faq))->assertRedirect();
        $this->assertFalse($faq->fresh()->is_active);

        $this->actingAs($admin)->delete(route('admin.faqs.destroy', $faq))
            ->assertRedirect(route('admin.faqs.index'));

        $this->assertNull(Faq::find($faq->id));
    }

    public function test_public_faq_page_renders_active_faqs_and_json_ld(): void
    {
        Faq::create([
            'question' => 'Apakah menggunakan soda api?',
            'answer' => 'Tidak pernah menggunakan soda api.',
            'category' => 'teknis',
            'order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Pertanyaan Rahasia',
            'answer' => 'Jawaban Rahasia',
            'category' => 'umum',
            'order' => 2,
            'is_active' => false,
        ]);

        $response = $this->get(route('about.faq'));
        $response->assertOk();
        $response->assertSee('Apakah menggunakan soda api?');
        $response->assertDontSee('Pertanyaan Rahasia');
        $response->assertSee('application/ld+json', false);
    }
}

