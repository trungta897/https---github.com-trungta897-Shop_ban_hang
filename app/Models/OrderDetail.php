<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function products() {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
