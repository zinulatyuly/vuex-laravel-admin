<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Setting extends Resource
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
            'key' => $this->key,
            'displayName' => $this->display_name,
            'value' => $this->value,
            'details' => $this->details,
            'type' => $this->type,
            'sortOrder' => $this->sort_order,
            'group' => $this->group
        ];
    }
}
