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
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('client_name');
            $table->string('partnership_type')->nullable()->after('client_type');
            $table->string('duration')->nullable()->after('location');
            $table->text('about_client')->nullable()->after('description');
            $table->text('scope_of_work')->nullable()->after('about_client');
            $table->text('results_benefit')->nullable()->after('scope_of_work');
            $table->text('testimoni_quote')->nullable()->after('results_benefit');
            $table->string('testimoni_name')->nullable()->after('testimoni_quote');
            $table->string('testimoni_title')->nullable()->after('testimoni_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropUnique('portfolios_slug_unique');
            $table->dropColumn([
                'slug',
                'partnership_type',
                'duration',
                'about_client',
                'scope_of_work',
                'results_benefit',
                'testimoni_quote',
                'testimoni_name',
                'testimoni_title',
            ]);
        });
    }
};
