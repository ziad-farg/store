<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions for Super Admin and Admin
        $mainPermissions = [
            // Dashboard
            'dashboard.view',
            'dashboard.create',
            'dashboard.update',
            'dashboard.delete',

            // Shop
            'shop.view',

            // Stores
            'stores.view',
            'stores.create',
            'stores.update',
            'stores.delete',

            // Categories
            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',

            // Products
            'products.view',
            'products.create',
            'products.update',
            'products.delete',

            // Admins
            'admins.view',
            'admins.create',
            'admins.update',
            'admins.delete',

            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
        ];

        // Permissions only for User
        $profilePermissions = [
            'profile.view',
            'profile.create',
            'profile.update',
            'profile.delete',
        ];

        // Create all permissions in DB
        foreach (array_merge($mainPermissions, $profilePermissions) as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Super admin: Full access (mainPermissions only)
        $superAdmin->syncPermissions($mainPermissions);

        // Admin: CRUD in specific store (mainPermissions only)
        $admin->syncPermissions($mainPermissions);

        // User: Read-only + profile CRUD (profilePermissions only + view shop/categories/products)
        $userPermissions = [
            'shop.view',
            'categories.view',
            'products.view',
            // Profile CRUD
            'profile.view',
            'profile.create',
            'profile.update',
            'profile.delete',
        ];
        $user->syncPermissions($userPermissions);
    }
}
