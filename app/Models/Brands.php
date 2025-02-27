<?php

// app/Models/Brands.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brands extends Model
{
    protected $table = 'brands';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'brand_id', 'id');
    }
}
