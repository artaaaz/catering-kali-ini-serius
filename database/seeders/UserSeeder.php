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
            'name' => 'Admin Catering',
            'email' => 'admin@catering.com',
            'password' => Hash::make('password'),
            'level' => 'admin',
        ]);

        User::create([
            'name' => 'Owner Catering',
            'email' => 'owner@catering.com',
            'password' => Hash::make('password'),
            'level' => 'owner',
        ]);

        User::create([
            'name' => 'Kurir Catering',
            'email' => 'kurir@catering.com',
            'password' => Hash::make('password'),
            'level' => 'kurir',
        ]);
    }
}
