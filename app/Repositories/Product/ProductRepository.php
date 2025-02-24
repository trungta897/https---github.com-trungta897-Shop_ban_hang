<?php

namespace App\Repositories\Product;

use App\Models\Products;
use App\Repositories\BaseRepositories;
use App\Repositories\Product\ProductRepositoryInterFace;

class ProductRepository extends BaseRepositories implements ProductRepositoryInterFace
{
    public function getModel()
    {
        return Products::class;
    }
}

