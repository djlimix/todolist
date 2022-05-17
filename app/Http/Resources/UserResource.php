<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource {
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array {
        return [
            'name'  => $this->name,
            'email' => $this->email,
        ];
    }
}
