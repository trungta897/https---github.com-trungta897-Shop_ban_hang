<?php

namespace App\Repositories\Product;
use App\Repositories\RepositoriesInterFace;

interface ProductRepositoryInterFace extends RepositoriesInterFace
{
    public function getRealatedProduct($product, $limit = 5);
    public function getFeaturedProductByCategory(int $categoryId);
    public function getProductOnIndex();
}
