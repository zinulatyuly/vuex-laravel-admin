<?php

namespace App\Http\Controllers\Api\Internal\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SettingRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setting as SettingResource;
use DB;

class SettingController extends Controller
{
    public function index()
    {
        return SettingResource::collection(Setting::all());
    }

    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return new SettingResource($setting);
    }

    public function store(SettingRequest $request)
    {

        $setting = new Setting($request->all());

        DB::transaction(function () use ($setting) {
            $setting->save();
        });

        return (new SettingResource($setting))
            ->response()
            ->setStatusCode(201);
    }

    public function update(SettingRequest $request, $id)
    {

        $setting = Setting::findOrFail($id);

        DB::transaction(function () use ($setting, $request) {
            $setting->update($request->all());
        });

        return (new SettingResource($setting))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();

        return response(null, 204);
    }
}
