<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => ['required', 'string']
        ];
    }

    public function authorize(): bool {
        return auth()->user()->can('update', $this->category);
    }
}
