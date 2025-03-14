<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Routing\Controller as BaseController;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\Brands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends BaseController
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $user = Auth::user();
        $products = Products::where('seller_id', $user->id)->get(); // Lấy sản phẩm của người bán
        $orders = $user->sellerOrders ?? collect();
        $categories = Products::select('category')->distinct()->get();
        if ($categories->isEmpty()) {
            $categories = collect([['category' => 'Chưa có danh mục']]);
        }
        $revenueData = $orders->groupBy(fn($order) => \Carbon\Carbon::parse($order->created_at)->format('Y-m'))
            ->map(fn($group) => $group->sum('total_price')); // Giả sử có total_price
        $chartLabels = $revenueData->keys();
        $chartData = $revenueData->values();

        return view('frontend.seller.dashboard', compact('products', 'orders', 'chartLabels', 'chartData'));
    }

    // Hiển thị form thêm sản phẩm
    public function create()
    {
        return view('frontend.seller.create');
    }

    // Xử lý thêm sản phẩm
    public function store(Request $request)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'brand_name'  => 'required|string|max:100',
            'name'        => 'required|string|max:100',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category'    => 'nullable|string|max:50',
            'featured'    => 'required|boolean',
            'quantity'    => 'required|integer',      // Ánh xạ đến trường stock
            'description' => 'nullable|string',         // Ánh xạ đến trường detail
        ]);

        // Xử lý brand: Nếu brand_name chưa tồn tại thì tự động tạo mới và lấy brand_id
        $brand = Brands::firstOrCreate(
            ['name' => $request->brand_name],
            ['created_at' => now()] // Bạn có thể cập nhật thêm các trường khác như description, logo nếu cần
        );

        // Lấy các dữ liệu cần thiết và ánh xạ tên trường
        $data = $request->only(['name', 'price', 'category', 'featured']);
        $data['stock']      = $request->quantity;
        $data['detail']     = $request->description;
        $data['seller_id']  = Auth::id();
        $data['brand_id']   = $brand->id;
        $data['brand_name'] = $brand->name; // Lưu lại brand_name nếu bạn vẫn muốn lưu ở bảng products
        $data['created_at'] = now();

        // Nếu có file hình ảnh được upload thì lưu file và cập nhật đường dẫn
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Products::create($data);

        return redirect()->route('seller.dashboard')->with('success', 'Thêm sản phẩm thành công!');
    }

    // Hiển thị form sửa sản phẩm
    public function edit(Products $product)
    {
        // Kiểm tra quyền chỉnh sửa: Sản phẩm phải thuộc đơn hàng của người bán
        $sellerOrders = Auth::user()->sellerOrders;
        if (!$sellerOrders->pluck('product_id')->contains($product->id)) {
            abort(403, 'Bạn không có quyền chỉnh sửa sản phẩm này.');
        }
        return view('frontend.seller.edit', compact('product'));
    }

    // Xử lý sửa sản phẩm
    public function update(Request $request, Products $product)
    {
        // Kiểm tra quyền chỉnh sửa: Sản phẩm phải thuộc đơn hàng của người bán
        $sellerOrders = Auth::user()->sellerOrders;
        if (!$sellerOrders->pluck('product_id')->contains($product->id)) {
            abort(403, 'Bạn không có quyền chỉnh sửa sản phẩm này.');
        }

        $request->validate([
            'name'        => 'required|string|max:100',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category'    => 'nullable|string|max:50',
            'featured'    => 'required|boolean',
            'quantity'    => 'nullable|integer',
            'description' => 'nullable|string',
            'brand_id'    => 'nullable|exists:brands,id',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->featured = $request->featured;
        $product->stock = $request->quantity;
        $product->detail = $request->description;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('seller.dashboard')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    // Xóa sản phẩm
    public function destroy(Products $product)
    {
        // Kiểm tra quyền xóa: Sản phẩm phải thuộc đơn hàng của người bán
        $sellerOrders = Auth::user()->sellerOrders;
        if (!$sellerOrders->pluck('product_id')->contains($product->id)) {
            abort(403, 'Bạn không có quyền xóa sản phẩm này.');
        }

        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return redirect()->route('seller.dashboard')->with('success', 'Sản phẩm đã được xóa thành công.');
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrder(Request $request, $orderId)
    {
        $order = OrderDetail::where('seller_id', Auth::id())->findOrFail($orderId);
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipping,Delivered,Cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('seller.dashboard')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

    // Hiển thị chi tiết đơn hàng
    public function showOrder($orderId)
    {
        $order = OrderDetail::where('seller_id', Auth::id())->findOrFail($orderId);
        return view('frontend.seller.order-details', compact('order'));
    }
}
