<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password', 'phone_number'];

    public function products()
    {
        return $this->hasMany(Product::class, 'customer_id');
    }
    public function image()
    {
        return $this->morphOne(File::class, 'fileable')->where('file_type', 'image');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'customer_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id'); 
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id'); 
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id');
    }
}
