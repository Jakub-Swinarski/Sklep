<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            "username" => ['required','string','min:3','max:64'],
            "password" => ['required','string','min:8',"max:64"]
        ];
    }
}
