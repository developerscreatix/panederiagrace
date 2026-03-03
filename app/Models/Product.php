<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'discount',
        'price',
    ];

    // Relación con Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con OrderProduct (un producto puede estar en muchos order_products)
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    // Relación con ProductIngredient (un producto tiene muchos ProductIngredients)
    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }
}
