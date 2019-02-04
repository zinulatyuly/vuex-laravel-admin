<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\FormSlug as FormSlugResource;
use App\Http\Resources\FormDepartment as DepartmentResource;

class Form extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'typeId' => $this->type_id,
            'departmentId' => $this->department_id,
            'department' => $this->department,
            'departmentType' => $this->departmentType,
            'slugs' => FormSlugResource::collection($this->whenLoaded('slugs')),
        ];
    }
}
