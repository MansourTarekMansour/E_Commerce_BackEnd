<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'addresses'; 
    protected $fillable = [
        'customer_id',
        'order_id',
        'street',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id'); 
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id'); 
    }
}
