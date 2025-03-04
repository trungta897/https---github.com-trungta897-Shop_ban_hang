@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi Tiết Đơn Hàng #{{ $order->order_id }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Người Mua:</strong> {{ $order->buyer_name }}</p>
            <p><strong>Địa Chỉ:</strong> {{ $order->buyer_address }}</p>
            <p><strong>Số Điện Thoại:</strong> {{ $order->buyer_phone }}</p>
            <p><strong>Trạng Thái:</strong> {{ $order->status }}</p>
            <h3>Sản Phẩm</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->product_name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ number_format($order->price, 0) }}</td>
                        <td>{{ number_format($order->price * $order->quantity, 0) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary mt-3">Quay Lại</a>
</div>
@endsection
