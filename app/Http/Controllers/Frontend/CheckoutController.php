<?php

namespace App\Http\Controller\Frontend;

use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'buyer_address' => 'required|string|max:255',
            'buyer_phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get product details
            $product = Products::findOrFail($request->product_id);

            // Get buyer details (assuming authenticated user)
            $buyer = Auth::user();

            // Get seller details
            $seller = User::findOrFail($product->user_id); // Giả sử product belongs to user (seller)

            // Prepare order data
            $orderData = [
                'order_id' => 'ORD-' . uniqid(),
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'buyer_id' => $buyer->id,
                'buyer_name' => $buyer->name,
                'seller_id' => $seller->id,
                'seller_name' => $seller->name,
                'buyer_address' => $request->buyer_address,
                'buyer_phone' => $request->buyer_phone,
                'status' => 'Pending',
            ];

            // Create order
            $order = OrderDetail::create($orderData);

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'order' => $order
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }
}
