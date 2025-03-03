@extends('frontend.layouts.master')

@section('title', 'Shop')

@section('body')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Shop</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    @foreach ($products as $product)
                        <div class="single-shop-product">
                            <div class="product-upper">
                                <img src="{{$product->image}}" alt="">
                            </div>
                            <h2><a href="shop/product/{{$product->id}}">{{$product->name}}</a></h2>
                            <div class="product-carousel-price">
                                <ins>{{number_format($product->price)}} VND</ins>
                            </div>

                            <div class="product-option-shop">
                                <form action="shop/product/{{$product->id}}" method="GET">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-primary" value="{{ $product->id }}">Xem chi tiết</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    @if (request('search') !== '' && count($products) == 0)
                        <h1><b>Không tìm thấy sản phẩm nào</b></h1>
                    @endif
                </div>
            </div>
            {{$products->links()}}
        </div>
    </div>

@endsection
