<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('admin');

        // Agency User
        $agency = User::create([
            'name' => 'Agency User',
            'email' => 'agency@mail.com',
            'password' => Hash::make('admin123'),
        ]);
        $agency->assignRole('agency');

        // Agent User
        $agent = User::create([
            'name' => 'Agent User',
            'email' => 'agent@mail.com',
            'password' => Hash::make('admin123'),
        ]);
        $agent->assignRole('agent');
    }
}
