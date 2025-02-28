<?php

namespace App\Service\Product;

use App\Models\Products;
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

    public function getFeaturedProducts()
    {
        return [
            "Điện thoại" => $this->repository->getFeaturedProductByCategory(1),
            "Laptop" => $this->repository->getFeaturedProductByCategory(2),
        ];
    }

    public function getProductOnIndex($request)
    {
        return $this->repository->getProductOnIndex($request);
    }

    public function getProductsByCategory($category) {
        return Products::where('category', $category)->get();
    }

}
