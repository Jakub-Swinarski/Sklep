<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'file', 'image', 'max:10240'],
            'product_id' => ['required', 'integer', 'min:1', 'exists:products,id']
        ];
    }
}
