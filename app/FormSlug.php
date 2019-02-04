<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormSlug extends Model
{
    protected $fillable = [
        'form_id',
        'slug'
    ];

    public function slug()
    {
        return $this->belongsTo('App\Form', 'form_id');
    }
}
