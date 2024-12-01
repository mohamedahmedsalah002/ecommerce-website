<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price','description', 'image','price','category_id'];

    // One product belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Many-to-many relationship: one product can be in many carts
    public function cartItem()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    // Many-to-many relationship: one product can be in many wishlists
    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class);
    }
}
