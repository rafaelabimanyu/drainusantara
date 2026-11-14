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
            if (!Schema::hasIndex('articles', ['is_published', 'published_at'])) {
                $table->index(['is_published', 'published_at']);
            }
            if (!Schema::hasIndex('articles', ['category'])) {
                $table->index('category');
            }
        });

        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasIndex('galleries', ['is_active'])) {
                $table->index('is_active');
            }
            if (!Schema::hasIndex('galleries', ['order'])) {
                $table->index('order');
            }
            if (!Schema::hasIndex('galleries', ['location'])) {
                $table->index('location');
            }
        });

        Schema::table('portfolios', function (Blueprint $table) {
            if (!Schema::hasIndex('portfolios', ['is_active'])) {
                $table->index('is_active');
            }
            if (!Schema::hasIndex('portfolios', ['client_type'])) {
                $table->index('client_type');
            }
        });

        Schema::table('coverage_areas', function (Blueprint $table) {
            if (!Schema::hasIndex('coverage_areas', ['is_active'])) {
                $table->index('is_active');
            }
            if (!Schema::hasIndex('coverage_areas', ['type'])) {
                $table->index('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coverage_areas', function (Blueprint $table) {
            if (Schema::hasIndex('coverage_areas', ['is_active'])) {
                $table->dropIndex(['is_active']);
            }
        });

        Schema::table('portfolios', function (Blueprint $table) {
            if (Schema::hasIndex('portfolios', ['is_active'])) {
                $table->dropIndex(['is_active']);
            }
            if (Schema::hasIndex('portfolios', ['client_type'])) {
                $table->dropIndex(['client_type']);
            }
        });

        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasIndex('galleries', ['is_active'])) {
                $table->dropIndex(['is_active']);
            }
            if (Schema::hasIndex('galleries', ['order'])) {
                $table->dropIndex(['order']);
            }
            if (Schema::hasIndex('galleries', ['location'])) {
                $table->dropIndex(['location']);
            }
        });

        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasIndex('articles', ['is_published', 'published_at'])) {
                $table->dropIndex(['is_published', 'published_at']);
            }
            if (Schema::hasIndex('articles', ['category'])) {
                $table->dropIndex(['category']);
            }
        });
    }
};
