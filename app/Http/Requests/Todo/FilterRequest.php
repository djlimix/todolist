<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest {
    public function rules(): array {
        return [
            'filter'      => ['sometimes', 'in:mine,shared_with_me'],
            'done'        => ['sometimes', 'in:0,1'],
            'category_id' => ['sometimes', 'exists:category,id']
        ];
    }
}
