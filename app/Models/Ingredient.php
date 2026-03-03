<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
    ];

    // Relación con ProductIngredient (un ingrediente tiene muchos ProductIngredients)
    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }
}
