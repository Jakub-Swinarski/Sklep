<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRatingRequest extends FormRequest
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
            'rating' => ['integer', 'min:0', 'max:10'],
            'heading' => ['string', 'max:255'],
            'description' => ['string', 'min:1', 'max:3000']
        ];
    }
}
