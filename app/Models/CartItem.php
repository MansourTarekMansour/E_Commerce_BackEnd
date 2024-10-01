<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cart_items'; 

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    // Relationship with cart
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

   
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
