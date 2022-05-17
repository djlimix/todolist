<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Category */
class CategoryResource extends JsonResource {
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'todos_count' => $this->todos_count,

            'todos' => TodoResource::collection($this->whenLoaded('todos')),
        ];
    }
}
