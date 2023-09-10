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
        $permissions = [
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'order-list',
            'order-create',
            'order-validate',
            'user-ban',
         ];
      
         foreach ($permissions as $permission) {
              Permission::create([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
         }
    }
}
