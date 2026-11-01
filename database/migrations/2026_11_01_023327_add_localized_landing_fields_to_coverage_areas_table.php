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
            $table->unsignedInteger('starting_price')->nullable()->after('postal_code');
            $table->text('geo_keywords')->nullable()->after('meta_description');
            $table->decimal('latitude', 10, 7)->nullable()->after('geo_keywords');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('posko_name')->nullable()->after('hero_image');
            $table->text('posko_address')->nullable()->after('posko_name');
            $table->string('posko_coverage_radius')->nullable()->after('posko_address');
            $table->string('cta_headline')->nullable()->after('posko_coverage_radius');
            $table->string('cta_button_text')->nullable()->after('cta_headline');
            $table->text('cta_whatsapp_text')->nullable()->after('cta_button_text');
            $table->json('advantages')->nullable()->after('faqs');
            $table->json('service_categories')->nullable()->after('advantages');
            $table->json('comparison_data')->nullable()->after('service_categories');
            $table->json('supporting_tags')->nullable()->after('comparison_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coverage_areas', function (Blueprint $table) {
            $table->dropColumn([
                'starting_price',
                'geo_keywords',
                'latitude',
                'longitude',
                'posko_name',
                'posko_address',
                'posko_coverage_radius',
                'cta_headline',
                'cta_button_text',
                'cta_whatsapp_text',
                'advantages',
                'service_categories',
                'comparison_data',
                'supporting_tags',
            ]);
        });
    }
};
