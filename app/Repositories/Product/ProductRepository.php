<?php

namespace App\Repositories\Product;

use App\Models\Products;
use App\Repositories\BaseRepositories;
use App\Repositories\Product\ProductRepositoryInterFace;


class ProductRepository extends BaseRepositories implements ProductRepositoryInterFace
{
    public function getModel()
    {
        return Products::class;
    }

    public function getRelatedProduct($product, $limit = 5) {
        return $this->model->where('category', $product->category)
        ->where('id', '!=', $product->id)
        ->limit($limit)
        ->get();
    }


    public function getFeaturedProductByCategory($categoryId) {
        return Products::where('category', $categoryId)->where('featured', true)->get();
    }

    public function getProductOnIndex($request) {
        $sortBy = $request->type ?? 'default';
        $search = $request->search ?? '';
        $page = $request->page ?? 1;
        $perPage = 5; // Số sản phẩm hiển thị mỗi trang

        $products = $this->model->where('name', 'like', '%' . $search . '%');

        switch ($request->type) {
            case 'name-ascending':
                $products = $products->orderBy('name', 'asc');
                break;
            case 'name-descending':
                $products = $products->orderBy('name', 'desc');
                break;
            case 'price-ascending':
                $products = $products->orderBy('price', 'asc');
                break;
            case 'price-descending':
                $products = $products->orderBy('price', 'desc');
                break;
            case 'lastest':
                $products = $products->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $products = $products->orderBy('created_at', 'asc');
                break;
            default:
                $products = $products->orderBy('id');
        }

        $totalProducts = $products->count();
        $totalPages = ceil($totalProducts / $perPage);

        // Lấy sản phẩm theo phân trang
        $products = $products->skip(($page - 1) * $perPage)
                           ->take($perPage)
                           ->get();

        // Thêm thông tin phân trang vào kết quả
        $result = [
            'products' => $products,
            'currentPage' => (int)$page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,
            'hasMorePages' => $page < $totalPages
        ];

        return $result;
    }
}