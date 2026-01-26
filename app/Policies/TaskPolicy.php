<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view ANY tasks (list/index).
     *
     * Best practice note:
     * We return true here so everyone can reach the index page.
     * The actual filtering (all vs own) happens in the controller.
     * This is common when combining policies + controller-level scoping.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can see the tasks list page
    }

    /**
     * Determine whether the user can view a specific task.
     */
    public function view(User $user, Task $task): bool
    {
        // Admin sees everything
        if ($user->isAdmin()) {
            return true;
        }

        // Employee can only see their own assigned task
        return $task->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can create new tasks.
     *
     * Only admins should be able to create/assign tasks.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update a task.
     */
    public function update(User $user, Task $task): bool
    {
        // Only admin can edit — full stop
        return $user->isAdmin();
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }

    /**
     * Optional: restore a soft-deleted task (if you use soft deletes)
     */
    public function restore(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }

    /**
     * Optional: permanently delete from trash
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }
}
