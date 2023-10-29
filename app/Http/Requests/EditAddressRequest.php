<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string','min:3','max:255'],
            'surname' =>['string','min:3','max:255'],
            'address'=>['string','min:3','max:255'],
            'city'=>['string','min:3','max:255'],
            'zipcode'=>['integer','min:5','max:5'],
            'number'=>['integer','min:9','max:9'],
            'address_id'=>['integer','exists:address.id']
        ];
    }
}
