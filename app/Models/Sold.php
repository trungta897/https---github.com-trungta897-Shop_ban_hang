<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    protected $table = 'sold';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
