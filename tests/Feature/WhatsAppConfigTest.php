<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class WhatsAppConfigTest extends TestCase
{
    use RefreshDatabase;
    public function test_deploy_check_rejects_placeholder_or_invalid_number(): void
    {
        foreach (['628xxxxx', '6281234567890', '081234567890', '62812 34567890', ''] as $number) {
            config(['app.whatsapp_number' => $number]);
            $this->assertSame(1, Artisan::call('deploy:check'), "Should reject $number");
        }
    }

    public function test_deploy_check_accepts_international_indonesian_number(): void
    {
        config(['app.whatsapp_number' => '6285609009009']);
        $this->assertSame(0, Artisan::call('deploy:check'));
    }

    public function test_google_verification_file_accessible_and_valid(): void
    {
        $filePath = public_path('google7b5352bb363c1dd7.html');
        $this->assertFileExists($filePath);
        $this->assertSame('google-site-verification: google7b5352bb363c1dd7.html', trim(file_get_contents($filePath)));
    }

    public function test_meta_tag_and_json_ld_schema_phone_on_homepage(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('<meta name="google-site-verification" content="aoHQ2ZJhlGecoaMyq4c-0pnAqdqj6AViTLZUPxDbKgw">', false);
        $response->assertSee('"telephone":"+6285609009009"', false);
        $response->assertSee('https://wa.me/6285609009009', false);
    }
}
