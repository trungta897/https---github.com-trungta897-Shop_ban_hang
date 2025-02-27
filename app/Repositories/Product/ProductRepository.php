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

    public function getRealatedProduct($product, $limit = 5) {
        return $this->model->where('category', $product->category)
        ->limit($limit)->get();
    }

    public function getFeaturedProductByCategory(int $categoryId) {
        return $this->model->where('featured', true)
        ->where('category', $categoryId)
        ->get();
    }
}

