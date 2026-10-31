<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Service;
use App\Services\CacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AiCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        CacheService::clearPublicCache();
    }

    public function test_well_known_ai_catalog_endpoint_returns_success_and_valid_cors_headers(): void
    {
        $response = $this->get('/.well-known/ai-catalog.json');

        $response->assertStatus(200);
        $response->assertHeader('Access-Control-Allow-Origin', '*');
        $this->assertStringContainsString('application/json', (string) $response->headers->get('Content-Type'));
        $this->assertStringContainsString('max-age=3600', (string) $response->headers->get('Cache-Control'));
    }

    public function test_ai_catalog_alias_endpoint_returns_success(): void
    {
        $response = $this->get('/ai-catalog.json');

        $response->assertStatus(200);
        $response->assertHeader('Access-Control-Allow-Origin', '*');
        $this->assertStringContainsString('application/json', (string) $response->headers->get('Content-Type'));
    }

    public function test_ai_catalog_adheres_to_ard_v1_specification_schema(): void
    {
        $response = $this->get('/.well-known/ai-catalog.json');
        $data = $response->json();

        $this->assertIsArray($data);
        $this->assertSame('1.0', $data['specVersion'] ?? null);

        // Host block validation
        $this->assertIsArray($data['host'] ?? null);
        $this->assertSame('Drainusantara', $data['host']['displayName'] ?? null);
        $this->assertSame('did:web:drainusantara.com', $data['host']['identifier'] ?? null);
        $this->assertNotEmpty($data['host']['documentationUrl'] ?? null);

        // Entries block validation
        $this->assertIsArray($data['entries'] ?? null);
        $this->assertGreaterThanOrEqual(8, count($data['entries']));

        foreach ($data['entries'] as $entry) {
            $this->assertIsArray($entry);
            $this->assertArrayHasKey('identifier', $entry);
            $this->assertStringStartsWith('urn:air:drainusantara.com:', $entry['identifier']);

            $this->assertArrayHasKey('displayName', $entry);
            $this->assertNotEmpty($entry['displayName']);

            $this->assertArrayHasKey('type', $entry);
            $this->assertNotEmpty($entry['type']);

            $this->assertArrayHasKey('description', $entry);
            $this->assertNotEmpty($entry['description']);

            $this->assertArrayHasKey('representativeQueries', $entry);
            $this->assertIsArray($entry['representativeQueries']);
            $this->assertNotEmpty($entry['representativeQueries']);

            // Strict Value-or-Reference Rule: Must have 'url' OR 'data', never both, never neither
            $hasUrl = array_key_exists('url', $entry) && ! empty($entry['url']);
            $hasData = array_key_exists('data', $entry) && ! empty($entry['data']);
            $this->assertTrue(
                $hasUrl xor $hasData,
                "Entry '{$entry['identifier']}' must have either 'url' or 'data', not both or neither."
            );
        }
    }

    public function test_ai_catalog_contains_essential_drainusantara_capabilities(): void
    {
        $response = $this->get('/.well-known/ai-catalog.json');
        $entries = collect($response->json('entries'));

        $identifiers = $entries->pluck('identifier')->all();

        $this->assertContains('urn:air:drainusantara.com:action:emergency-dispatch', $identifiers);
        $this->assertContains('urn:air:drainusantara.com:tool:quick-quote', $identifiers);
        $this->assertContains('urn:air:drainusantara.com:catalog:services', $identifiers);
        $this->assertContains('urn:air:drainusantara.com:geo:coverage-areas', $identifiers);
        $this->assertContains('urn:air:drainusantara.com:fleet:equipment', $identifiers);
        $this->assertContains('urn:air:drainusantara.com:content:case-studies', $identifiers);
        $this->assertContains('urn:air:drainusantara.com:content:knowledge-base', $identifiers);
        $this->assertContains('urn:air:drainusantara.com:feed:llms-txt', $identifiers);
    }

    public function test_robots_txt_is_valid_and_has_no_unknown_directives(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('User-agent: *', $content);
        $this->assertStringContainsString('Sitemap:', $content);
        $this->assertStringNotContainsString('Agentmap:', $content);
    }

    public function test_home_page_includes_ai_catalog_discovery_links(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<link rel="ai-catalog" type="application/json"', false);
        $response->assertSee('<link rel="agentmap"', false);
        $response->assertSee('/.well-known/ai-catalog.json', false);
    }
}

