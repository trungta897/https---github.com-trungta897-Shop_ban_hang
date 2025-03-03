@extends('frontend.layouts.master')

@section('title', 'Seller Dashboard')

@section('content')
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
                <!-- Phần Thêm Sản Phẩm -->
                <div id="addProduct" class="mb-5">
                    <h2>Thêm Sản Phẩm</h2>
                    <form action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên Sản Phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá (VND)</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô Tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Hình Ảnh</label>
                            <input type="file" class="form-control-file" id="image" name="image" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
                    </form>
                </div>

                <!-- Phần Quản Lý Đơn Hàng -->
                <div id="orders" class="mb-5">
                    <h2>Quản Lý Đơn Hàng</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã Đơn</th>
                                <th>Sản Phẩm</th>
                                <th>Số Lượng</th>
                                <th>Trạng Thái</th>
                                <th>Cập Nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->order_id }}</td>
                                    <td>
                                        @foreach($order->orderDetails as $detail)
                                            <p>{{ $detail->product_name }} ({{ $detail->quantity }})</p>
                                        @endforeach
                                    </td>
                                    <td>{{ $order->orderDetails->sum('quantity') }}</td>
                                    <td>
                                        <form action="{{ route('seller.order.update', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-control" onchange="this.form.submit()">
                                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>
                                                    Processing</option>
                                                <option value="Shipping" {{ $order->status == 'Shipping' ? 'selected' : '' }}>
                                                    Shipping</option>
                                                <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>
                                                    Delivered</option>
                                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>
                                                    Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('seller.order.show', $order->id) }}" class="btn btn-info btn-sm">Xem
                                            chi tiết</a>
                                    </td>
                                </tr>
                            @endforeach
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
                                <th>Tên Sản Phẩm</th>
                                <th>Giá</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ number_format($product->price) }} VND</td>
                                    <td>
                                        <a href="{{ route('seller.product.edit', $product->id) }}"
                                            class="btn btn-warning btn-sm">Sửa</a>
                                        <form action="{{ route('seller.product.destroy', $product->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Sử dụng Chart.js để hiển thị biểu đồ doanh thu -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('revenueChartCanvas').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!}, // Mảng nhãn thời gian, ví dụ: ['Tháng 1', 'Tháng 2', ...]
                datasets: [{
                    label: 'Doanh Thu (VND)',
                    data: {!! json_encode($chartData) !!}, // Mảng dữ liệu doanh thu tương ứng
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
