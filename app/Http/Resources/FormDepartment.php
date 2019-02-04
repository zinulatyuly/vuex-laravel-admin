<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\FormDepartmentType as FormDepartmentTypeResource;

class FormDepartment extends Resource
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
            'id'        => $this->id,
            'department'      => $this->department,
            'departmentTypes' => FormDepartmentTypeResource::collection($this->whenLoaded('formDepartmentTypes'))
        ];
    }
}
