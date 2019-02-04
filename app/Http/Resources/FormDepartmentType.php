<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FormDepartment as FormDepartmentResource;

class FormDepartmentType extends JsonResource
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
            'id'       => $this->id,
            'type'     => $this->type,
            'email'     => $this->email,
            'code'     => $this->code,
            ];
    }
}
