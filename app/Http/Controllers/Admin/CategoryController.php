<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use DB;


class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $date = Category::latest()->get();
        return CategoryResource::collection($date)
                               ->additional([
                                   'count' => $date->count()
                               ]);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $request->validated();

        $data = Category::create([
            'name' => $request->string('name')
        ]);

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $data
        ]);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $request->validated();

        $category->forceFill([
            'name' => $request->string('name')
        ])->save();

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => Category::find($category)
        ]);
    }

    public function destroy(Category $category)
    {
        DB::transaction(function () use ($category) {
            $category->tickets()->detach();
            $category->delete();
        });

        return response()->json([
            'message' => __('messages.delete_success'),
        ]);
    }


}
