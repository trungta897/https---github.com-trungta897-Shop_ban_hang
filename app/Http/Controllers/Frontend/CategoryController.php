<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Service\Product\ProductService;
use App\Service\ProductCategory\ProductCategoryServiceInterFace;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $productService;
    private $productCategoryService;

    public function __construct(ProductService $productService, ProductCategoryServiceInterFace $productCategoryService) {
        $this->productService = $productService;
        $this->productCategoryService = $productCategoryService;
    }

    public function showCategory(Request $request)
    {
        // Get all categories
        $categories = $this->productCategoryService->getAllCategories();

        // Initialize an array to hold products for each category
        $productsByCategory = [];

        // Fetch products for each category
        foreach ($categories as $category) {
            $productsByCategory[$category] = $this->productService->getProductsByCategory($category);
        }

        return view('frontend.shop.category', compact('categories', 'productsByCategory'));
    }
}

