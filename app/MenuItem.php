<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id',
        'title',
        'url',
        'has_children',
        'code',
        'parent_id',
        'order'
    ];

    public function children()
    {
        return $this->hasMany('App\MenuItem', 'parent_id')
            ->with('children');
    }

    public function link($absolute = false)
    {
        return $this->prepareLink($absolute, $this->route, $this->parameters, $this->url);
    }

    protected function prepareLink($absolute, $route, $parameters, $url)
    {
        if (is_null($parameters)) {
            $parameters = [];
        }
        if (is_string($parameters)) {
            $parameters = json_decode($parameters, true);
        } elseif (is_array($parameters)) {
            $parameters = $parameters;
        } elseif (is_object($parameters)) {
            $parameters = json_decode(json_encode($parameters), true);
        }
        if (!is_null($route)) {
            if (!Route::has($route)) {
                return '#';
            }
            return route($route, $parameters, $absolute);
        }
        if ($absolute) {
            return url($url);
        }
        return $url;
    }

    public function getParametersAttribute()
    {
        return json_decode($this->attributes['parameters']);
    }

    public function setParametersAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $this->attributes['parameters'] = $value;
    }
    public function setUrlAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }
        $this->attributes['url'] = $value;
    }

    /**
     * Return the Highest Order Menu Item.
     *
     * @param number $parent (Optional) Parent id. Default null
     *
     * @return number Order number
     */
    public function highestOrderMenuItem($parent = null)
    {
        $order = 1;
        $item = $this->where('parent_id', '=', $parent)
            ->orderBy('order', 'DESC')
            ->first();
        if (!is_null($item)) {
            $order = intval($item->order) + 1;
        }
        return $order;
    }
}
