<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CoverageArea;
use App\Services\AreaImageResolver;
use Illuminate\Console\Command;

class SyncAreaImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'areas:sync-images {--overwrite : Overwrite custom uploaded images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync auto-matched local area image assets into coverage_areas database records';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $overwrite = (bool) $this->option('overwrite');
        $this->info("Scanning and syncing area images (Overwrite: " . ($overwrite ? 'YES' : 'NO') . ")...");

        $areas = CoverageArea::orderBy('id')->get();
        $updated = 0;
        $skipped = 0;

        foreach ($areas as $area) {
            $hasExistingCustom = ! empty($area->hero_image);

            if ($hasExistingCustom && ! $overwrite) {
                $skipped++;
                continue;
            }

            $resolved = AreaImageResolver::resolve($area);
            $newPath = $resolved['path'];

            // Only update if source is from local assets (district, city, province)
            if (in_array($resolved['source'], ['district_asset', 'city_asset', 'province_asset'], true)) {
                $area->hero_image = $newPath;

                // Also populate presence_image if empty
                if (empty($area->presence_image)) {
                    $area->presence_image = $newPath;
                }

                $area->save();
                $updated++;
            } else {
                $skipped++;
            }
        }

        $this->info("Area images sync completed!");
        $this->table(
            ['Total Areas', 'Updated', 'Preserved / Skipped'],
            [[$areas->count(), $updated, $skipped]]
        );

        return self::SUCCESS;
    }
}

