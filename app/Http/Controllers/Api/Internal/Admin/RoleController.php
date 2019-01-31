<?php

namespace App\Http\Controllers\Api\Internal\Admin;

use App\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\Role as RoleResource;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::with([])->get());
    }

    public function show($id)
    {
        $role = Role::with([])->findOrFail($id);

        return new RoleResource($role);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        
        return (new RoleResource($role))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        
        return (new RoleResource($role))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response(null, 204);
    }
}
