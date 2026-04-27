<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'fee_id',
        'client_name',
        'phone_number',
        'payment_method',
        'pickup_time', 
        'notes',         
        'total',
        'is_recieved',
        'is_enabled',
    ];

    // Relación con OrderProduct (una orden tiene muchos order_products)
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
