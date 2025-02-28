@extends('frontend.layouts.master')

@section('title', 'Category')

@section('body')
    <!-- Change page title -->
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Categories</h2> <!-- Category specific title -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtered products section -->
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                @foreach ($categories as $category)
                    <h2>{{ $category }}</h2>
                    <ul>
                        @if (isset($productsByCategory[$category]) && count($productsByCategory[$category]) > 0)
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    @foreach ($productsByCategory[$category] as $product)
                                        <div class="single-shop-product">
                                            <div class="product-upper">
                                                <img src="{{$product->image}}" alt="">
                                            </div>
                                            <h2><a href="shop/product/{{$product->id}}">{{$product->name}}</a></h2>
                                            <div class="product-carousel-price">
                                                <ins>{{$product->price}} VND</ins>
                                            </div>

                                            <div class="product-option-shop">
                                                <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70"
                                                    rel="nofollow" href="/canvas/shop/?add-to-cart=70">Add to cart</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <li>No products available in this category</li>
                        @endif
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
@endsection
