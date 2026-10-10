<?php

namespace Tests\MySql;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CoverageConstraintTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('mysql', DB::connection()->getDriverName());
        $this->assertMatchesRegularExpression('/^drainusantara_test_[a-f0-9]{12}$/', DB::connection()->getDatabaseName());
        $this->artisan('migrate:fresh', ['--force' => true])->assertSuccessful();
    }

    public function test_database_rejects_duplicate_pair_without_losing_original(): void
    {
        DB::table('coverage_areas')->insert(['city' => 'Jakarta', 'district' => 'Tebet', 'slug' => 'first']);
        try {
            DB::table('coverage_areas')->insert(['city' => 'jakarta', 'district' => 'tebet', 'slug' => 'second']);
            $this->fail('Database accepted duplicate city/district.');
        } catch (QueryException $exception) {
            $this->assertSame(1062, $exception->errorInfo[1]);
        }
        $this->assertDatabaseCount('coverage_areas', 1);
    }

    public function test_additive_migration_refuses_legacy_duplicates_without_deleting_them(): void
    {
        $migration = require database_path('migrations/2026_10_10_120000_add_unique_city_district_to_coverage_areas_table.php');
        $migration->down();
        DB::table('coverage_areas')->insert([
            ['city' => 'Jakarta', 'district' => 'Tebet', 'slug' => 'first'],
            ['city' => 'jakarta', 'district' => 'tebet', 'slug' => 'second'],
        ]);
        try {
            $migration->up();
            $this->fail('Migration accepted duplicate city/district.');
        } catch (QueryException $exception) {
            $this->assertSame(1062, $exception->errorInfo[1]);
        }
        $this->assertDatabaseCount('coverage_areas', 2);
    }
}
