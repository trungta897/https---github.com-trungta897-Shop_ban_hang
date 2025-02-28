<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Product\ProductService;

class ShopController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function show(Request $request) {

        $products = $this->productService->getProductOnIndex($request);

        return view('frontend.shop.shop', compact('products'));
    }

}
