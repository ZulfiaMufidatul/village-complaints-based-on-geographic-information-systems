<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Kelola User
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'detail-users',

            // Kelola Role
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            // Kelola Permission 
            'view-permission',
            'create-permission',
            'edit-permission',
            'delete-permission',

            // Kelola Hamlet 
            'view-hamlets',
            'create-hamlets',
            'edit-hamlets',
            'delete-hamlets',

            // kelola rw
            'view-rw',
            'create-rw',
            'edit-rw',
            'delete-rw',

            // kelola rt
            'view-rt',
            'create-rt',
            'edit-rt',
            'delete-rt',

            // kelola kategori
            'view-category',
            'create-category',
            'edit-category',
            'delete-category',

            // kelola aduan
            'view-complaints',
            'process-complaints',
            'delete-complaints',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
