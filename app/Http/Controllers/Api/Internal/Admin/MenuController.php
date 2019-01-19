<?php

namespace App\Http\Controllers\Api\Internal\Admin;

use App\Menu;
use App\Http\Requests\Admin\MenuRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Menu as MenuResource;
use DB;

class MenuController extends Controller
{

    public function index()
    {
        return MenuResource::collection(Menu::oldest('sort_order')->get());
    }

    public function show($id)
    {
        $menu = Menu::with('items')->findOrFail($id);

        return new MenuResource($menu);
    }

    public function store(MenuRequest $request)
    {
        $menu = new Menu($request->all());

        DB::transaction(function () use ($menu, $request) {
            $menu->save();
        });

        return (new MenuResource($menu))
            ->response()
            ->setStatusCode(201);
    }

    public function update(MenuRequest $request, $id)
    {
        $menu = Menu::with('items')->findOrFail($id);

        DB::transaction(function () use ($menu, $request, $id) {
            $menu->update($request->all());
            $menu->items()->delete();
            $menu->syncItems(collect($request->items)->toArray());
        });

        return (new MenuResource($menu))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response(null, 204);
    }
}