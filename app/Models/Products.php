<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }

    public function orderDetail() {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }

    public function seller()
{
    return $this->belongsTo(User::class, 'seller_id');
}

public $timestamps = false;
}
