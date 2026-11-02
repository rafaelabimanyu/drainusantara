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
        if (! Schema::hasTable('company_pages')) {
            Schema::create('company_pages', function (Blueprint $table) {
                $table->id();
                $table->string('page_key')->unique();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('hero_image')->nullable();
                $table->longText('content')->nullable();
                $table->json('sections_data')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_pages');
    }
};
