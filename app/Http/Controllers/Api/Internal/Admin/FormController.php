<?php

namespace App\Http\Controllers\Api\Internal\Admin;

use App\Form;
use App\Http\Requests\Admin\FeedbackFormRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Form as FormResource;
use DB;

class FormController extends Controller
{

    public function index()
    {
        return FormResource::collection(Form::with(['formSlugs'])->get());
    }

    public function show($id)
    {
        $form = Form::with(['formSlugs'])->findOrFail($id);

        return new FormResource($form);
    }

    public function store(FeedbackFormRequest $request)
    {
        $form = new Form($request->all());

        DB::transaction(function () use ($form, $request) {
            $form->save();

            $form->syncFormSlugs($request->form_slugs);
        });

        return (new FormResource($form))
            ->response()
            ->setStatusCode(201);
    }

    public function update(FeedbackFormRequest $request, $id)
    {
        $form = Form::findOrFail($id);

        DB::transaction(function () use ($form, $request) {
            $form->update($request->all());

            $form->syncFormSlugs($request->form_slugs);
        });

        return (new FormResource($form))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();

        return response(null, 204);
    }
}