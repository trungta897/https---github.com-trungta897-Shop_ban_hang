@extends('frontend.layouts.master')

@section('title', 'Single Product')

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
                <div class="col-md-4">
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Search Products</h2>
                        <form action="">
                            <input type="text" placeholder="Search products...">
                            <input type="submit" value="Search">
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="product-breadcroumb">
                            <a href="{{ url('/') }}">Home</a>
                            <a href="">{{ $products->category }}</a>
                            <a href="shop/product/{{ $products->id }}">{{ $products->name }}</a>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="{{ $products->image}}" alt="">
                                    </div>

                                    <div class="product-gallery">

                                        @foreach ($products->productImages as $productImage)
                                            <div class="pt active" data-imgbigurl="frontend/img/{{ $productImage->path }}">
                                                <img src="frontend/img/{{ $productImage->path }}" alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="product-inner">
                                    <h2 class="product-name">{{ $products->name }}</h2>
                                    <div class="product-inner-price">
                                        <ins>{{ $products->price }} VND</ins>
                                    </div>

                                    <form action="" class="cart">
                                        <div class="quantity">
                                            <input type="number" size="4" class="input-text qty text" title="Qty"
                                                value="1" name="quantity" min="1" step="1">
                                        </div>
                                        <button class="add_to_cart_button" type="submit">Add to cart</button>
                                    </form>

                                    <div class="product-inner-category">
                                        <p>Category: <b><a href="">{{ $products->category }}</a></b></p>
                                        <p>Stock: <b>{{$products->stock}}</b></p>
                                    </div>

                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home"
                                                    role="tab" data-toggle="tab">Description</a></li>
                                            <li role="presentation"><a href="#profile" aria-controls="profile"
                                                    role="tab" data-toggle="tab">Reviews</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <h2>Product Description</h2>
                                                <p>{!! $products->detail !!}</p>


                                            </div>
                                            <form action="" method="POST" class="comment-form">
                                                <div role="tabpanel" class="tab-pane fade" id="profile">
                                                    <h2>Reviews</h2>
                                                    <div class="submit-review">
                                                        <p><label for="name">Name</label> <input name="name"
                                                                type="text"></p>
                                                        <p><label for="email">Email</label> <input name="email"
                                                                type="email"></p>
                                                        <div class="rating-chooser">
                                                            <p>Your rating</p>

                                                            <div class="rating-wrap-post">
                                                                <div class="personal-rating">
                                                                    <div class="rate">
                                                                        <input type="radio" id="star5" name="rating"
                                                                            value="5" />
                                                                        <label for="star5" title="text">5 stars</label>
                                                                        <input type="radio" id="star4" name="rating"
                                                                            value="4" />
                                                                        <label for="star4" title="text">4 stars</label>
                                                                        <input type="radio" id="star3"
                                                                            name="rating" value="3" />
                                                                        <label for="star3" title="text">3
                                                                            stars</label>
                                                                        <input type="radio" id="star2"
                                                                            name="rating" value="2" />
                                                                        <label for="star2" title="text">2
                                                                            stars</label>
                                                                        <input type="radio" id="star1"
                                                                            name="rating" value="1" />
                                                                        <label for="star1" title="text">1
                                                                            star</label>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <p><label for="review">Your review</label>
                                                            <textarea name="review" id="" cols="30" rows="10"></textarea>
                                                        </p>
                                                        <p><input type="submit" value="Submit"></p>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="related-products-wrapper">
                            <h2 class="related-products-title">Related Products</h2>
                            <div class="related-products-carousel">
                                <div class="single-product">
                                    <div class="">
                                        @foreach ($relatedProducts as $relatedProduct)
                                            <div class="product-f-image">
                                                <img src="{{ $products->image }}" alt="">
                                                <div class="product-hover">
                                                    <a href="" class="add-to-cart-link"><i
                                                            class="fa fa-shopping-cart"></i> Add to cart</a>
                                                    <a href="" class="view-details-link"><i
                                                            class="fa fa-link"></i> See details</a>
                                                </div>
                                            </div>


                                            <h2><a href="shop/product/{{$products->id}}">{{ $relatedProduct->name }}</a></h2>
                                            <div class="product-carousel-price">
                                                <ins>{{ $relatedProduct->price }} VND</ins>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
