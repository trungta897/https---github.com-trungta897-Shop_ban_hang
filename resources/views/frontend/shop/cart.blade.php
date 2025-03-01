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
                            <form method="post" action="#">
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                        <tr>
                                            <th class="product-remove">&nbsp;</th>
                                            <th class="product-thumbnail">&nbsp;</th>
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
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="remove" title="Remove this item">×</button>
                                                    </form>
                                                </td>

                                                <td class="product-thumbnail">
                                                    <a href="single-product.html"><img width="145" height="145"
                                                        alt="{{ $item->product->name }}" class="shop_thumbnail"
                                                        src="{{ $item->product->image }}"></a>
                                                </td>

                                                <td class="product-name">
                                                    <a href="single-product.html">{{ $item->product_name }}</a>
                                                </td>

                                                <td class="product-price">
                                                    <span class="amount">${{ $item->price }}</span>
                                                </td>

                                                <td class="product-quantity">
                                                    <div class="quantity buttons_added">
                                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="button" class="minus" value="-">
                                                            <input type="number" size="4" class="input-text qty text" name="quantity" title="Qty"
                                                                value="{{ $item->quantity }}" min="0" step="1">
                                                            <input type="button" class="plus" value="+">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </form>
                                                    </div>
                                                </td>

                                                <td class="product-subtotal">
                                                    <span class="amount">${{ $item->price * $item->quantity }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="actions" colspan="6">
                                                <input type="submit" value="Update Cart" class="button" name="update_cart">
                                                <input type="submit" value="Proceed to Checkout" class="checkout-button button alt wc-forward" name="proceed">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <div class="cart-collaterals">
                                <div class="cross-sells">
                                    <h2>You may be interested in...</h2>
                                    <ul class="products">
                                        <!-- Add your cross-sell products here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
