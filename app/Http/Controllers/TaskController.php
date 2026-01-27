<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $query = Task::with('assignedTo');
        if (!auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }
        $tasks = $query->latest()->get();
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
        try {
            DB::transaction(function () use ($request) {
                Task::create($request->validated());
            });
            return redirect()->route('tasks.index')
                ->with('success', 'Task created successfully.');
        } catch (\Throwable $e) {
            Log::error('Task creation failed', [
                'user_id' => auth()->id(),
                'payload' => $request->validated(),
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors('Could not save task. Please try again.');
        }
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
        try {
            DB::transaction(function () use ($request, $task) {
                $task->update($request->validated());
            });

            return redirect()->route('tasks.index')
                ->with('success', 'Task updated successfully.');
        } catch (\Throwable $e) {

            Log::error('Task update failed', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors('Could not update task. Please try again.');
        }
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        try {
            $task->delete();

            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted successfully.');
        } catch (\Throwable $e) {

            Log::error('Task deletion failed', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors('Could not delete task.');
        }
    }
}
