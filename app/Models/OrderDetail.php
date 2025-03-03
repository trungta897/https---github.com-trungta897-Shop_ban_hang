<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'quantity', 'price',
        'buyer_id', 'buyer_name', 'seller_id', 'seller_name', 'status',
        'buyer_address', 'buyer_phone', 'created_at'
    ];

    protected $guarded = [];

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function products() {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
