<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest {
    public function rules(): array {
        return [
            'text' => ['required', 'string']
        ];
    }

    public function authorize(): bool {
        return auth()->user()->can('update', $this->todo);
    }
}
