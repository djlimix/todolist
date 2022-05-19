<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => ['required', 'string', 'unique:categories']
        ];
    }

    public function messages(): array {
        return [
            'name.unique' => 'Táto kategória už existuje.'
        ];
    }
}
