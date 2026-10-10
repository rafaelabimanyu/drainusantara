<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Existing duplicate rows intentionally make this fail; migration never deletes data.
        Schema::table('coverage_areas', function (Blueprint $table): void {
            $table->unique(['city', 'district'], 'coverage_areas_city_district_unique');
        });
    }

    public function down(): void
    {
        Schema::table('coverage_areas', function (Blueprint $table): void {
            $table->dropUnique('coverage_areas_city_district_unique');
        });
    }
};
