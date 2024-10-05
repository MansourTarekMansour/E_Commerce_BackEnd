<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerRegisterRequest extends FormRequest
{
    // Define validation rules
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|size:11|unique:customers',
        ];
    }

    public function messages(): array
    {
        return __('auth'); // Returns all messages
    }

    // Handle failed validation
    protected function failedValidation(Validator $validator)
    {
        // Throw a custom JSON response
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => __('auth.validation_errors'), // Use localized message
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
