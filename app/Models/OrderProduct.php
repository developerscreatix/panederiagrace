<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'special_ingredient_id',
        'quantity',
    ];

    // Relación con Order (la orden relacionada al order_product)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación con Product (el producto relacionado al order_product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function specialIngredient()
    {
        return $this->belongsTo(Ingredient::class, 'special_ingredient_id');
    }
}
