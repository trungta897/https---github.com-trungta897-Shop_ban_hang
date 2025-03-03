<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Service\Product\ProductServiceInterFace;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $productService;
    public function __construct(ProductServiceInterFace $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request) {

        // Fetch latest products
        try {
            $products = $this->productService->getProductOnIndex($request);
            $latestProducts = $this->productService->getLatestProducts();
            $featuredProducts = $this->productService->getFeaturedProducts();
        } catch (\Exception $e) {
        }

        return view('frontend.index', compact('latestProducts', 'featuredProducts', 'products'));
    }
}
