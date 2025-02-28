<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Product\ProductServiceInterFace;

class HomeController extends Controller
{
    private $productService;
    public function __construct(ProductServiceInterFace $productService)
    {
        $this->productService = $productService;
    }


    public function index() {

        // Fetch latest products
        $latestProducts = $this->productService->getLatestProducts();
        $featuredProducts = $this->productService->getFeaturedProducts();

        return view('frontend.index', compact('latestProducts', 'featuredProducts'));
    }
}
