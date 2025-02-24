<?php

namespace App\Service\ProductComment;

use App\Service\ProductComment\ProductCommentServiceInterFace;
use App\Repositories\ProductComment\ProductCommentRepositoryInterFace;
use App\Service\BaseService;


class ProductCommentService extends BaseService implements ProductCommentServiceInterFace
{
    public $repository;
    public function __construct(ProductCommentRepositoryInterFace $productCommentRepository)
    {
        $this->repository = $productCommentRepository;
    }
}
