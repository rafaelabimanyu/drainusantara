<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CoverageArea;
use App\Services\HyperLocalTaxonomy;
use App\Services\RegionService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class EnrichAreaHyperLocalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'area:enrich-hyperlocal {--force : Overwrite existing database fields}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enrich coverage area districts with hyper-local context, landmarks, faqs, and keywords';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $force = (bool) $this->option('force');
        $districts = CoverageArea::whereNotNull('district')
            ->whereNotIn('district', ['[KOTA]', '[PROVINSI]'])
            ->get();

        $this->info("Starting hyper-local enrichment for {$districts->count()} districts (force: " . ($force ? 'yes' : 'no') . ')...');

        $updated = 0;
        $skipped = 0;

        foreach ($districts as $area) {
            $cityData = RegionService::findCity($area->city);
            $citySlug = $cityData['slug'] ?? Str::slug($area->city);
            $profile = HyperLocalTaxonomy::getDistrictProfile($citySlug, $area->district, $area->city, $area->resolved_price);
            $keywords = HyperLocalTaxonomy::getKeywords($area->district, $area->city, $profile['landmarks']);

            $needsSave = false;

            if ($force || empty($area->presence_description)) {
                $area->presence_description = "Drainusantara hadir secara resmi di {$area->district}, {$area->city} dengan posko armada respons cepat. {$profile['problem_desc']}";
                $needsSave = true;
            }

            if ($force || empty($area->supporting_tags)) {
                $area->supporting_tags = $profile['landmarks'];
                $needsSave = true;
            }

            if ($force || empty($area->faqs)) {
                $area->faqs = $profile['faqs'];
                $needsSave = true;
            }

            if ($force || empty($area->geo_keywords)) {
                $area->geo_keywords = implode(', ', $keywords);
                $needsSave = true;
            }

            if ($needsSave) {
                $area->save();
                $updated++;
            } else {
                $skipped++;
            }
        }

        $this->info("Hyper-local enrichment complete: {$updated} updated, {$skipped} skipped.");

        return self::SUCCESS;
    }
}
