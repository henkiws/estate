<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Agency permissions
            'view agencies',
            'create agencies',
            'edit agencies',
            'delete agencies',
            'approve agencies',
            'reject agencies',
            
            // Agent permissions
            'view agents',
            'create agents',
            'edit agents',
            'delete agents',
            
            // Property permissions
            'view properties',
            'create properties',
            'edit properties',
            'delete properties',
            
            // Document permissions
            'view documents',
            'upload documents',
            'delete documents',
            'approve documents',
            
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Settings
            'manage settings',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // 1. Admin role (full access)
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 2. Agency role (real estate agency)
        $agencyRole = Role::create(['name' => 'agency']);
        $agencyRole->givePermissionTo([
            'view agents',
            'create agents',
            'edit agents',
            'view properties',
            'create properties',
            'edit properties',
            'delete properties',
            'view documents',
            'upload documents',
            'view reports',
        ]);

        // 3. Agent role (individual real estate agent)
        $agentRole = Role::create(['name' => 'agent']);
        $agentRole->givePermissionTo([
            'view properties',
            'create properties',
            'edit properties',
            'view documents',
            'upload documents',
        ]);

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Created roles: admin, agency, agent');
    }
}