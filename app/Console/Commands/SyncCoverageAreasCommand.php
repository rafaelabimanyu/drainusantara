<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CoverageArea;
use Illuminate\Console\Command;

class SyncCoverageAreasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regions:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize coverage areas from RegionService master hierarchy into the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting synchronization of coverage areas from RegionService...');

        $result = CoverageArea::syncFromMaster();

        $this->info('Synchronization complete.');
        $this->table(
            ['Metric', 'Count'],
            [
                ['New Areas Created', $result['created']],
                ['Existing Areas Preserved', $result['existing']],
                ['Total Coverage Areas', $result['total']],
            ]
        );

        return self::SUCCESS;
    }
}

