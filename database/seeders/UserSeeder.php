<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'Drainusantara@admin'],
            [
                'name' => 'Drainusantara@admin',
                'password' => Hash::make('Drainusantara123'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'Drainusantara2@admin'],
            [
                'name' => 'Drainusantara2@admin',
                'password' => Hash::make('Drainusantara 123'),
                'email_verified_at' => now(),
            ]
        );
    }
}

