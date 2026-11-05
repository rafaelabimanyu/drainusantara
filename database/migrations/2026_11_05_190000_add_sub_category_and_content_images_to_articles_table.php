<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'sub_category')) {
                $table->string('sub_category', 100)->nullable()->after('category');
            }
            if (!Schema::hasColumn('articles', 'content_images')) {
                $table->json('content_images')->nullable()->after('image_placement');
            }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('articles', 'sub_category')) {
                $columns[] = 'sub_category';
            }
            if (Schema::hasColumn('articles', 'content_images')) {
                $columns[] = 'content_images';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};

