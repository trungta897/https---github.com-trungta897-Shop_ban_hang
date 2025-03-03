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
        $perPage = $request->show ?? 5;
        $search = $request->search ??'';

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

        $products = $products->paginate($perPage);

        $products->appends(['sort_by' => $sortBy, 'show' => $perPage, 'search' => $search]);
        return $products;
    }
}

