<?php

namespace App\Http\Controllers\Api\Internal\Admin;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::with(['role'])->get());
    }

    public function show($id)
    {
        $user = User::with(['role'])->findOrFail($id);

        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        
        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        
        return (new UserResource($user))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response(null, 204);
    }
}