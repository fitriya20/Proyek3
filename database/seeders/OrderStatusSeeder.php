<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::create([
            'status_name' => 'Dipesan'
        ]);

        OrderStatus::create([
            'status_name' => 'Pemasangan'
        ]);

        OrderStatus::create([
            'status_name' => 'Masa Aktif'
        ]);

        OrderStatus::create([
            'status_name' => 'Dibatalkan'
        ]);
    }
}
