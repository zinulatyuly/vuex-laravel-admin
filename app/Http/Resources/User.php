<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\Partner as PartnerResource;
use App\Http\Resources\Api as ApiResource;

class User extends Resource
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
            'id'      => $this->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'role'    => new RoleResource($this->whenLoaded('role'))
        ];
    }
}
