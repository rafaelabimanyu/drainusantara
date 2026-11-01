<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('coverage_areas', function (Blueprint $table) {
            $table->string('type', 20)->default('district')->index()->after('id');
            $table->string('province_name', 100)->nullable()->after('type');
            $table->string('presence_image')->nullable()->after('hero_image');
            $table->text('presence_description')->nullable()->after('presence_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coverage_areas', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropColumn(['type', 'province_name', 'presence_image', 'presence_description']);
        });
    }
};
