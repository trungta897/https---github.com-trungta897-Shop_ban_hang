<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Service\Product\ProductService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $productService;
    private $productCategoryService;
    public function __construct(ProductService $productService, $productCategoryService) {
        $this->productService = $productService;
        $this->productCategoryService = $productCategoryService;
        $this->productService = $productService;
    }

    public function showCategory(Request $request)
    {
        $categories = $this->productCategoryService->all();

        return view('frontend.shop.category', compact('categories'));
    }
}
