<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'display_name',
        'value',
        'details',
        'type',
        'sort_order',
        'group'
    ];

    public $timestamps = false;

    public static function getByGroup($group)
    {
        return Setting::where('group', '=', $group)->get();
    }

    public static function getByKey($key)
    {
        return Setting::where('key', '=', $key)->get()->first();
    }
}