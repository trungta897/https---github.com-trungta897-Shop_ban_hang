<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Products; // Sửa Products thành Product nếu tuân theo quy ước Laravel
use App\Service\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function show()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        return view('frontend.shop.cart', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }

        $product = Products::find($request->product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }

        // Kiểm tra số lượng tồn kho
        $quantityRequested = (int)$request->quantity;
        if ($product->stock === null || $product->stock < $quantityRequested) {
            return redirect()->back()->with('error', 'Số lượng tồn kho không đủ.');
        }

        // Tạo bản ghi mới trong cart_items
        $cartItem = new CartItem();
        $cartItem->user_id = $userId;
        $cartItem->product_id = $request->product_id;
        $cartItem->quantity = $quantityRequested;
        $cartItem->price = $product->price;
        $cartItem->save();

        // Trừ số lượng trong stock
        $product->stock -= $quantityRequested;
        $product->save();

        return redirect()->route('cart.show')->with('success', 'Đã thêm sản phẩm vào giỏ hàng và cập nhật tồn kho!');
    }

    public function remove($id)
    {
        $cartItem = CartItem::find($id);
        if ($cartItem && $cartItem->user_id == Auth::id()) {
            // Hoàn lại số lượng vào stock khi xóa khỏi giỏ hàng
            $product = Products::find($cartItem->product_id);
            if ($product) {
                $product->stock += $cartItem->quantity;
                $product->save();
            }

            $cartItem->delete();
            return redirect()->route('cart.show')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng và cập nhật tồn kho!');
        }
        return redirect()->route('cart.show')->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng!');
    }

    public function removeAll()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        if ($cartItems->isNotEmpty()) {
            foreach ($cartItems as $item) {
                // Hoàn lại số lượng vào stock
                $product = Products::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            CartItem::where('user_id', Auth::id())->delete();
            return redirect()->route('cart.show')->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng và cập nhật tồn kho!');
        }

        return redirect()->route('cart.show')->with('error', 'Giỏ hàng của bạn đang trống!');
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::find($id);

        if (!$cartItem || $cartItem->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        $product = Products::find($cartItem->product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }

        $newQuantity = (int)$request->quantity;
        $oldQuantity = $cartItem->quantity;

        if ($newQuantity == 0) {
            // Hoàn lại stock khi xóa
            $product->stock += $oldQuantity;
            $product->save();
            $cartItem->delete();
            return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng và cập nhật tồn kho.');
        }

        // Kiểm tra stock khi cập nhật số lượng
        $quantityDifference = $newQuantity - $oldQuantity;
        if ($quantityDifference > 0 && $product->stock < $quantityDifference) {
            return redirect()->back()->with('error', 'Số lượng tồn kho không đủ để cập nhật.');
        }

        // Cập nhật stock
        $product->stock -= $quantityDifference;
        $product->save();

        // Cập nhật giỏ hàng
        $cartItem->quantity = $newQuantity;
        $cartItem->price = $request->price ?? $cartItem->price;
        $cartItem->save();

        return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật thành công và tồn kho đã được điều chỉnh.');
    }

    public function relatedShow($id)
    {
        $products = $this->productService->find($id);
        $relatedProducts = $this->productService->getRelatedProducts($products, 5);
        return view('frontend.shop.single-product', compact('products', 'relatedProducts'));
    }
}
