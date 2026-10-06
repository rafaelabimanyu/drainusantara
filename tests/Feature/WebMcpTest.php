<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebMcpTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render_webmcp_data_script(): void
    {
        Service::create([
            'name' => 'Wastafel Mampet',
            'slug' => 'wastafel-mampet',
            'short_description' => 'Pelancaran wastafel tanpa bongkar keramik.',
            'price_starting_from' => 400000,
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="drainusantara-webmcp-data"', false);

        // Extract JSON and verify structure
        $content = $response->getContent();
        preg_match('/<script type="application\/json" id="drainusantara-webmcp-data">\s*(\{.*?\})\s*<\/script>/s', $content, $matches);
        $this->assertNotEmpty($matches, 'WebMCP script tag not found or malformed.');

        $data = json_decode($matches[1], true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('services', $data);
        $this->assertArrayHasKey('whatsappNumber', $data);
        $this->assertArrayHasKey('baseUrl', $data);

        $this->assertCount(1, $data['services']);
        $this->assertEquals('Wastafel Mampet', $data['services'][0]['name']);
        $this->assertEquals(400000, $data['services'][0]['price_starting_from']);
    }

    public function test_admin_and_auth_pages_do_not_expose_webmcp_data(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertDontSee('id="drainusantara-webmcp-data"', false);
    }
}
