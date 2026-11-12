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
        Schema::create('article_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 120);
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('article_subcategories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->constrained('article_categories')->cascadeOnDelete();
            $table->string('name', 120);
            $table->string('slug', 150);
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category_id', 'slug']);
        });

        Schema::table('articles', function (Blueprint $table): void {
            $table->foreignId('category_id')->nullable()->after('sub_category')->constrained('article_categories')->nullOnDelete();
            $table->foreignId('subcategory_id')->nullable()->after('category_id')->constrained('article_subcategories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table): void {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);
            $table->dropColumn(['category_id', 'subcategory_id']);
        });

        Schema::dropIfExists('article_subcategories');
        Schema::dropIfExists('article_categories');
    }
};
