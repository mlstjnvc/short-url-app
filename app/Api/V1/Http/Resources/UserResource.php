<?php

namespace App\Api\V1\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'updated_at' => $this->updated_at,
            'token' => $this->when(!empty($this->token), function () {
                return [
                    'jwt' => $this->token->last()->jwt,
                    'created_at' => $this->token->last()->created_at,
                ];
            })
        ];
    }
}
