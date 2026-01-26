@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Tasks</h4>
        @can('create-task')
        <a href="{{ route('tasks.create') }}" class="btn btn-success">Create Task</a>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
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
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ ucfirst($task->priority) }}</td>
                    <td>{{ $task->due_datetime }}</td>
                    <td>
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm">View</a>
                        @can('update', $task)
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('delete', $task)
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
