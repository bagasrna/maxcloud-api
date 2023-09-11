<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productNames = [
            'Sprite',
            'Fanta',
            'Cocacola',
        ];

        $productPrice = [
            'Sprite' => 5000,
            'Fanta' => 6500,
            'Cocacola' => 4500,
        ];

        foreach ($productNames as $productName) {
            Product::create([
                'name' => $productName,
                'price' => $productPrice[$productName]
            ]);
        }

        Order::create([
            'price' => 10000,
            'quantity' => 2,
            'notes' => '-',
            'user_id' => 1,
            'product_id' => 1,
        ]);
    }
}
