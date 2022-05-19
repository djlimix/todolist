<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\CreateTodoRequest;
use App\Http\Requests\Todo\FilterRequest;
use App\Http\Requests\Todo\MarkAsTodoRequest;
use App\Http\Requests\Todo\ShareTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;

class TodosController extends Controller {
    public function __construct() {
        $this->middleware('can:update,post')->only('markAs', 'share');
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(FilterRequest $request) {
        $todos = match ($request->filter) {
            'mine', null => auth()->user()->todos()->with('category'),
            'shared_with_me' => auth()->user()->todosSharedWithMe()->with('category', 'user'),
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
    public function store(CreateTodoRequest $request): TodoResource {
        $todo = auth()->user()->todos()->create($request->validated());

        return new TodoResource($todo);
    }

    /**
     * @param Todo $todo
     *
     * @return TodoResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Todo $todo): TodoResource {
        $this->authorize('view', $todo);

        $todo->load('category');

        return new TodoResource($todo);
    }

    /**
     * @param UpdateTodoRequest $request
     * @param Todo $todo
     *
     * @return TodoResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTodoRequest $request, Todo $todo): TodoResource {
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
     * @param MarkAsTodoRequest $request
     *
     * @return JsonResponse
     */
    public function markAs(Todo $todo, MarkAsTodoRequest $request): JsonResponse {
        $mark_as = match ($request->validated('mark_as')) {
            'not_done' => 0,
            'done' => 1
        };

        $todo->update([
            'done' => $mark_as
        ]);

        return response()->json([
            'error' => false,
            'msg'   => 'Successfully marked as '.str_replace('_', ' ', $request->validated('mark_as')),
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

        if ($todo->sharedWithUsers()->whereUserId($share_with_id)->doesntExist()) {
            $todo->sharedWithUsers()->attach($share_with_id);
        }

        return response()->json([
            'error' => false,
            'msg'   => 'Shared successfully'
        ]);
    }

    /**
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(int $id): JsonResponse {
        $todo = Todo::withTrashed()->findOrFail($id);

        $this->authorize('restore', $todo);

        $todo->restore();

        return response()->json([
            'error' => false,
            'msg'   => 'Successfully restored',
            'todo'  => new TodoResource($todo)
        ]);
    }
}
