<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'    => (integer)$this->id,
            'name'  => (string)$this->name,
            'email' => (string)$this->email,
           // 'role_id' => (string)$this->role_id,
            'role' => RoleResource::collection($this->whenLoaded('role')),
        ];
    }
}