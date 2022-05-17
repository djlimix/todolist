<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\CreateTodoRequest;
use App\Http\Requests\Todo\FilterRequest;
use App\Http\Requests\Todo\ShareTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;

class TodosController extends Controller {
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(FilterRequest $request) {
        $todos = match ($request->filter) {
            'mine', null => auth()->user()->todos()->with('category'),
            'shared_with_me' => auth()->user()->todos_shared_with_me()->with('category', 'user'),
        };

        if ($request->has('done')) {
            $todos->whereDone($request->done);
        }

        if ($request->has('category_id')) {
            $todos->whereCategoryId($request->category_id);
        }

        return TodoResource::collection($todos->get());
    }

    /**
     * @param CreateTodoRequest $request
     *
     * @return TodoResource
     */
    public function store(CreateTodoRequest $request) {
        if (auth()->user()->categories()->whereId($request->category_id)->doesntExist()) {
            return abort(404);
        }

        $todo = auth()->user()->todos()->create($request->validated());

        return new TodoResource($todo);
    }

    /**
     * @param Todo $todo
     *
     * @return TodoResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Todo $todo) {
        $this->authorize('view', $todo);

        return new TodoResource($todo);
    }

    /**
     * @param UpdateTodoRequest $request
     * @param Todo $todo
     *
     * @return TodoResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTodoRequest $request, Todo $todo) {
        $this->authorize('update', $todo);

        $todo->update($request->validated());

        return new TodoResource($todo);
    }

    /**
     * @param Todo $todo
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Todo $todo): JsonResponse {
        $this->authorize('delete', $todo);

        $todo->delete();

        return response()->json([
            'error' => false,
            'msg'   => 'Successfully deleted'
        ]);
    }

    /**
     * @param Todo $todo
     *
     * @return JsonResponse
     */
    public function markAsDone(Todo $todo): JsonResponse {
        $todo->update([
            'done' => '1'
        ]);

        return response()->json([
            'error' => false,
            'msg'   => 'Successfully marked as done',
            'todo'  => new TodoResource($todo)
        ]);
    }

    /**
     * @param Todo $todo
     * @param ShareTodoRequest $request
     *
     * @return JsonResponse
     */
    public function share(Todo $todo, ShareTodoRequest $request): JsonResponse {
        $share_with_id = $request->validated('share_with_id');

        if ($todo->shares()->whereUserId($share_with_id)->doesntExist()) {
            $todo->shares()->attach($share_with_id);
        }

        return response()->json([
            'error' => false,
            'msg'   => 'Shared successfully'
        ]);
    }
}
