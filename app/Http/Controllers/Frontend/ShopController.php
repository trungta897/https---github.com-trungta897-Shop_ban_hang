<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Product\ProductService;
use App\Repositories\Product\ProductRepositoryInterFace;

class ShopController extends Controller
{
    private $productService;
    protected $productRepo;

    public function __construct(ProductService $productService, ProductRepositoryInterFace $productRepo)
    {
        $this->productService = $productService;
        $this->productRepo = $productRepo;
    }

    public function show(Request $request)
    {
        $result = $this->productRepo->getProductOnIndex($request);

        // Nếu là request AJAX (khi nhấn nút "Xem thêm")
        if ($request->ajax()) {
            $productsHtml = view('frontend.partials.product-items', [
                'products' => $result['products']
            ])->render();

            return response()->json([
                'html' => $productsHtml,
                'currentPage' => $result['currentPage'],
                'totalPages' => $result['totalPages'],
                'hasMorePages' => $result['hasMorePages']
            ]);
        }

        // Nếu là request thông thường
        return view('frontend.shop.shop', [
            'products' => $result['products'],
            'currentPage' => $result['currentPage'],
            'totalPages' => $result['totalPages'],
            'hasMorePages' => $result['hasMorePages']
        ]);
    }

    // Không cần phương thức index nữa vì chức năng đã được hợp nhất vào show()
}