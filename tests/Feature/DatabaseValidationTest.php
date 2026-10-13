<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DatabaseValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_coverage_pair_is_unique_on_create_and_update_but_update_ignores_itself(): void
    {
        $area = \App\Models\CoverageArea::create(['city' => 'Jakarta', 'district' => 'Tebet', 'slug' => 'jakarta-tebet']);
        $other = \App\Models\CoverageArea::create(['city' => 'Bogor', 'district' => 'Tebet', 'slug' => 'bogor-tebet']);
        $payload = ['city' => 'Jakarta', 'district' => 'Tebet'];
        $this->post('/admin/coverage-areas', $payload)->assertSessionHasErrors('district');
        $this->put('/admin/coverage-areas/'.$other->id, $payload)->assertSessionHasErrors('district');
        $this->putJson("/admin/coverage-areas/{$area->id}", $payload)->assertRedirect();
        $this->post('/admin/coverage-areas', ['city' => 'Depok', 'district' => 'Tebet'])->assertRedirect();
        $this->assertDatabaseHas('coverage_areas', ['id' => $other->id, 'city' => 'Bogor']);
        $this->assertDatabaseCount('coverage_areas', 3);
    }

    public static function requestMediaFields(): array
    {
        return [
            ['services', 'image_url', 'image', ['name' => 'Layanan']],
            ['equipments', 'image_url', 'image', ['name' => 'Alat']],
            ['staff', 'photo_url', 'photo', ['name' => 'Teknisi']],
            ['portfolios', 'image_url', 'image', ['client_name' => 'Klien']],
            ['articles', 'thumbnail_url', 'thumbnail', ['title' => 'Panduan', 'content' => 'Isi']],
            ['galleries', 'before_image_url', 'before_image', ['title' => 'Galeri']],
            ['galleries', 'after_image_url', 'after_image', ['title' => 'Galeri']],
            ['galleries', 'image_url', 'image', ['title' => 'Galeri']],
            ['reviews', 'avatar_url', 'avatar', ['customer_name' => 'Pelanggan', 'rating' => 5, 'comment' => 'Baik']],
        ];
    }

    #[DataProvider('requestMediaFields')]
    public function test_media_url_length_matches_database_for_create_and_update(string $resource, string $field, string $column, array $payload): void
    {
        $url = 'https://example.test/'.str_repeat('a', 233).'/';
        $this->assertSame(255, strlen($url));
        $this->postJson("/admin/{$resource}", [...$payload, $field => $url.'x'])
            ->assertUnprocessable()->assertJsonValidationErrors($field);
        $this->assertDatabaseCount($resource, 0);

        $this->postJson("/admin/{$resource}", [...$payload, $field => $url])->assertRedirect();
        $record = \Illuminate\Support\Facades\DB::table($resource)->first();
        $this->assertSame($url, $record->$column);
        $this->putJson("/admin/{$resource}/{$record->id}", [...$payload, $field => $url.'x'])
            ->assertUnprocessable()->assertJsonValidationErrors($field);
        $this->assertDatabaseHas($resource, ['id' => $record->id, $column => $url]);
        $this->putJson("/admin/{$resource}/{$record->id}", [...$payload, $field => $url])->assertRedirect();
    }
}
