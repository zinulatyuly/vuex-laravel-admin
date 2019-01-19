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

    /**
     * Display menu.
     *
     * @param string      $menuName
     * @param string|null $type
     * @param array       $options
     *
     * @return string
     */
    public static function display($menuName, $type = null, array $options = [])
    {
        // GET THE MENU - sort collection in blade
        $menu = static::where('name', '=', $menuName)
            ->with(['parent_items.children' => function ($q) {
                $q->orderBy('order');
            }])
            ->first();
        // Check for Menu Existence
        if (!isset($menu)) {
            return false;
        }

        // Convert options array into object
        $options = (object) $options;

        $type = 'menu.default';
 
        if (!isset($options->locale)) {
            $options->locale = app()->getLocale();
        }
        $items = $menu->parent_items->sortBy('order');
        if ($type === '_json') {
            return $items;
        }
        return new \Illuminate\Support\HtmlString(
            \Illuminate\Support\Facades\View::make($type, ['items' => $items, 'options' => $options])->render()
        );
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
        foreach ($array as $child) {
            if ($child['parentId'] === $searchId)
            {
                $child['parent_id'] = $id;
                $new_id = $this->items()->create($child)->id;
                $this->recourseMatch($array, $new_id, $child['id']);
            }
            else continue;
        }
    }

    public function scopeCrisp($query)
    {
        return $query->where('status', true)->oldest('sort_order');
    }
}
