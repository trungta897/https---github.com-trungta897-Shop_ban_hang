<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Products;
use App\Service\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function show()
    {
        // Lấy danh sách sản phẩm trong giỏ hàng của người dùng hiện tại
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        return view('frontend.shop.cart', compact('cartItems'));
    }

    public function add(Request $request)
{
    // Lấy user_id từ người dùng hiện tại
    $userId = Auth::id();

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!$userId) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
    }

    // Tìm sản phẩm theo product_id
    $product = Products::find($request->product_id);
    if (!$product) {
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
    }

    // Tạo bản ghi mới trong cart_items
    $cartItem = new CartItem();
    $cartItem->user_id = $userId;
    $cartItem->product_id = $request->product_id;
    $cartItem->quantity = $request->quantity;
    $cartItem->price = $product->price;  // Gán giá sản phẩm vào cart
    $cartItem->save();

    return redirect()->route('cart.show')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
}
    public function remove($id)
    {
        // Xóa sản phẩm khỏi giỏ hàng
        $cartItem = CartItem::find($id);
        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $cartItem->delete();
            return redirect()->route('cart.show')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
        return redirect()->route('cart.show')->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng!');
    }

    public function removeAll()
    {
        // Xóa tất cả sản phẩm của người dùng hiện tại trong giỏ hàng
        $deleted = CartItem::where('user_id', Auth::id())->delete();

        if ($deleted) {
            return redirect()->route('cart.show')->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng!');
        }

        return redirect()->route('cart.show')->with('error', 'Giỏ hàng của bạn đang trống!');
    }

    public function update(Request $request, $id)
{
    // Tìm sản phẩm giỏ hàng theo ID
    $cartItem = CartItem::find($id);

    // Kiểm tra sản phẩm có tồn tại và có thuộc về người dùng hiện tại không
    if (!$cartItem || $cartItem->user_id != Auth::id()) {
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
    }

    // Nếu số lượng bằng 0, xóa sản phẩm khỏi giỏ hàng
    if ($request->quantity == 0) {
        $cartItem->delete();
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    // Nếu số lượng > 0, cập nhật số lượng và giá
    $cartItem->quantity = $request->quantity;
    $cartItem->price = $request->price ?? $cartItem->price; // Use the existing price if not provided
    $cartItem->save();

    return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật thành công.');
}

    public function relatedShow($id)
    {
        $products = $this->productService->find($id);
        $relatedProducts = $this->productService->getRelatedProducts($products, 5);
        return view('frontend.shop.single-product', compact('products', 'relatedProducts'));
    }
}
