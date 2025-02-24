<?php

namespace App\Repositories\ProductComment;

use App\Repositories\BaseRepositories;
use App\Repositories\ProductComment\ProductCommentRepositoryInterFace;
use App\Models\ProductComment;


class ProductCommentRepository extends BaseRepositories implements ProductCommentRepositoryInterFace
{

    public function getModel()
    {
        return ProductComment::class;
    }
}
