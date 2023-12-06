<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewOrderNotLoggedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'delivery' => ['required', 'string'],
            'pay_type' => ['required','string'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'integer','exists:products,id'],
            'products.*.numberOfItems' => ['required', 'integer','min:1'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'surname' => ['required', 'string', 'min:3', 'max:255'],
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'city' => ['required', 'string', 'min:3', 'max:255'],
            'zipcode' => ['required', 'digits:5'],
            'number' => ['required', 'integer', 'digits:9'],
        ];
    }
}
