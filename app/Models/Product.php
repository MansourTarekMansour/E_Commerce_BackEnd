<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products'; // Specify the table name if different from plural of model name

    protected $primaryKey = 'id'; // Specify the primary key if it's not 'id'

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'quantity_in_stock',
        'quantity_sold',
        'is_available',
        'rating',
        'user_id',
        'category_id',
        'brand_id',
    ];

  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable'); 
    }

    public function mainFile()
    {
        return $this->belongsTo(File::class, 'main_file_id'); 
    }
}
