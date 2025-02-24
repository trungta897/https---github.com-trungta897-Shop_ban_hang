<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Product\ProductService;

class ShopController extends Controller
{
    public function show() {
        return view('frontend.shop.shop');
    }
}
