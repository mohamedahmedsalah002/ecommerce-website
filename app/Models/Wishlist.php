<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id'];

    // One wishlist belongs to one customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Many-to-many relationship: one wishlist can contain many products
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
