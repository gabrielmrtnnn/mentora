<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Mentora',
            'email' => 'admin@mentora.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Student Mentora',
            'email' => 'student@mentora.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}