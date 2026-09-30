<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReviewTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@drainusantara.com',
        ]);
    }

    public function test_guest_cannot_access_reviews_admin(): void
    {
        $response = $this->get(route('admin.reviews.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_reviews_list(): void
    {
        Review::create([
            'customer_name' => 'Budi Santoso',
            'customer_role_or_location' => 'Kelapa Gading, Jakarta Utara',
            'rating' => 5,
            'comment' => 'Pelayanan sangat cepat dan pipa wastafel lancar kembali tanpa bongkar!',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.reviews.index'));

        $response->assertOk();
        $response->assertSee('Budi Santoso');
        $response->assertSee('Kelapa Gading, Jakarta Utara');
    }

    public function test_admin_can_create_review(): void
    {
        $service = Service::create([
            'name' => 'Wastafel Mampet',
            'slug' => 'wastafel-mampet',
            'price_starting_from' => 400000,
            'is_active' => true,
        ]);

        $payload = [
            'customer_name' => 'Siti Aminah',
            'customer_role_or_location' => 'Tebet, Jakarta Selatan',
            'rating' => 5,
            'comment' => 'Kloset mampet langsung tuntas dalam 30 menit. Mantap!',
            'service_id' => $service->id,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.reviews.store'), $payload);

        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseHas('reviews', [
            'customer_name' => 'Siti Aminah',
            'rating' => 5,
        ]);
    }

    public function test_admin_can_update_review(): void
    {
        $review = Review::create([
            'customer_name' => 'Pak Joko',
            'customer_role_or_location' => 'BSD City',
            'rating' => 4,
            'comment' => 'Ulasan awal sebelum diedit.',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.reviews.update', $review), [
            'customer_name' => 'Pak Joko Widodo',
            'customer_role_or_location' => 'BSD City, Tangerang',
            'rating' => 5,
            'comment' => 'Ulasan baru yang sudah diperbarui.',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'customer_name' => 'Pak Joko Widodo',
            'rating' => 5,
        ]);
    }

    public function test_admin_can_delete_review(): void
    {
        $review = Review::create([
            'customer_name' => 'Hapus Saya',
            'rating' => 3,
            'comment' => 'Komentar untuk dihapus.',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.reviews.destroy', $review));

        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }
}
