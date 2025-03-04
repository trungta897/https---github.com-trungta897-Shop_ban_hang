<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role',
        'username',
        'email',
        'password',
        'phone',
        'address',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false; // Tắt timestamps vì migration không có updated_at

    public function products()
    {
        return $this->hasMany(Products::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sellerOrders()
    {
        return $this->hasMany(OrderDetail::class, 'seller_id');
    }
}
