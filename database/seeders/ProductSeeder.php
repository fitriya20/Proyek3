<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['product_name' => 'Paket 2 Mbps', 'price' => '120000', 'categories_id' => 1],
            ['product_name' => 'Paket 5 Mbps', 'price' => '200000', 'categories_id' => 1],
            ['product_name' => 'Paket 10 Mbps', 'price' => '300000', 'categories_id' => 1],
            ['product_name' => 'Paket 20 Mbps', 'price' => '500000', 'categories_id' => 1],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
