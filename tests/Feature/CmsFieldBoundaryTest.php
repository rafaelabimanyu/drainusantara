<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CmsFieldBoundaryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        if (getenv('DB_CONNECTION') === 'mysql') {
            $this->assertSame('mysql', DB::connection()->getDriverName());
            $this->assertStringStartsWith('drainusantara_test_', DB::connection()->getDatabaseName());
        }
        $this->actingAs(User::factory()->create());
    }

    public static function optionalFields(): array
    {
        $resources = [
            ['portfolios', 'portfolios', ['client_name' => 'Klien'], ['client_type', 'location', 'project_title', 'description']],
            ['articles', 'articles', ['title' => 'Panduan', 'content' => 'Isi'], ['category', 'excerpt', 'meta_title', 'meta_description']],
            ['coverage-areas', 'coverage_areas', ['city' => 'Jakarta', 'district' => 'Tebet'], ['postal_code', 'meta_title', 'meta_description', 'content']],
            ['staff', 'staff', ['name' => 'Teknisi'], ['role', 'initials']],
            ['equipments', 'equipments', ['name' => 'Alat'], ['category', 'badge', 'short_description']],
            ['services', 'services', ['name' => 'Layanan'], ['short_description', 'description']],
            ['galleries', 'galleries', ['title' => 'Galeri'], ['description']],
            ['reviews', 'reviews', ['customer_name' => 'Pelanggan', 'rating' => 5, 'comment' => 'Baik'], ['customer_role_or_location']],
        ];
        $cases = [];
        foreach ($resources as [$resource, $table, $payload, $fields]) {
            foreach ($fields as $field) {
                $cases["{$resource}.{$field}"] = [$resource, $table, $payload, $field];
            }
        }
        return $cases;
    }

    #[DataProvider('optionalFields')]
    public function test_optional_field_preserves_absence_and_clears_submitted_null(string $resource, string $table, array $payload, string $field): void
    {
        $this->postJson("/admin/{$resource}", [...$payload, $field => 'Saved'])->assertRedirect();
        $id = DB::table($table)->value('id');
        $this->putJson("/admin/{$resource}/{$id}", $payload)->assertRedirect();
        $this->assertDatabaseHas($table, ['id' => $id, $field => 'Saved']);
        foreach ([null, ''] as $empty) {
            $this->putJson("/admin/{$resource}/{$id}", [...$payload, $field => 'Saved'])->assertRedirect();
            $this->putJson("/admin/{$resource}/{$id}", [...$payload, $field => $empty])->assertRedirect();
            $this->assertDatabaseHas($table, ['id' => $id, $field => null]);
        }
    }

    public static function rawMedia(): array
    {
        return [
            ['equipments', 'image', ['name' => 'Alat']],
            ['staff', 'photo', ['name' => 'Teknisi']],
            ['portfolios', 'image', ['client_name' => 'Klien']],
            ['articles', 'thumbnail', ['title' => 'Panduan', 'content' => 'Isi']],
            ['galleries', 'before_image', ['title' => 'Galeri']],
            ['galleries', 'after_image', ['title' => 'Galeri']],
            ['galleries', 'image', ['title' => 'Galeri']],
        ];
    }

    #[DataProvider('rawMedia')]
    public function test_legacy_media_strings_obey_column_limit(string $resource, string $field, array $payload): void
    {
        $url = 'https://example.test/'.str_repeat('a', 234);
        $this->assertSame(255, strlen($url));
        $this->postJson("/admin/{$resource}", [...$payload, $field => $url.'x'])
            ->assertUnprocessable()->assertJsonValidationErrors($field);
        $this->assertDatabaseCount($resource, 0);
        $this->postJson("/admin/{$resource}", [...$payload, $field => $url])->assertRedirect();
        $record = DB::table($resource)->first();
        $this->assertSame($url, $record->$field);
        $this->putJson("/admin/{$resource}/{$record->id}", [...$payload, $field => $url.'x'])
            ->assertUnprocessable()->assertJsonValidationErrors($field);
        $this->assertDatabaseHas($resource, ['id' => $record->id, $field => $url]);
    }

    public static function slugInputs(): array
    {
        return [
            ['articles', 'articles', ['title' => str_repeat('a', 255), 'content' => 'Isi', 'meta_title' => 'Custom', 'thumbnail_url' => 'https://example.test/image.webp']],
            ['services', 'services', ['name' => str_repeat('a', 255), 'image_url' => 'https://example.test/image.webp']],
            ['articles', 'articles', ['title' => str_repeat('щ', 255), 'content' => 'Isi', 'meta_title' => 'Custom', 'thumbnail_url' => 'https://example.test/image.webp']],
            ['services', 'services', ['name' => str_repeat('щ', 255), 'image_url' => 'https://example.test/image.webp']],
            ['coverage-areas', 'coverage_areas', ['city' => str_repeat('щ', 100), 'district' => str_repeat('ю', 100)]],
        ];
    }

    #[DataProvider('slugInputs')]
    public function test_generated_slug_and_collision_fit_column(string $resource, string $table, array $payload): void
    {
        $this->postJson("/admin/{$resource}", $payload)->assertRedirect();
        if ($resource === 'coverage-areas') {
            $payload['district'] = str_repeat('ю', 99).'я';
        }
        for ($i = 0; $i < 11; $i++) {
            if ($resource === 'coverage-areas' && $i > 0) {
                break;
            }
            $this->postJson("/admin/{$resource}", $payload)->assertRedirect();
        }
        $slugs = DB::table($table)->pluck('slug');
        $this->assertCount($slugs->count(), $slugs->unique());
        foreach ($slugs as $slug) {
            $this->assertNotEmpty($slug);
            $this->assertLessThanOrEqual(255, strlen($slug));
        }
    }

    public static function placeholders(): array
    {
        return [
            ['articles', 'thumbnail', ['title' => str_repeat('é', 255), 'content' => 'Isi', 'meta_title' => 'Custom']],
            ['services', 'image', ['name' => str_repeat('é', 255)]],
        ];
    }

    #[DataProvider('placeholders')]
    public function test_encoded_placeholder_fits_column(string $resource, string $column, array $payload): void
    {
        $this->postJson("/admin/{$resource}", $payload)->assertRedirect();
        $url = DB::table($resource)->value($column);
        $this->assertLessThanOrEqual(255, strlen($url));
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        $this->assertTrue(mb_check_encoding($query['text'], 'UTF-8'));
        $this->assertNotEmpty($query['text']);
    }

    public static function generatedMetadata(): array
    {
        return [
            'article' => ['articles', 'articles', ['title' => str_repeat('a', 255), 'content' => 'Isi', 'thumbnail_url' => 'https://example.test/image.webp']],
            'area' => ['coverage-areas', 'coverage_areas', ['city' => str_repeat('a', 100), 'district' => str_repeat('b', 100)]],
        ];
    }

    #[DataProvider('generatedMetadata')]
    public function test_generated_metadata_fits_column(string $resource, string $table, array $payload): void
    {
        $this->postJson("/admin/{$resource}", $payload)->assertRedirect();
        $record = DB::table($table)->first();
        $this->assertNotEmpty($record->meta_title);
        $this->assertLessThanOrEqual(255, mb_strlen($record->meta_title));
    }
}
