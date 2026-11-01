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
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'views_count')) {
                $table->unsignedBigInteger('views_count')->default(0)->after('is_published');
            }
            if (!Schema::hasColumn('articles', 'image_placement')) {
                $table->string('image_placement', 30)->default('content')->after('thumbnail');
            }
            if (!Schema::hasColumn('articles', 'tags')) {
                $table->text('tags')->nullable()->after('category');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('articles', 'views_count')) {
                $columnsToDrop[] = 'views_count';
            }
            if (Schema::hasColumn('articles', 'image_placement')) {
                $columnsToDrop[] = 'image_placement';
            }
            if (Schema::hasColumn('articles', 'tags')) {
                $columnsToDrop[] = 'tags';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};

