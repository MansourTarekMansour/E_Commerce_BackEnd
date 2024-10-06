<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCustomerRequest extends FormRequest
{
    // Define validation rules
    public function rules(): array
    {
        \Log::info($this->all());

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $this->user()->id,
            'phone_number' => 'required|string|size:11|unique:customers,phone_number,' . $this->user()->id,
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function messages(): array
    {
        return __('customer');
    }

    // Handle failed validation
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => __('customer.validation_errors'),
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
