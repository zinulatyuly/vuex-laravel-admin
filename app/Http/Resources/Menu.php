<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MenuItem;


class Menu extends JsonResource
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
            'sortOrder' => $this->sort_order,
            'name' => $this->name,
            'status' => $this->status,
            'items' => MenuItem::collection($this->whenLoaded('items'))
        ];
    }
}
