<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'Admin HappyPet',
            'email' => 'admin@happypet.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // User Account
        User::create([
            'name' => 'John Doe',
            'email' => 'user@happypet.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
