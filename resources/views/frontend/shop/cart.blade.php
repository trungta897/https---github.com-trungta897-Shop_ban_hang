@extends('frontend.layouts.master')

@section('title', 'Cart')

@section('body')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Shopping Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <table cellspacing="0" class="shop_table cart">
                                <thead>
                                    <tr>
                                        <th class="product-remove">Remove</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr class="cart_item">
                                            <td class="product-remove">
                                                <!-- Form riêng cho xóa sản phẩm -->
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="remove" title="Remove this item">×</button>
                                                </form>
                                            </td>

                                            <td class="product-thumbnail">
                                                <a href="single-product.html">
                                                    <img width="145" height="145" alt="{{ $item->product->name }}"
                                                        class="shop_thumbnail" src="{{ $item->product->image }}">
                                                </a>
                                            </td>
                                            <td class="product-price">
                                                <span class="amount">{{ number_format($item->price) }} VND</span>
                                            </td>

                                            <td class="product-quantity">
                                                <!-- Form riêng cho cập nhật số lượng -->
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="quantity buttons_added">

                                                        <input type="number" id="qty-{{ $item->id }}" size="4"
                                                            class="input-text qty text" name="quantity" title="Qty"
                                                            value="{{ $item->quantity }}" min="0" step="1">

                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </td>

                                            <td class="product-subtotal">
                                                <span class="amount">{{ $item->price * $item->quantity }} VND</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="actions" colspan="6">
                                            <!-- Nếu bạn có form riêng để cập nhật toàn bộ giỏ hàng, đặt ở đây -->
                                            <!-- Hoặc sử dụng liên kết cho chuyển sang trang thanh toán -->
                                            <a href="{{ route('checkout.index') }}"
                                                class="checkout-button button alt wc-forward">Proceed to Checkout</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="cart-collaterals">
                                <div class="cross-sells">
                                    <h2>You may be interested in...</h2>
                                    <div class="related-products">
                                        {{-- Code hiển thị các sản phẩm liên quan --}}
                                    </div>
                                </div>
                            </div>
                        </div><!-- .woocommerce -->
                    </div><!-- .product-content-right -->
                </div><!-- .col-md-12 -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .single-product-area -->

@endsection

