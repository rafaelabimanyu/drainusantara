<?php

namespace Tests\Feature;

use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialsTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_displays_active_cms_review_with_escaped_content(): void
    {
        Review::create([
            'customer_name' => 'Pelanggan Uji <b>CMS</b>',
            'customer_role_or_location' => 'Lokasi Uji',
            'comment' => '<script>alert("test")</script>',
            'rating' => 4,
            'is_active' => true,
        ]);
        Review::create([
            'customer_name' => 'Ulasan Nonaktif',
            'comment' => 'Komentar yang tidak boleh tampil',
            'rating' => 2,
            'is_active' => false,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Pelanggan Uji <b>CMS</b>')
            ->assertSee('<script>alert("test")</script>')
            ->assertSee('aria-label="Rating 4 Bintang"', false)
            ->assertDontSee('<script>alert("test")</script>', false)
            ->assertDontSee('Ulasan Nonaktif')
            ->assertDontSee('Ibu Ratna Dewi');
    }

    public function test_home_hides_testimonials_when_no_active_reviews_exist(): void
    {
        Review::create([
            'customer_name' => 'Ulasan Nonaktif',
            'comment' => 'Tidak diterbitkan',
            'rating' => 3,
            'is_active' => false,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('id="pengalaman"', false)
            ->assertDontSee('Chef Adrian');
    }

    public function test_component_without_reviews_renders_no_testimonial_section(): void
    {
        $this->blade('<x-landing-page.testimonials />')
            ->assertDontSee('id="pengalaman"', false);
    }
}
