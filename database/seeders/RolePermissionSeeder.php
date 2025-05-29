<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ambil role
        $superadmin = Role::where('name', 'superadmin')->first();
        $admin = Role::where('name', 'admin')->first();

        // Permissions untuk superadmin
        $superadminPermissions = [
            // User 
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'detail-users',

            // Role 
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            // Permission 
            'view-permission',
            'create-permission',
            'edit-permission',
            'delete-permission',

            // Hamlet
            'view-hamlets',
            'create-hamlets',
            'edit-hamlets',
            'delete-hamlets',

            // Rw
            'view-rw',
            'create-rw',
            'edit-rw',
            'delete-rw',

            // Rt
            'view-rt',
            'create-rt',
            'edit-rt',
            'delete-rt',

            // kategori
            'view-category',
            'create-category',
            'edit-category',
            'delete-category',
        ];

        // Permission untuk admin
        $adminPermissions = [
            //  Hamlet
            'view-hamlets',

            // RW
            'view-rw',

            // RT
            'view-rt',

            // Kategori
            'view-category',
            'create-category',
            'edit-category',
            'delete-category',
        ];

        // permission ke role:superadmin
        foreach ($superadminPermissions as $perm) {
            $permission = Permission::where('name', $perm)->first();
            if ($permission && $superadmin) {
                $superadmin->givePermissionTo($permission);
            }
        }

        // permission ke role:admin
        foreach ($adminPermissions as $perm) {
            $permission = Permission::where('name', $perm)->first();
            if ($permission && $admin) {
                $admin->givePermissionTo($permission);
            }
        }
    }
}
