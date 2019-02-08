<?php

namespace App\Http\Controllers\Api\Internal\Admin;

use App\FormDepartment;
use App\Http\Requests\Admin\FormDepartmentRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormDepartment as FormDepartmentResource;
use DB;

class FormDepartmentController extends Controller
{

    public function index()
    {
        return FormDepartmentResource::collection(FormDepartment::with(['formDepartmentTypes'])->get());
    }

    public function show($id)
    {
        $department = FormDepartment::with(['formDepartmentTypes'])->findOrFail($id);

        return new FormDepartmentResource($department);
    }

    public function store(FormDepartmentRequest $request)
    {
        $department = new FormDepartment($request->all());

        DB::transaction(function () use ($department, $request) {
            $department->save();

            $department->syncFormDepartmentTypes($request->department_types);
        });

        return (new FormDepartmentResource($department))
            ->response()
            ->setStatusCode(201);
    }

    public function update(FormDepartmentRequest $request, $id)
    {
        $department = FormDepartment::findOrFail($id);

        DB::transaction(function () use ($department, $request) {

            $department->update($request->all());

            $department->syncFormDepartmentTypes($request->department_types);
        });

        return (new FormDepartmentResource($department))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        $department = FormDepartment::findOrFail($id);
        $department->formDepartmentTypes()->delete();
        $department->delete();

        return response(null, 204);
    }
}