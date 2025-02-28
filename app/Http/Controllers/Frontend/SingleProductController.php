<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Product\ProductService;
use App\Service\ProductComment\ProductCommentService;
use App\Service\ProductComment\ProductCommentServiceInterFace;

class SingleProductController extends Controller
{

    private $productService;
    private $productCommentService;


    public function __construct(ProductService $productService,) {
        // ProductCommentServiceInterFace $productCommentService) {
        $this->productService = $productService;
        // $this->productService = $productCommentService;
    }

    public function show($id) {

        $products = $this->productService->find($id);
        $relatedProducts = $this->productService->getRealatedProducts($products, 5);

        return view('frontend.shop.single-product', compact('products', 'relatedProducts'));
    }

    public function postComment(Request $request) {
        $this->productCommentService->create($request->all());
        return redirect()->back();
    }
}

