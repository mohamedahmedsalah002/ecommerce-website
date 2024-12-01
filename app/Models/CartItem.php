<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = []; // This allows mass assignment for all fields

    // One cart item belongs to one product
    public function product()
    {
        return $this->belongsTo(Product::class); // Ensure 'product_id' exists in the cart_items table
    }

    // One cart item belongs to one cart
    public function cart()
    {
        return $this->belongsTo(Cart::class); // Ensure 'cart_id' exists in the cart_items table
    }

    // If you intended to have a many-to-many relationship with products, uncomment this
    // public function products()
    // {
    //     return $this->belongsToMany(Product::class);
    // }
}
