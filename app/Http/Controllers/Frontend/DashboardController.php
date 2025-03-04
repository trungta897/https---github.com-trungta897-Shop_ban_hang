<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $user = Auth::user();
        $sellerOrders = $user->sellerOrders ?? collect();
        $productIds = $sellerOrders->pluck('product_id')->all();
        $products = Products::whereIn('id', $productIds)->get();
        $orders = $sellerOrders;

        // // Debug
        // dump('User ID: ' . $user->id);
        // dump('Seller Orders Count: ' . $sellerOrders->count());
        // dump('Product IDs: ', $productIds);
        // dump('Products Count: ' . $products->count());
        // dump('Orders Count: ' . $orders->count());

        return view('frontend.seller.dashboard', compact('products', 'orders'));
    }

    // Hiển thị form thêm sản phẩm
    public function create()
    {
        return view('frontend.seller.create');
    }

    // Xử lý thêm sản phẩm
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:50',
            'featured' => 'required|boolean',
            'stock' => 'nullable|integer',
            'detail' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        $product = new Products();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->featured = $request->featured;
        $product->stock = $request->stock;
        $product->detail = $request->detail;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('seller.dashboard')->with('success', 'Sản phẩm đã được thêm thành công.');
    }

    // Hiển thị form sửa sản phẩm
    public function edit(Products $product)
    {
        // Kiểm tra xem sản phẩm có trong đơn hàng của người bán không
        $sellerOrders = Auth::user()->sellerOrders;
        if (!$sellerOrders->pluck('product_id')->contains($product->id)) {
            abort(403, 'Bạn không có quyền chỉnh sửa sản phẩm này.');
        }
        return view('frontend.seller.edit', compact('product'));
    }

    // Xử lý sửa sản phẩm
    public function update(Request $request, Products $product)
    {
        // Kiểm tra xem sản phẩm có trong đơn hàng của người bán không
        $sellerOrders = Auth::user()->sellerOrders;
        if (!$sellerOrders->pluck('product_id')->contains($product->id)) {
            abort(403, 'Bạn không có quyền chỉnh sửa sản phẩm này.');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:50',
            'featured' => 'required|boolean',
            'stock' => 'nullable|integer',
            'detail' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->featured = $request->featured;
        $product->stock = $request->stock;
        $product->detail = $request->detail;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('seller.dashboard')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    // Xóa sản phẩm
    public function destroy(Products $product)
    {
        // Kiểm tra xem sản phẩm có trong đơn hàng của người bán không
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
