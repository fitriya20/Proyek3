<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfitExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('users', 'product', 'status', 'driver')
            ->select('id', 'address', 'users_id', 'product_id', 'status_id', 'order_date', 'drivers_id')
            ->get()
            ->map(function($profit){
                return[
                    'ID' => $profit->id,
                    'Users' => $profit->users->name,
                    'Product' => $profit-> product->product_name,
                    'Status' => $profit->status->status_name,
                    'Time Order'=> $profit->order_date,
                    'Drivers' => $profit->driver->name
                ];
            });
    }

    /**
     * @return array
     */

    public function headings(): array
    {
        return [
            'ID',
            'Users',
            'Product',
            'Status',
            'Time Order',
            'Drivers'
        ];
    }
}
