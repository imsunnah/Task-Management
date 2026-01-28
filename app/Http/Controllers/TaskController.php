<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $tasks = Task::with('assignedTo')
            ->when(! auth()->user()->isAdmin(), function ($query) {
                $query->where('assigned_to', auth()->id());
            })
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $this->authorize('create', Task::class);

        $employees = User::where('role', 'employee')->get();

        return view('tasks.create', compact('employees'));
    }

    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);

        DB::transaction(function () use ($request) {
            Task::create($request->validated());
        });

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $employees = User::where('role', 'employee')->get();

        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        DB::transaction(function () use ($request, $task) {
            $task->update($request->validated());
        });

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        // Events are deleted automatically via DB cascade
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
