<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\FormSlug as FormSlugResource;
use App\Http\Resources\FormDepartment as DepartmentResource;
use App\Http\Resources\FormDepartmentType as TypeResource;

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
            'slugs' => FormSlugResource::collection($this->whenLoaded('slugs')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'type' => new TypeResource($this->whenLoaded('type')),
        ];
    }
}
