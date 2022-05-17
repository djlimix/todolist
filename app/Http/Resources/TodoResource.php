<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Todo */
class TodoResource extends JsonResource {
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array {
        return [
            'id'   => $this->id,
            'text' => $this->text,
            'done' => $this->done,

            'category' => new CategoryResource($this->whenLoaded('category')),
            'user'     => new UserResource($this->whenLoaded('user'))
        ];
    }
}
