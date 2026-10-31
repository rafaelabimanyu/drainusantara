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
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('location')->nullable()->after('category');
            $table->json('property_type')->nullable()->after('location');
            $table->json('problem_type')->nullable()->after('property_type');
            $table->string('severity')->nullable()->after('problem_type');
            $table->string('duration')->nullable()->after('severity');
            $table->longText('content')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropUnique('galleries_slug_unique');
            $table->dropColumn(['slug', 'location', 'property_type', 'problem_type', 'severity', 'duration', 'content']);
        });
    }
};
