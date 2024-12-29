<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'categories_id', 'price', 'image', 'deskripsi'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
