<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAddressRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'min:3', 'max:255'],
            'surname' => ['string', 'min:3', 'max:255'],
            'address' => ['string', 'min:3', 'max:255'],
            'city' => ['string', 'min:3', 'max:255'],
            'zipcode' => ['integer', 'digits:5'],
            'number' => ['integer', 'digits:9'],
            'address_id' => ['integer','required', 'exists:address,id']
        ];
    }
}
