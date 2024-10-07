<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\CartItem;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;

class CartApiController extends Controller
{
    // Get cart for authenticated user
    public function index()
    {
        try {
            $cart = Cart::with('cartItems.product')->where('customer_id', Auth::id())->first();

            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => __('cart.cart_not_found'),
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => __('cart.cart_retrieved_successfully'),
                'data' => new CartResource($cart),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('cart.cart_retrieval_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }
    // Add an item to the cart
    public function addItem(CartItemRequest $request)
    {
        try {
            // Find or create a cart for the authenticated customer
            $cart = Cart::firstOrCreate([
                'customer_id' => Auth::id(),
            ]);

            // Add the item to the cart
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('cart.item_added_successfully'),
                'data' => $cartItem,  // Return the created cart item
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('cart.item_addition_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Update a cart item (e.g., change quantity)
    public function updateItem(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        try {
            // Check if the cart belongs to the authenticated customer
            if ($cartItem->cart->customer_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => __('cart.item_update_failed', ['error' => 'Unauthorized']),
                ], 403);
            }

            // Update the cart item
            $cartItem->update($request->only(['quantity']));

            return response()->json([
                'status' => true,
                'message' => __('cart.item_updated_successfully'),
                'data' => $cartItem,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('cart.item_update_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Remove an item from the cart
    public function removeItem(CartItem $cartItem)
    {
        try {
            // Check if the cart belongs to the authenticated customer
            if ($cartItem->cart->customer_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => __('cart.item_removal_failed', ['error' => 'Unauthorized']),
                ], 403);
            }

            // Remove the cart item
            $cartItem->delete();

            return response()->json([
                'status' => true,
                'message' => __('cart.item_removed_successfully'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('cart.item_removal_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Get the cart items for the authenticated customer
    public function getCart()
    {
        try {
            // Find the customer's cart
            $cart = Cart::with('cartItems.product')->where('customer_id', Auth::id())->first();

            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => __('cart.cart_not_found'),
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => __('cart.cart_retrieved_successfully'),
                'data' => $cart->cartItems,  // Return the cart items
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('cart.cart_retrieval_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }
}
