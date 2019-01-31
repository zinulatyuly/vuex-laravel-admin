<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'sort_order',
        'name',
        'status'
    ];


    public function items()
    {
        return $this->hasMany('App\MenuItem');
    }

    public function parent_items()
    {
        return $this->hasMany('App\MenuItem')
            ->whereNull('parent_id');
    }

    public function syncItems(array $items)
    {
        foreach ($items as $item) {
            if (!$item['parentId']) {
                $id = $this->items()->create($item)->id;
                $this->recourseMatch($items, $id, $item['id']);
            }
        }
    }

    private function recourseMatch(array $array, $id, $searchId) {
        $i = 1;
        foreach ($array as $child) {
            if ($child['parentId'] === $searchId)
            {
                $child['sort_order'] = $i;
                $i++;
                $child['parent_id'] = $id;
                $new_id = $this->items()->create($child)->id;
                $this->recourseMatch($array, $new_id, $child['id']);
            }
            else continue;
        }
    }
}
