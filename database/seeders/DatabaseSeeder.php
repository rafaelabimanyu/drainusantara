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
            UserSeeder::class,
            ServiceSeeder::class,
            CoverageAreaSeeder::class,
            CompanyPageSeeder::class,
            EquipmentSeeder::class,
            GallerySeeder::class,
            FaqSeeder::class,
            BaliAreaSeeder::class,
            ReviewSeeder::class,
            ArticleSeeder::class,
        ]);

        CacheService::clearPublicCache();
    }
}
