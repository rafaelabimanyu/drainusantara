<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WarrantyConsistencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_warranty_copy_is_consistent_across_pages(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Garansi Tertulis 30 Hari Kalender');
        $response->assertDontSee('30 Hari Kerja');
        $response->assertDontSee('30 hari kerja');
    }
}
