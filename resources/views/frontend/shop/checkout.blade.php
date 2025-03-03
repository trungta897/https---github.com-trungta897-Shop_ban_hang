@extends('frontend.layouts.master')

@section('title', 'Place Order')

@section('body')
<div class="container" style="margin-top: 50px;">
    <h2 class="text-center">Confirm Your Order</h2>

    <!-- Hiển thị thông tin người dùng -->
    <div class="user-info" style="margin-bottom: 30px;">
        <h3>Your Information</h3>
        <p><strong>Name:</strong> {{ Auth::user()->username }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>Phone:</strong> {{ Auth::user()->phone ?? 'Not provided' }}</p>
        <p><strong>Address:</strong> {{ Auth::user()->address ?? 'Not provided' }}</p>
    </div>

    <!-- Hiển thị chi tiết đơn hàng từ giỏ hàng -->
    <div class="order-details" style="margin-bottom: 30px;">
        <h3>Your Order Details</h3>
        @if($cartItems->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price ?? $item->product->price) }} VND</td>
                        <td>{{ number_format(($item->price ?? $item->product->price) * $item->quantity) }} VND</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Order Total</th>
                        <th>{{ number_format($orderTotal) }} VND</th>
                    </tr>
                </tfoot>
            </table>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>

    <!-- Form đặt hàng -->
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="buyer_address">Address</label>
            <input type="text" id="buyer_address" name="buyer_address" class="form-control" value="{{ old('buyer_address', Auth::user()->address ?? '') }}" required>
        </div>
        <div class="form-group">
            <label for="buyer_phone">Phone</label>
            <input type="text" id="buyer_phone" name="buyer_phone" class="form-control" value="{{ old('buyer_phone', Auth::user()->phone ?? '') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Place Order Now</button>
    </form>
</div>
@endsection
