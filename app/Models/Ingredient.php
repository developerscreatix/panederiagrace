<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'is_special',
    ];

    // Relación con ProductIngredient (un ingrediente tiene muchos ProductIngredients)
    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }

    public function selectedOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'special_ingredient_id');
    }
}
