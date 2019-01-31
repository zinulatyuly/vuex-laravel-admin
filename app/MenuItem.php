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
        'parent_id',
        'sort_order'
    ];

    public function children()
    {
        return $this->hasMany('App\MenuItem', 'parent_id')
            ->with('children');
    }
}
