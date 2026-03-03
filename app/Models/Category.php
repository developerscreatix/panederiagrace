<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $fillable = [
        'name',
    ];

    // Relación con Product (una categoría tiene muchos productos)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
