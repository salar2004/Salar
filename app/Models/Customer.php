<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'password', 'shipping_address', 'phone_number'];

    public function Order()
    {
        return $this->hasMany(Order::class);
    }

    public function Cart()
    {
        return $this->hasOne(ShoppingCart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    
}
