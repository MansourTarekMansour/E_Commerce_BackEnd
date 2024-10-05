<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // Get the authenticated customer's profile
    public function profile()
    {
        try {
            $customer = Auth::guard('api')->user();

            return response()->json($customer);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve profile: ' . $e->getMessage()], 500);
        }
    }

    // Update the authenticated customer's profile
    public function update(Request $request)
    {
        try {
            $customer = Auth::guard('api')->user();

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
                'phone_number' => 'required|string|min:11|max:11',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $customer->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
            ]);

            // Update password if provided
            if (!empty($validatedData['password'])) {
                $customer->password = Hash::make($validatedData['password']);
                $customer->save();
            }

            return response()->json(['message' => 'Profile updated successfully', 'customer' => $customer]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Profile update failed: ' . $e->getMessage()], 500);
        }
    }

    // Delete customer account
    public function destroy()
    {
        try {
            $customer = Auth::guard('api')->user();

            $customer->delete(); // Delete customer
            Auth::guard('api')->logout(); // Logout after deleting

            return response()->json(['message' => 'Customer account deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Account deletion failed: ' . $e->getMessage()], 500);
        }
    }

    // Show a specific customer (for admins or privileged users)
    public function show($id)
    {
        try {
            $customer = Customer::with(['orders', 'cart.cartItems'])->find($id);

            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 404);
            }

            return response()->json($customer);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve customer: ' . $e->getMessage()], 500);
        }
    }
}
