<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FormSlug;

class Form extends Model
{
    protected $table = 'forms';

    protected $fillable = [
        'name',
        'type_id',
        'department_id'
    ];

    public function slugs()
    {
        return $this->hasMany('App\FormSlug', 'form_id');
    }

    public function type()
    {
        return $this->belongsTo('App\FormDepartmentType', 'type_id');
    }

    public function department()
    {
        return $this->belongsTo('App\FormDepartment', 'department_id');
    }

    public function syncFormSlugs(array $formSlugs)
    {
        $oldFormSlugs = $this->slugs->toArray();

        $deletedFormSlugs = array_diff(array_pluck($oldFormSlugs, 'id'), array_pluck($formSlugs, 'id'));

        foreach ($deletedFormSlugs as $formSlug) {
            $this->slugs()->where('id', $formSlug)->delete();
        }

        foreach ($formSlugs as $formSlug) {
            $oldFormSlug = $this->slugs()->find($formSlug['id']);

            if (is_null($oldFormSlug)) {
                $this->slugs()->create($formSlug);
            } else {
                $oldFormSlug->update($formSlug);
            }
        }
    }
}
