<?php

namespace Database\Seeders;

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
        User::updateOrCreate(
            ['email' => 'admin@agnifarm.com'],
            [
                'name' => 'Admin Agni Farm',
                'email' => 'admin@agnifarm.com',
                'password' => Hash::make('agnifarm123'),
                'is_admin' => true,
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@agnifarm.com');
        $this->command->info('Password: agnifarm123');
    }
}
