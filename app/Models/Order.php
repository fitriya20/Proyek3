<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'users_id', 'product_id', 'status_id', 'drivers_id', 'order_date', 'installation_date'];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'drivers_id');
    }
}
