<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => ['required', 'string', Rule::unique('categories')->ignore($this->category)]
        ];
    }

    public function messages(): array {
        return [
            'name.unique' => 'Táto kategória už existuje.'
        ];
    }
}
