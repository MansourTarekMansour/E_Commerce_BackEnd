<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ensure only authorized customers make orders
    }

    public function rules()
    {
        return [
            'address_id' => 'required|exists:addresses,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => __('validation.validation_errors'),
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
