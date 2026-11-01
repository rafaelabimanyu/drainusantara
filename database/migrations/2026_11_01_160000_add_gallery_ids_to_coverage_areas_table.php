<?php

declare(strict_types=1);

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
            if (! Schema::hasColumn('coverage_areas', 'gallery_ids')) {
                $table->json('gallery_ids')->nullable()->after('presence_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coverage_areas', function (Blueprint $table) {
            if (Schema::hasColumn('coverage_areas', 'gallery_ids')) {
                $table->dropColumn('gallery_ids');
            }
        });
    }
};

