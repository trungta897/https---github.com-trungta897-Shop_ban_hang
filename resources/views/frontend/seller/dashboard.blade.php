@extends('frontend.layouts.master')

@section('title', 'Seller Dashboard')

@section('body')
<div class="container">
    <h1 class="mt-4">Seller Dashboard</h1>
    <div class="row">
        <!-- Sidebar điều hướng -->
        <div class="col-md-3">
            <ul class="list-group">
                <li class="list-group-item"><a href="#addProduct">Thêm Sản Phẩm</a></li>
                <li class="list-group-item"><a href="#orders">Quản Lý Đơn Hàng</a></li>
                <li class="list-group-item"><a href="#revenueChart">Biểu Đồ Doanh Thu</a></li>
                <li class="list-group-item"><a href="#productList">Quản Lý Sản Phẩm</a></li>
            </ul>
        </div>

        <!-- Nội dung chính -->
        <div class="col-md-9">
            <!-- Debug dữ liệu -->
            <div class="mb-3">
                <p><strong>Số sản phẩm:</strong> {{ $products->count() }}</p>
                <p><strong>Số đơn hàng:</strong> {{ $orders->count() }}</p>
            </div>

            <!-- Phần Thêm Sản Phẩm -->
            <div id="addProduct" class="mb-5">
                <h2>Thêm sản phẩm</h2>
                <form action="{{ route('seller.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên sản phẩm</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Hình ảnh</label>
                        <input type="file" name="image" id="image" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label for="category">Danh mục</label>
                        <input type="text" name="category" id="category" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="featured">Sản phẩm nổi bật</label>
                        <select name="featured" id="featured" class="form-control" required>
                            <option value="1">Có</option>
                            <option value="0">Không</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Số lượng sản phẩm có sẵn</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="brand">Nhãn hàng</label>
                        <input type="text" name="brand_name" id="brand_name" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </form>
            </div>

            <!-- Phần Quản Lý Đơn Hàng -->
            <div id="orders" class="mb-5">
                <h2>Quản Lý Đơn Hàng</h2>
                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->product_name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>
                                    <form action="{{ route('seller.update.order', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-control" onchange="this.form.submit()">
                                            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="Shipping" {{ $order->status == 'Shipping' ? 'selected' : '' }}>Shipping</option>
                                            <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('seller.show.order', $order->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Chưa có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Phần Biểu Đồ Doanh Thu -->
            <div id="revenueChart" class="mb-5">
                <h2>Biểu Đồ Doanh Thu</h2>
                <canvas id="revenueChartCanvas" width="400" height="200"></canvas>
            </div>

            <!-- Phần Quản Lý Sản Phẩm -->
            <div id="productList" class="mb-5">
                <h2>Quản Lý Sản Phẩm</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td><a href="{{ route('product.show', $product->id) }}"><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px;"></a></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price) }} VND</td>
                                <td>
                                    <a href="{{ route('seller.edit', $product->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    <form action="{{ route('seller.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Chưa có sản phẩm nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection