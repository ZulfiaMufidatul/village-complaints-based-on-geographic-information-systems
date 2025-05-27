<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user berdasarkan email
        $superadmin = User::where('email', 'superadmin@example.com')->first();
        $admin = User::where('email', 'admin@example.com')->first();

        // Ambil role dari database
        $roleSuperadmin = Role::where('name', 'superadmin')->first();
        $roleAdmin = Role::where('name', 'admin')->first();

        // Berikan role ke user
        if ($superadmin && $roleSuperadmin) {
            $superadmin->assignRole($roleSuperadmin);
        }

        if ($admin && $roleAdmin) {
            $admin->assignRole($roleAdmin);
        }
    }
}
