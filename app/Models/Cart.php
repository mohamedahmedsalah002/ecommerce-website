<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id']; // Fillable fields for mass assignment
    public $timestamps = false; // Disabling timestamps if not used
    public $table = "carts"; // Specifying the table name

    // One cart belongs to one customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // One cart can have many cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id'); // Specify 'cart_id' if it's not the default
    }
}
