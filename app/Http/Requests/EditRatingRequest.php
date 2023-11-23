<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRatingRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'rating_id' => ['required', 'exists:ratings,id'],
            'rating' => ['integer', 'min:0', 'max:10'],
            'heading' => ['string', 'max:255'],
            'description' => ['string', 'min:1', 'max:3000']
        ];
    }
}
