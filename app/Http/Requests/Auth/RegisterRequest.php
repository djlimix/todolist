<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    public function rules(): array {
        return [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string']
        ];
    }

    public function messages(): array {
        return [
            'email.unique' => 'Tento email už je u nás zaregistrovaný.'
        ];
    }
}
