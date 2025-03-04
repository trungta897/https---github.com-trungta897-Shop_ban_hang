<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity', 'price'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

}

