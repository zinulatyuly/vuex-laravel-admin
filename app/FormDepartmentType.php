<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormDepartmentType extends Model
{
    protected $fillable = [
        'department_id',
        'type'
    ];
}
