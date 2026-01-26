<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Task;
use App\Policies\EventPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class => TaskPolicy::class,
        Event::class => EventPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Gates for simple permissions
        Gate::define('view-all-tasks', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('create-task', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('view-all-events', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('create-event', function ($user) {
            return $user->isAdmin();
        });

        // Dashboard access example
        Gate::define('access-dashboard', function ($user) {
            return true; // Both roles can access, but content differs
        });
    }
}
