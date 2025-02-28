<?php

namespace App\Service\ProductCategory;

use App\Models\Products;

class ProductCategoryService implements ProductCategoryServiceInterFace
{
    public function getAllCategories()
    {
        return Products::distinct()->pluck('category');
    }
}
