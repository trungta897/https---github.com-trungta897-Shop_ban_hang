<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Service\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService) {
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

        // Tạo bản ghi mới trong cart_items
        $cartItem = new CartItem();
        $cartItem->user_id = $userId; // Gán user_id
        $cartItem->product_id = $request->product_id;
        $cartItem->quantity = $request->quantity;
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

    public function update(Request $request, $id)
    {
        // Cập nhật số lượng sản phẩm trong giỏ hàng
        $cartItem = CartItem::find($id);
        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return redirect()->route('cart.show')->with('success', 'Đã cập nhật giỏ hàng thành công!');
        }
        return redirect()->route('cart.show')->with('error', 'Không tìm thấy sản phẩm để cập nhật!');
    }

    // public function relatedShow($id) {
    //     $products = $this->productService->find($id);
    //     $relatedProducts = $this->productService->getRelatedProducts($products, 5);
    //     return view('frontend.shop.single-product', compact('products', 'relatedProducts'));
    // }
}
