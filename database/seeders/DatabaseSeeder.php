<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Services\CacheService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            ReviewSeeder::class,
            CoverageAreaSeeder::class,
            EquipmentSeeder::class,
            GallerySeeder::class,
            ArticleSeeder::class,
        ]);

        CacheService::clearPublicCache();
    }
}
