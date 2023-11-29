<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'surname' => ['required', 'string', 'min:3', 'max:255'],
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'city' => ['required', 'string', 'min:3', 'max:255'],
            'zipcode' => ['required', 'digits:5'],
            'number' => ['required', 'integer', 'digits:9'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ];
    }
}
