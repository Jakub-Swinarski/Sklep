<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'price' => ['required', 'decimal:0,2'],
            'supply' => ['required', 'integer'],
            'description' => ['required', 'string'],

        ];
    }
}
