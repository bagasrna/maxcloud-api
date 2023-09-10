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
        $roles = [
            'User',
            'Admin',
         ];
      
         foreach ($roles as $role) {
              Role::create([
                'name' => $role,
                'guard_name' => 'api'
            ]);
         }

         $adminPermissions = [
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'order-list',
            'order-validate',
            'user-ban',
        ];

        $userPermissions = [
            'product-list',
            'order-list',
            'order-create',
        ];

         $adminRole = Role::where('name', 'Admin')->first();
         $adminRole->syncPermissions($adminPermissions);

         $userRole = Role::where('name', 'User')->first();
         $userRole->syncPermissions($userPermissions);
    }
}
