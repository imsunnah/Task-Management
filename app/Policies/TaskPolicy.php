<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Task $task): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $task->assigned_to === $user->id;
    }


    public function create(User $user): bool
    {
        return $user->isAdmin();
    }


    public function update(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }


    public function restore(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }


    public function forceDelete(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }
}
