<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
    protected $fillable = [
        'product_id',
        'ingredient_id',
    ];

    // Relación con Product (un product_ingredient puede estar en muchos productos)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relación con Ingredient (un product_ingredient puede estar en muchos ingredientes)
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

}
