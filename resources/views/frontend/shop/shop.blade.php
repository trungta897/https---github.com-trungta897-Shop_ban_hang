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

    {{-- <div class="col-md-3">
        <div class="single-sidebar">
            <h2 class="sidebar-title">Products</h2>
            <ul>
                @foreach ($categories as $category)
                    <li><a href="shop/category/{{ $category }}">{{ $category }}</a></li>
                @endforeach
            </ul>
        </div>
    </div> --}}

    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="product-sorting">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="shop" method="GET">
                                    <select name="sort" id="sort">
                                        <option value="default">Default sorting</option>
                                        <option value="price-asc">Sort by price: low to high</option>
                                        <option value="price-desc">Sort by price: high to low</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Sort</button>
                                </form>
                            </div>
                        </div> --}}
                        <div class="row products-grid">
                            @foreach ($products as $product)
                                <div class="col-md-3">
                                    <div class="single-shop-product">
                                        <div class="product-upper">
                                            <img src="storage/{{$product->image}}" alt="{{ $product->name }}" style="height: 250px;width: 250px;">
                                        </div>
                                        <h2 class="product-title">
                                            <a href="shop/product/{{$product->id}}">
                                                {{$product->name}}
                                            </a>
                                        </h2>
                                        <div class="product-carousel-price">
                                            <ins>{{number_format($product->price)}} VND</ins>
                                        </div>

                                        <div class="product-option-shop">
                                            <form action="shop/product/{{$product->id}}" method="GET">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-primary" value="{{ $product->id }}">Xem chi
                                                    tiết</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if($hasMorePages)
                    <div class="load-more-container">
                        <button id="load-more" class="btn btn-primary btn-load-more" data-current-page="{{ $currentPage }}">
                            Xem thêm sản phẩm
                        </button>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if (request('search') !== '' && count($products) == 0)
                                <h1><b>Không tìm thấy sản phẩm nào</b></h1>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($hasMorePages)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadMoreBtn = document.getElementById('load-more');
            const productsContainer = document.getElementById('products-container');
            let currentPage = parseInt(loadMoreBtn.getAttribute('data-current-page'));

            loadMoreBtn.addEventListener('click', function() {
                currentPage++;

                // Tạo URL với tham số phân trang
                let url = new URL(window.location.href);
                url.searchParams.set('page', currentPage);

                // Giữ nguyên các tham số khác như search và sort
                if (url.searchParams.has('search')) {
                    url.searchParams.set('search', url.searchParams.get('search'));
                }

                if (url.searchParams.has('type')) {
                    url.searchParams.set('type', url.searchParams.get('type'));
                }

                // Gửi AJAX request để lấy thêm sản phẩm
                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        // Thêm sản phẩm mới vào container
                        productsContainer.innerHTML += data.html;

                        // Cập nhật trang hiện tại
                        loadMoreBtn.setAttribute('data-current-page', currentPage);

                        // Ẩn nút nếu không còn trang nào nữa
                        if (currentPage >= data.totalPages) {
                            loadMoreBtn.parentElement.style.display = 'none';
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
    @endif

@endsection