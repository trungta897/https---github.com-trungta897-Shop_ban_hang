<?php

namespace App\Repositories\ProductCategory;

use App\Repositories\BaseRepositories;
use App\Repositories\ProductCategory\ProductCategoryRepositoryInterFace;
use App\Models\ProductCategory;


class ProductCategoryRepository extends BaseRepositories implements ProductCategoryRepositoryInterFace
{

    public function getModel()
    {
        return ProductCategory::class;
    }
}
