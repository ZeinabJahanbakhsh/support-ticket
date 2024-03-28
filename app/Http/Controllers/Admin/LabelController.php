<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabelRequest;
use App\Http\Resources\LabelResource;
use App\Models\Label;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class LabelController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $allData = Label::latest()->get();
        return LabelResource::collection($allData)
                            ->additional([
                                'count' => $allData->count()
                            ]);
    }


    public function store(LabelRequest $request): JsonResponse
    {
        $request->validated();

        $data = Label::create([
            'name' => $request->string('name')
        ]);

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $data
        ]);
    }


    public function show(Label $label): LabelResource
    {
        return new LabelResource($label);
    }


    //TODO: will be check again
    public function update(LabelRequest $request, Label $label): JsonResponse
    {
        $request->validated();

        $label->forceFill([
            'name' => $request->string('name')
        ])->save();

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => Label::findOrFail($label),
        ]);
    }


    public function destroy(Label $label): JsonResponse
    {
        DB::transaction(function () use($label){
            $label->tickets()->detach();
            $label->delete();
        });

        return response()->json([
            'message' => __('messages.delete_success'),
        ]);
    }


}
