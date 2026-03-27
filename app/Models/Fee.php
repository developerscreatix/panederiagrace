<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'minFee',
        'maxFee',
        'percentage',
    ];

    // Relación con Order (una tarifa puede tener muchas ordenes)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
