<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItem extends JsonResource
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
            'title' => $this->title,
            'url' => $this->url,
            'hasChildren' => $this->has_children,
            'parentId' => $this->parent_id,
            'order' => $this->order
        ];
    }
}
