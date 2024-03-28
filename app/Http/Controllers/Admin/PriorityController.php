<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PriorityRequest;
use App\Http\Resources\PriorityResource;
use App\Models\Priority;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use DB;


class PriorityController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $data = Priority::latest()->get();
        return PriorityResource::collection($data)
                               ->additional([
                                   'count' => $data->count()
                               ]);
    }


    public function store(PriorityRequest $request): JsonResponse
    {
        $request->validated();

        $data = Priority::create([
            'name' => $request->string('name')
        ]);

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $data
        ]);
    }


    public function show(Priority $priority): PriorityResource
    {
        return new PriorityResource($priority);
    }


    public function update(PriorityRequest $request, Priority $priority): JsonResponse
    {
        $request->validated();

        $priority->forceFill([
           'name' => $request->string('name')
        ])->save();

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => $priority,
        ]);

    }


    public function destroy(Priority $priority): JsonResponse
    {
        DB::transaction(function () use($priority){
            $priority->tickets()->update([
                'priority_id' =>  null
            ]);

            $priority->delete();
        });

        return response()->json([
            'message' => __('messages.delete_success'),
        ]);
    }


}
