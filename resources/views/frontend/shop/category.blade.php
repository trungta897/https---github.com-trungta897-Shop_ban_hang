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
                <ul>
                    @foreach ($categories as $category)
                    <li>
                        <a href="/category/{{$category->category}}">{{$category->category}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
