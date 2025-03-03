@extends('frontend.layouts.master')

@section('title', 'Order Success')

@section('body')
<div class="container" style="margin-top: 50px;">
    <h2>Đơn hàng của bạn đã được đặt thành công!</h2>
    <p>Mã đơn hàng: <strong>{{ $orderId }}</strong></p>
</div>
@endsection
