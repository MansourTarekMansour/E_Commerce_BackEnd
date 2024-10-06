<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;

class CustomerApiController extends Controller
{
    // Get the authenticated customer's profile
    public function profile()
    {
        try {
            $customer = Auth::guard('api')->user();

            return response()->json([
                'status' => true,
                'message' => __('customer.profile_retrieved_successfully'),
                'data' => new CustomerResource($customer)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('customer.profile_retrieval_failed', ['error' => $e->getMessage()]),
                'data' => null
            ], 500);
        }
    }

    // Update the authenticated customer's profile
    public function update(UpdateCustomerRequest $request)
    {
        try {
            $customer = Auth::guard('api')->user();
            $customer->update($request->validated());

            // Update password if provided
            if ($request->filled('password')) {
                $customer->password = Hash::make($request->password);
                $customer->save();
            }
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $customer->storeImage($request->file('image')); // Use the storeImage method
            }

            return response()->json([
                'status' => true,
                'message' => __('customer.profile_updated_successfully'),
                'data' => new CustomerResource($customer)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('customer.profile_update_failed', ['error' => $e->getMessage()]),
                'data' => null
            ], 500);
        }
    }

    // Delete customer account
    public function destroy()
    {
        try {
            $customer = Auth::guard('api')->user();
            $customer->delete(); // Delete customer
            Auth::guard('api')->logout(); // Logout after deleting

            return response()->json([
                'status' => true,
                'message' => __('customer.account_deleted_successfully'),
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('customer.account_deletion_failed', ['error' => $e->getMessage()]),
                'data' => null
            ], 500);
        }
    }

    // Show a specific customer (for admins or privileged users)
    public function show($id)
    {
        try {
            $customer = Customer::with(['orders', 'cart.cartItems'])->find($id);

            if (!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => __('customer.customer_not_found'),
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => __('customer.customer_retrieved_successfully'),
                'data' => new CustomerResource($customer)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('customer.customer_retrieval_failed', ['error' => $e->getMessage()]),
                'data' => null
            ], 500);
        }
    }
}
