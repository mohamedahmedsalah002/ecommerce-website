<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['first_name','last_name','email'];
    public $timestamps = false;
    // One customer has many addresses
    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    // One customer can have many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // One customer can have one cart
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // One customer can have one wishlist
    public function wishlist()
    {
        return $this->hasOne(Wishlist::class);
    }

    public $table = "customers";
}
