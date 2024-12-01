<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'customer_id', 'payment_date'];

    // One payment belongs to one customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // One payment belongs to one order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
