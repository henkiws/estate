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

        // Tenant User
        $tenant = User::create([
            'name' => 'Tenant User',
            'email' => 'tenant@mail.com',
            'password' => Hash::make('admin123'),
        ]);
        $tenant->assignRole('tenant');

        // Landlord User
        $landlord = User::create([
            'name' => 'Landlord User',
            'email' => 'landlord@mail.com',
            'password' => Hash::make('admin123'),
        ]);
        $landlord->assignRole('landlord');

        // Agent User
        $agent = User::create([
            'name' => 'Agent User',
            'email' => 'agent@mail.com',
            'password' => Hash::make('admin123'),
        ]);
        $agent->assignRole('agent');
    }
}
