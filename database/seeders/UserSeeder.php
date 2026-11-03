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
        $admin1 = User::firstOrNew(['email' => 'Drainusantara@admin']);
        if (! $admin1->exists) {
            $admin1->name = 'Drainusantara@admin';
            $admin1->password = Hash::make('Drainusantara123');
            $admin1->email_verified_at = now();
            $admin1->save();
        }

        $admin2 = User::firstOrNew(['email' => 'Drainusantara2@admin']);
        if (! $admin2->exists) {
            $admin2->name = 'Drainusantara2@admin';
            $admin2->password = Hash::make('Drainusantara 123');
            $admin2->email_verified_at = now();
            $admin2->save();
        }
    }
}

