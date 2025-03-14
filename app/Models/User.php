<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Products;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role', 'username', 'email', 'password', 'phone', 'address', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Products::class, 'seller_id', 'id');
    }

    public function sellerOrders()
    {
        return $this->hasMany(OrderDetail::class, 'seller_id');
    }

    public function buyerOrders()
    {
        return $this->hasMany(OrderDetail::class, 'buyer_id');
    }
    use Notifiable;


}
