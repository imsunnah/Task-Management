<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view ANY events (list/index).
     *
     * → We allow all authenticated users to reach the index page.
     *   Actual filtering (all vs own) is done in the controller.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view a specific event.
     */
    public function view(User $user, Event $event): bool
    {
        // Admin has full access
        if ($user->isAdmin()) {
            return true;
        }

        // Employee can only see events assigned to them
        return $event->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can create new events.
     *
     * → Only admins should create events (consistent with task creation logic)
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update an event.
     */
    public function update(User $user, Event $event): bool
    {
        // Admin can update any event
        if ($user->isAdmin()) {
            return true;
        }

        // Employee can only update events assigned to them
        return $event->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can delete an event.
     *
     * → Only admins should be able to delete events
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->isAdmin();
    }

    /**
     * Optional: restore soft-deleted event (if you use soft deletes later)
     */
    public function restore(User $user, Event $event): bool
    {
        return $user->isAdmin();
    }

    /**
     * Optional: force delete from trash
     */
    public function forceDelete(User $user, Event $event): bool
    {
        return $user->isAdmin();
    }
}
