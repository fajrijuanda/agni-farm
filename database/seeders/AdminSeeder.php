<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Superadmin (no region, full access)
        User::updateOrCreate(
            ['email' => 'superadmin@agnifarm.com'],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@agnifarm.com',
                'password' => Hash::make('superadmin123'),
                'is_admin' => true,
                'role' => 'superadmin',
                'region_id' => null,
            ]
        );

        $this->command->info('=== SUPERADMIN ===');
        $this->command->info('Email: superadmin@agnifarm.com');
        $this->command->info('Password: superadmin123');
        $this->command->newLine();

        // Create Regional Admins
        $regions = Region::all();

        if ($regions->isEmpty()) {
            $this->command->warn('No regions found. Please run RegionSeeder first.');
            return;
        }

        $this->command->info('=== REGIONAL ADMINS ===');

        foreach ($regions as $region) {
            $email = 'admin.' . $region->slug . '@agnifarm.com';
            $password = 'admin' . $region->slug . '123';

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Admin ' . $region->name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'is_admin' => true,
                    'role' => 'admin',
                    'region_id' => $region->id,
                ]
            );

            $this->command->info("Region: {$region->name}");
            $this->command->info("Email: {$email}");
            $this->command->info("Password: {$password}");
            $this->command->newLine();
        }

        // Keep the old generic admin as Superadmin too (in case already exists)
        User::where('email', 'admin@agnifarm.com')->update([
            'role' => 'superadmin',
            'region_id' => null,
        ]);
    }
}
