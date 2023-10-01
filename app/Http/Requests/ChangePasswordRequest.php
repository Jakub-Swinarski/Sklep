<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required','integer','exists:users'],
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'max:64']
        ];
    }
}
