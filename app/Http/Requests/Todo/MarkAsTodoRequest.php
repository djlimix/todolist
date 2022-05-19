<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class MarkAsTodoRequest extends FormRequest {
    public function rules(): array {
        return [
            'mark_as' => ['required', 'in:not_done,done']
        ];
    }

    public function authorize(): bool {
        return auth()->user()->can('update', $this->todo);
    }

    public function messages(): array {
        return [
            'mark_as.in' => 'Nesprávny typ označenia.'
        ];
    }
}
