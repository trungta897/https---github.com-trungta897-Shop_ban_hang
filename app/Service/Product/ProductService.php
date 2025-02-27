<?php

namespace App\Service\Product;

use App\Repositories\Product\ProductRepositoryInterFace;
use App\Service\BaseService;

class ProductService extends BaseService implements ProductServiceInterFace
{
    public $repository;
    public function __construct(ProductRepositoryInterFace $productRepository)
    {
        $this->repository = $productRepository;
    }

    public function find($id)
    {
        $products = $this->repository->find($id);

        return $products;
    }

    public function getRealatedProducts($product, $limit = 5)
    {
        return $this->repository->getRealatedProduct($product, $limit);
    }

    public function getFeaturedProducts(int $categoryId)
    {
        return $this->repository->getFeaturedProductByCategory($categoryId);
    }

}
