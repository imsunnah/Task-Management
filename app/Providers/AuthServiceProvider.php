<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use App\Policies\EventPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class  => TaskPolicy::class,
        Event::class => EventPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('view-all-tasks', fn(User $user) => $user->isAdmin());
        Gate::define('create-tasks', fn(User $user) => $user->isAdmin());
        Gate::define('edit-tasks',   fn(User $user) => $user->isAdmin());  // optional – if you want global edit right
        Gate::define('delete-tasks', fn(User $user) => $user->isAdmin());
        Gate::define('view-all-events', fn(User $user) => $user->isAdmin());
        Gate::define('create-events',   fn(User $user) => $user->isAdmin());
        Gate::define('delete-events',   fn(User $user) => $user->isAdmin());
    }
}
