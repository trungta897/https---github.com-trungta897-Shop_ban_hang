<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        $cartSubtotal = 0;
        foreach ($cartItems as $item) {
            $price = $item->price ?? ($item->product->price ?? 0);
            $cartSubtotal += $price * $item->quantity;
        }

        $orderTotal = $cartSubtotal;

        return view('frontend.shop.checkout', compact('cartItems', 'cartSubtotal', 'orderTotal'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'buyer_address' => 'required|string|max:255',
            'buyer_phone'   => 'required|string|max:20',
        ]);

        $cartItems = CartItem::where('user_id', Auth::id())->with('product.seller')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn trống.');
        }

        $user = Auth::user();
        $orderId = 'ORD' . time() . rand(100, 999);

        foreach ($cartItems as $item) {
            $product = $item->product;
            if (!$product) {
                continue;
            }

            // Không trừ stock ở đây vì đã trừ khi thêm vào giỏ hàng
            OrderDetail::create([
                'order_id'      => $orderId,
                'product_id'    => $product->id,
                'product_name'  => $product->name,
                'quantity'      => $item->quantity,
                'price'         => $product->price,
                'buyer_id'      => $user->id,
                'buyer_name'    => $user->username,
                'seller_id'     => 2, // Cố định seller_id = 2 theo yêu cầu trước
                'seller_name'   => User::find(2)->username ?? null,
                'buyer_address' => $validatedData['buyer_address'],
                'buyer_phone'   => $validatedData['buyer_phone'],
                'status'        => 'Pending',
                'created_at'    => now(),
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng thành công
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('checkout.success')->with('order_id', $orderId);
    }

    public function success(Request $request)
    {
        $orderId = session('order_id');
        return view('frontend.shop.success', compact('orderId'));
    }
}
