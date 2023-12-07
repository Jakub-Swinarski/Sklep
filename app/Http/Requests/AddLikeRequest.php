<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLikeRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required','exists:users,id'],
            'product_id' => ['required','exists:products,id']
        ];
    }
}
