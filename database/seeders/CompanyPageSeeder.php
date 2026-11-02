<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CompanyPage;
use Illuminate\Database\Seeder;

class CompanyPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keys = [
            'profil',
            'cara-kerja',
            'holding',
            'sop-k3',
            'peralatan',
            'kemitraan',
            'garansi',
        ];

        foreach ($keys as $key) {
            CompanyPage::getByKey($key);
        }
    }
}

