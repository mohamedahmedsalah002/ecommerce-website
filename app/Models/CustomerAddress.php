<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'city', 'street'];

    // One customer address belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
