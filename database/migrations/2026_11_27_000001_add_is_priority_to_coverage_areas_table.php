<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('coverage_areas', 'is_priority')) {
            Schema::table('coverage_areas', function (Blueprint $table): void {
                $table->boolean('is_priority')->default(true)->after('is_active')->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('coverage_areas', 'is_priority')) {
            Schema::table('coverage_areas', function (Blueprint $table): void {
                $table->dropIndex(['is_priority']);
                $table->dropColumn('is_priority');
            });
        }
    }
};
