<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PaymentResource; // Import the PaymentResource
use App\Http\Resources\PaymentResourceCollection; // Import the PaymentResourceCollection

class PaymentApiController extends Controller
{
    // Get all payments for the authenticated customer
    public function index()
    {
        try {
            $payments = Payment::where('customer_id', Auth::id())->get(); // Fetch payments for the authenticated customer

            return response()->json([
                'status' => true,
                'message' => __('payment.payments_retrieved_successfully'),
                'data' => PaymentResource::collection($payments), // Use PaymentResource to transform the collection
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('payment.payments_retrieval_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Store a new payment
    public function store(PaymentRequest $request)
    {
        try {
            // Create a new payment
            $payment = Payment::create([
                'order_id' => $request->order_id,
                'customer_id' => Auth::id(), 
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
                'transaction_id' => $request->transaction_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('payment.payment_successful'),
                'data' => new PaymentResource($payment), 
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('payment.payment_creation_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Get payment details
    public function show(Payment $payment)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => __('payment.payments_retrieved_successfully'),
                'data' => new PaymentResource($payment), // Use PaymentResource for the response
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('payment.payment_retrieval_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }
}
