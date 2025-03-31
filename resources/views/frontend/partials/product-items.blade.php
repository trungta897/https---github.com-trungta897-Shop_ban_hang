{{-- Lưu tại resources/views/frontend/partials/product-items.blade.php --}}

@foreach ($products as $product)
    <div class="col-md-3">
        <div class="single-shop-product">
            <div class="product-upper">
                <img src="storage/{{$product->image}}" alt="{{ $product->name }}" style="height: 250px;width: 250px;">
            </div>
            <h2 class="product-name">
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