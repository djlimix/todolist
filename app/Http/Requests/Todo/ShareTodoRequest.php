<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class ShareTodoRequest extends FormRequest {
    public function rules(): array {
        return [
            'share_with_id' => ['required', 'numeric', 'exists:users,id']
        ];
    }

    public function authorize(): bool {
        return auth()->user()->can('update', $this->todo);
    }
}
