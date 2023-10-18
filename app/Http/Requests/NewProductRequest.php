<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'price' => ['required', 'double'],
            'supply' => ['required', 'integer'],
            'description' => ['required', 'string'],

            'images' => ['array'],
            'images.*.image' => ['request'],

            'categories' => ['array'],
            'categories.*.name' => ['string', 'max:255'],
            'newCategories' => ['array'],
            'newCategories.*.name' => ['string', 'max:255']
        ];
    }
}
