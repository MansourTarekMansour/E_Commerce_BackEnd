<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\CustomerLoginRequest;
use App\Http\Requests\CustomerRegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class AuthController extends Controller
{
    // Register a new customer
    public function register(CustomerRegisterRequest $request): JsonResponse
    {
        try {
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
            ]);

            // Generate JWT token
            $token = auth('api')->login($customer);

            return response()->json([
                'status' => 'success',
                'message' => __('auth.registration_success'),
                'customer' => new CustomerResource($customer),
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.registration_error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Login a customer
    public function login(CustomerLoginRequest $request): JsonResponse
    {
        try {
            // Attempt to log in with the provided credentials
            $credentials = $request->only('email', 'password');

            // Use auth('api') to attempt login and get the token
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('auth.invalid_credentials'),
                ], 401);
            }

            // Get the authenticated customer
            $customer = auth('api')->user();

            return response()->json([
                'status' => 'success',
                'message' => __('auth.login_success'),
                'customer' => new CustomerResource($customer),
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.login_error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Logout a customer
    public function logout(): JsonResponse
    {
        try {
            // Invalidate the JWT token using auth('api')
            auth('api')->logout();

            return response()->json([
                'status' => 'success',
                'message' => __('auth.logout_success'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.logout_error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Refresh JWT token
    public function refresh(): JsonResponse
    {
        try {
            // Refresh the token using auth('api')
            $token = auth('api')->refresh();

            return response()->json([
                'status' => 'success',
                'message' => __('auth.token_refreshed'),
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.refresh_error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
