<?php

namespace App\Service\Product;

use App\Service\ServiceInterFace;


interface ProductServiceInterFace extends ServiceInterFace
{

    public function getRealatedProducts($product, $limit = 5);
    public function getFeaturedProducts();
    public function getProductOnIndex($request);
}
