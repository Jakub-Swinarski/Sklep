<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewEmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required','email','unique:users,email','max:255'],
            'password' => ['required','string','min:8','max:255'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
