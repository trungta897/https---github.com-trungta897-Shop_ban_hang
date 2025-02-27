@extends('frontend.layouts.master')

@section('title', 'Category')

@section('body')
    <!-- Change page title -->
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Mobile Phones</h2> <!-- Category specific title -->
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
                <!-- Only show products from this category -->
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <div class="product-upper">
                            <img src="img/mobile-1.jpg" alt="Smartphone X">
                        </div>
                        <h2><a href="">Smartphone X</a></h2>
                        <div class="product-carousel-price">
                            <ins>$599.00</ins>
                        </div>
                        <div class="product-option-shop">
                            <a class="add_to_cart_button">Add to cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <div class="product-upper">
                            <img src="img/mobile-2.jpg" alt="Smartphone Y">
                        </div>
                        <h2><a href="">Smartphone Y</a></h2>
                        <div class="product-carousel-price">
                            <ins>$699.00</ins> <del>$799.00</del>
                        </div>
                        <div class="product-option-shop">
                            <a class="add_to_cart_button">Add to cart</a>
                        </div>
                    </div>
                </div>

                <!-- Add more mobile products here -->

            </div>

            <!-- Keep pagination same as shop.html -->

        </div>
    </div>
@endsection
