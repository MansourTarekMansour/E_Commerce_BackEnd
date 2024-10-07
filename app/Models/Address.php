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
        'street',
        'city',
        'state',
        'country',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id'); 
    }
}
