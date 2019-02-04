<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FormSlug;

class Form extends Model
{
    protected $table = 'forms';

    protected $fillable = [
        'name',
        'type',
        'department'
    ];

    public function formSlugs()
    {
        return $this->hasMany('App\FormSlug', 'form_id');
    }

    public function syncFormSlugs(array $formSlugs)
    {
        $oldFormSlugs = $this->formSlugs->toArray();

        $deletedFormSlugs = array_diff(array_pluck($oldFormSlugs, 'id'), array_pluck($formSlugs, 'id'));

        foreach ($deletedFormSlugs as $formSlug) {
            $this->formSlugs()->where('id', $formSlug)->delete();
        }

        foreach ($formSlugs as $formSlug) {
            $oldFormSlug = $this->formSlugs()->find($formSlug['id']);

            if (is_null($oldFormSlug)) {
                $this->formSlugs()->create($formSlug);
            } else {
                $oldFormSlug->update($formSlug);
            }
        }
    }
}
