<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);

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

        $user = User::create([
            'fullname' => 'Bagas',
            'email' => 'bagas@gmail.com',
            'password' => bcrypt('Password234#'),
            'address' => 'Kota Malang',
            'phone' => '62822349292'
        ]);
        $user->assignRole('User');
        $user->syncPermissions($userPermissions);

        $admin = Admin::create([
            'fullname' => 'Raditya',
            'email' => 'raditya@gmail.com',
            'password' => bcrypt('Password234#')
        ]);
        $admin->assignRole('Admin');
        $admin->syncPermissions($adminPermissions);

        $this->call(OrderTableSeeder::class);
    }
}
