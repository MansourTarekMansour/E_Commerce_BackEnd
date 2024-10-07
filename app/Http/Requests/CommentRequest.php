<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'comment' => 'required|string|max:1000',
            'rate' => 'required|integer|min:1|max:5',
        ];
    }

    public function authorize()
    {
        return true; // Allow all users to make comments
    }
}
