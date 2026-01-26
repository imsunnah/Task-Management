<!-- resources/views/tasks/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tasks</h1>

    @can('create', \App\Models\Task::class)
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>
    @endcan


    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->assignedTo->name ?? 'N/A' }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->priority }}</td>
                <td>{{ $task->due_datetime ? $task->due_datetime->format('Y-m-d H:i') : 'N/A' }}</td>
                <td>
                    <!-- In index table row -->
                    @can('view', $task)
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-info">View</a>
                    @endcan

                    @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endcan

                    @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete task?')">Delete</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
