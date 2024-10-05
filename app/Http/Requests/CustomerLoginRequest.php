<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerLoginRequest extends FormRequest
{
    // Define validation rules
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8',
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
                'message' => __('validation.validation_errors'), // Use localized message
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
