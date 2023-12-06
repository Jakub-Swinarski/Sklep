<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewOrderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'address_id' => ['required', 'integer','exists:address,id'],
            'user_id' => ['required', 'integer','exists:users,id'],
            'delivery' => ['required', 'string'],
            'pay_type' => ['required','string'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'integer','exists:products,id'],
            'products.*.numberOfItems' => ['required', 'integer','min:1']
        ];
    }
}
