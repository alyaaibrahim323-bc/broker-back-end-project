<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // Create a sample user and assign roles

        // User 1: Regular user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole('user');

        // User 2: Admin
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        // User 3: Super Admin
        $superAdmin = User::factory()->create([
            'email' => 'superadmin@example.com',
        ]);
        $superAdmin->assignRole('super-admin');
    }
}
