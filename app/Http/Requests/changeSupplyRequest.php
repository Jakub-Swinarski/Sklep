<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class changeSupplyRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'supply' => ['required', 'integer']
        ];
    }
}
