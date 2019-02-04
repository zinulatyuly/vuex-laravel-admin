<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormDepartment extends Model
{
    protected $fillable = [
        'department'
    ];

    public function formDepartmentTypes()
    {
        return $this->hasMany('App\FormDepartmentType', 'department_id');
    }

    public function syncFormDepartmentTypes(array $departmentTypes)
    {
        $oldDepartmentTypes = $this->formDepartmentTypes->toArray();

        $deleteDepartmentTypes = array_diff(array_pluck($oldDepartmentTypes, 'id'), array_pluck($departmentTypes, 'id'));

        foreach ($deleteDepartmentTypes as $departmentType) {
            $this->formDepartmentTypes()->where('id', $departmentType)->delete();
        }

        foreach ($departmentTypes as $departmentType) {
            $oldDepartmentType = $this->formDepartmentTypes()->find($departmentType['id']);

            if (is_null($oldDepartmentType)) {
                $this->formDepartmentTypes()->create($departmentType);
            } else {
                $oldDepartmentType->update($departmentType);
            }
        }
    }
}
