<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;

class OrderApiController extends Controller
{
    // Get all orders for the authenticated customer
    public function index()
    {
        try {
            $orders = Order::with('orderItems.product')->where('customer_id', Auth::id())->get();

            if ($orders->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => __('order.orders_not_found'),
                ], 404);
            }
            $orders->load('address');
            return response()->json([
                'status' => true,
                'message' => __('order.orders_retrieved_successfully'),
                'data' => OrderResource::collection($orders),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('order.order_retrieval_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Create a new order
    public function store(OrderRequest $request)
    {
        try {
            // Retrieve the customer's cart
            $cart = Cart::with('cartItems.product')->where('customer_id', Auth::id())->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => __('order.cart_empty'),
                ], 400);
            }

            // Calculate the total amount
            $totalAmount = $cart->cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $addressId = $request->input('address_id'); 

            if (!$addressId) {
                return response()->json([
                    'status' => false,
                    'message' => __('order.address_required'), 
                ], 400);
            }

            // Create the order
            $order = Order::create([
                'customer_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'address_id' => $addressId,
            ]);

            // Add order items
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
            }

            // Clear the cart after placing the order
            $cart->cartItems()->delete();

            $order->load('address');
            return response()->json([
                'status' => true,
                'message' => __('order.order_created_successfully'),
                'data' => new OrderResource($order),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('order.order_creation_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Update the status of an order
    public function updateStatus(Order $order, $status)
    {
        try {
            // Ensure that the authenticated customer is updating their own order
            if ($order->customer_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => __('order.order_update_failed', ['error' => 'Unauthorized']),
                ], 403);
            }

            // Check if the payment exists and is successful for completed status
            if ($status === 'completed') {
                $payment = Payment::where('order_id', $order->id)->where('status', 'successful')->first(); // Assuming 'successful' is your completed payment status
                if (!$payment) {
                    return response()->json([
                        'status' => false,
                        'message' => __('order.order_update_failed', ['error' => __('payment.payment_required')]),
                    ], 400);
                }
            }

            // Validate the status
            if (!in_array($status, ['pending', 'completed', 'canceled'])) {
                return response()->json([
                    'status' => false,
                    'message' => __('order.order_update_failed', ['error' => __('payment.invalid_order_status')]),
                ], 400);
            }

            // Update the order status
            $order->update(['status' => $status]);

            return response()->json([
                'status' => true,
                'message' => __('order.order_updated_successfully'),
                'data' => new OrderResource($order),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('order.order_update_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Get a specific order by ID
    public function show(Order $order)
    {
        try {
            // Ensure the customer owns the order
            if ($order->customer_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => __('order.order_retrieval_failed', ['error' => 'Unauthorized']),
                ], 403);
            }

            return response()->json([
                'status' => true,
                'message' => __('order.order_retrieved_successfully'),
                'data' => new OrderResource($order),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('order.order_retrieval_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }
}
