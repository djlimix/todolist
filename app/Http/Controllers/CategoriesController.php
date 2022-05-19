<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TodoResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller {
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index() {
        $categories = Category::select('id', 'name')->get();

        return CategoryResource::collection($categories);
    }

    /**
     * @param CreateCategoryRequest $request
     *
     * @return CategoryResource
     */
    public function store(CreateCategoryRequest $request): CategoryResource {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    /**
     * @param Category $category
     *
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource {
        $category->load('todos');

        return new CategoryResource($category);
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param Category $category
     *
     * @return CategoryResource
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    /**
     * @param Category $category
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Category $category): JsonResponse {
        $category->delete();

        return response()->json([
            'error' => false,
            'msg'   => 'Successfully deleted'
        ]);
    }

    /**
     * @param Category $category
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(Category $category): JsonResponse {
        $category->restore();

        return response()->json([
            'error'    => false,
            'msg'      => 'Successfully restored',
            'category' => new CategoryResource($category)
        ]);
    }
}
