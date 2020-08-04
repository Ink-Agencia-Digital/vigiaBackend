<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => isset($this->id) ? $this->id : null,
            "name" => isset($this->name) ? $this->name : null,
            "lastname" => isset($this->lastname) ? $this->lastname : null,
            "phone" => isset($this->phone) ? $this->phone : null,
            "identification" => isset($this->identification) ? $this->identification : null,
            "email" => isset($this->email) ? $this->email : null,
            "ice" => isset($this->ice) ? $this->ice : null,
            "photo" => isset($this->photo) ? $this->photo : null,
            "roles" => RoleResource::collection($this->whenLoaded('roles')),
            "apartments" => ApartmentResource::collection($this->whenLoaded('apartments'))
        ];
    }
}
