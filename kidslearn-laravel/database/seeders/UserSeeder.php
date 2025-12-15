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
        // Create demo user
        User::create([
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'avatar' => 'img/avatar1.png',
        ]);

        User::create([
            'name' => 'Siti',
            'email' => 'siti@example.com',
            'password' => Hash::make('password123'),
            'avatar' => 'img/avatar2.png',
        ]);
    }
}
