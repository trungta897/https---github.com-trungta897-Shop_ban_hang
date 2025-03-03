<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang thanh toán (checkout)
     */
    public function index()
{
    // Giả sử bạn lưu giỏ hàng trong session
    $cart = session()->get('cart', []);

    // Tính toán tổng tiền của các sản phẩm trong giỏ hàng
    $cartSubtotal = 0;
    if (!empty($cart)) {
        foreach ($cart as $item) {
            $cartSubtotal += $item['price'] * $item['quantity'];
        }
    }

    // Giả sử Order Total bằng Cart Subtotal (với Free Shipping)
    $orderTotal = $cartSubtotal;

    // Truyền các biến cho view checkout
    return view('frontend.shop.checkout', compact('cart', 'cartSubtotal', 'orderTotal'));
}

    /**
     * Xử lý thanh toán và tạo đơn hàng mới
     */
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào từ form
        $validatedData = $request->validate([
            'product_id'    => 'required|integer|exists:products,id',
            'quantity'      => 'required|integer|min:1',
            'buyer_address' => 'required|string|max:255',
            'buyer_phone'   => 'required|string|max:20',
        ]);

        // Lấy thông tin sản phẩm từ database
        $product = Products::find($validatedData['product_id']);
        if (!$product) {
            return redirect()->back()->withErrors(['product_id' => 'Sản phẩm không hợp lệ.']);
        }

        // Tạo mã đơn hàng (order_id) ví dụ đơn giản: ORD + timestamp + random number
        $orderId = 'ORD' . time() . rand(100, 999);

        // Tạo đơn hàng mới dựa trên migration order_details
        $order = OrderDetail::create([
            'order_id'      => $orderId,
            'product_id'    => $product->id,
            'product_name'  => $product->name,       // giả sử trường name của product
            'quantity'      => $validatedData['quantity'],
            'price'         => $product->price,      // giả sử trường price của product
            'buyer_id'      => Auth::id(),           // lấy id của người mua từ auth
            'buyer_name'    => Auth::user()->name,   // lấy tên người mua
            'seller_id'     => $product->seller_id,    // giả sử product có seller_id
            'seller_name'   => $product->seller->name ?? null, // nếu có quan hệ seller
            'buyer_address' => $validatedData['buyer_address'],
            'buyer_phone'   => $validatedData['buyer_phone'],
            'status'        => 'Pending',            // mặc định là Pending theo migration
            'created_at'    => now(),
        ]);

        // Sau khi tạo đơn hàng thành công, chuyển hướng về trang thông báo hoặc chi tiết đơn hàng
        return redirect()->route('order.success')->with('order_id', $orderId);
    }
}
