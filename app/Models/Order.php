<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'order_date'];

    // One order belongs to one customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Many-to-many relationship: an order can contain many products
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
