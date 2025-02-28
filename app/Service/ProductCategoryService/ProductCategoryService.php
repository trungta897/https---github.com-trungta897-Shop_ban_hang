<?php

namespace App\Service\ProductCategoryService;


use App\Service\BaseService;
use App\Repositories\ProductCategory\ProductCategoryRepositoryInterFace;
use App\Service\ProductCategory\ProductCategoryServiceInterFace;



class ProductCategoryService extends BaseService implements ProductCategoryServiceInterFace
{

    public $repository;

    public function __construct(ProductCategoryRepositoryInterFace $productCategoryRepository) {
        $this->repository = $productCategoryRepository;
    }
}
