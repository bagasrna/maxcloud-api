<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsAdmins = [
            'admin-product-list',
            'admin-product-create',
            'admin-product-edit',
            'admin-product-delete',
            'admin-order-list',
            'admin-order-validate',
            'admin-user-ban',
         ];

         $permissionsUsers = [
            'user-product-list',
            'user-order-list',
            'user-order-create',
         ];
      
         foreach ($permissionsAdmins as $permissionAdmin) {
              Permission::create([
                'name' => $permissionAdmin,
                'guard_name' => 'admin'
            ]);
         }

         foreach ($permissionsUsers as $permissionUser) {
            Permission::create([
              'name' => $permissionUser,
              'guard_name' => 'user'
          ]);
       }
    }
}
