<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'User',
            'guard_name' => 'user'
        ]);

        Role::create([
            'name' => 'Admin',
            'guard_name' => 'admin'
        ]);

        $adminPermissions = [
            'admin-product-list',
            'admin-product-create',
            'admin-product-edit',
            'admin-product-delete',
            'admin-order-list',
            'admin-order-validate',
            'admin-user-ban',
        ];

        $userPermissions = [
            'user-product-list',
            'user-order-list',
            'user-order-create',
        ];

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->syncPermissions($adminPermissions);

        $userRole = Role::where('name', 'user')->first();
        $userRole->syncPermissions($userPermissions);
    }
}
