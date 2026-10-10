<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class WhatsAppConfigTest extends TestCase
{
    public function test_deploy_check_rejects_placeholder_or_invalid_number(): void
    {
        foreach (['628xxxxx', '6281234567890', '081234567890', '62812 34567890', ''] as $number) {
            config(['app.whatsapp_number' => $number]);
            $this->assertSame(1, Artisan::call('deploy:check'), "Should reject $number");
        }
    }

    public function test_deploy_check_accepts_international_indonesian_number(): void
    {
        config(['app.whatsapp_number' => '6285789432109']);
        $this->assertSame(0, Artisan::call('deploy:check'));
    }
}
