<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest {
    public function rules(): array {
        return [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string']
        ];
    }
}
