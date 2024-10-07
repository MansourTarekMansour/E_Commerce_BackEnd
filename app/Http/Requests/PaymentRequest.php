<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users for now, implement authorization if needed
    }

    public function rules()
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'transaction_id' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => __('validation.required'),
            'order_id.exists' => __('validation.exists', ['attribute' => 'order_id']),
            'customer_id.required' => __('validation.required'),
            'customer_id.exists' => __('validation.exists', ['attribute' => 'customer_id']),
            'amount.required' => __('validation.required'),
            'amount.numeric' => __('validation.numeric'),
            'amount.min' => __('validation.min.numeric'),
            'payment_method.required' => __('validation.required'),
            'payment_method.string' => __('validation.string'),
            'payment_method.max' => __('validation.max.string'),
            'status.required' => __('validation.required'),
            'status.string' => __('validation.string'),
            'status.max' => __('validation.max.string'),
            'transaction_id.required' => __('validation.required'),
            'transaction_id.string' => __('validation.string'),
            'transaction_id.max' => __('validation.max.string'),
        ];
    }
}
