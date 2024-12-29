<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'address' => 'Tambi Lor',
            'users_id' => 2,
            'product_id' => 1,
            'status_id' => 1,
            'order_date' => Carbon::now(),
            'installation_date' => Carbon::now()->addDays(7),
        ]);
    }
}
