<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use Illuminate\Support\Facades\Auth;

class AddressApiController extends Controller
{
    // Get all addresses for the authenticated customer
    public function index()
    {
        try {
            $addresses = Address::where('customer_id', Auth::id())->get();

            return response()->json([
                'status' => true,
                'message' => __('address.addresses_retrieved_successfully'),
                'data' => AddressResource::collection($addresses),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('address.address_retrieval_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Store a new address
    public function store(AddressRequest $request)
    {
        try {
            $address = Address::create([
                'customer_id' => Auth::id(),
                'order_id' => $request->order_id,
                'street' => $request->street,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('address.address_created_successfully'),
                'data' => new AddressResource($address),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('address.address_creation_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Update an existing address
    public function update(AddressRequest $request, Address $address)
    {
        try {
            // Check if the address belongs to the authenticated customer
            if ($address->customer_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => __('address.address_update_failed', ['error' => 'Unauthorized']),
                ], 403);
            }

            $address->update($request->only(['street', 'city', 'state', 'country']));

            return response()->json([
                'status' => true,
                'message' => __('address.address_updated_successfully'),
                'data' => new AddressResource($address),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('address.address_update_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Delete an address
    public function destroy(Address $address)
    {
        try {
            // Check if the address belongs to the authenticated customer
            if ($address->customer_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => __('address.address_deletion_failed', ['error' => 'Unauthorized']),
                ], 403);
            }

            $address->delete();

            return response()->json([
                'status' => true,
                'message' => __('address.address_deleted_successfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('address.address_deletion_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }
}
