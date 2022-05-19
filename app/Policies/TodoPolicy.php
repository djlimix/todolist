<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy {
    use HandlesAuthorization;

    public function view(User $user, Todo $todo): bool {
        return $user->id === $todo->user_id || $user->todosSharedWithMe()->where('todos.id', $todo->id)->exists();
    }

    public function update(User $user, Todo $todo): bool {
        return $user->id === $todo->user_id;
    }

    public function delete(User $user, Todo $todo): bool {
        return $user->id === $todo->user_id;
    }

    public function restore(User $user, Todo $todo): bool {
        return $user->id === $todo->user_id;
    }
}
