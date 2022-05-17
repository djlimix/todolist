<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class CreateTodoRequest extends FormRequest {
    public function rules(): array {
        return [
            'text'        => ['required', 'string'],
            'category_id' => ['required', 'numeric', 'exists:categories,id']
        ];
    }
}
