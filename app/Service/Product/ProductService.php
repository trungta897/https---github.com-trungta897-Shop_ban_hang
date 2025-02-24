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

}
