<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFormsResponsiveTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_admin_form_views_render_responsive_layout_containers(): void
    {
        $endpoints = [
            route('admin.articles.create'),
            route('admin.portfolios.create'),
            route('admin.services.create'),
            route('admin.coverage-areas.create'),
            route('admin.equipments.create'),
            route('admin.faqs.create'),
            route('admin.galleries.create'),
            route('admin.reviews.create'),
            route('admin.staff.create'),
        ];

        foreach ($endpoints as $url) {
            $response = $this->actingAs($this->admin)->get($url);
            $response->assertOk();
            $content = $response->getContent();

            // Header should reflow on small screens
            $this->assertStringContainsString('flex flex-col sm:flex-row', $content, "Responsive header missing in $url");

            // Form container padding should scale responsively
            $this->assertStringContainsString('p-4 sm:p-6', $content, "Responsive card padding missing in $url");

            // Submit action buttons should stack on mobile
            $this->assertStringContainsString('flex flex-col-reverse sm:flex-row', $content, "Responsive action buttons missing in $url");
        }
    }
}

