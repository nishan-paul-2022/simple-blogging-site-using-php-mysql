<?php

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
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@blog.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'bio' => 'The blog administrator',
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample users
        User::factory()
            ->count(5)
            ->create();
    }
}
