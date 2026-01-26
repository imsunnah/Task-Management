@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Task</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ $task->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="assigned_to" class="form-label">Assigned To</label>
                <select class="form-select" id="assigned_to" name="assigned_to" required>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-select" id="priority" name="priority" required>
                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="due_datetime" class="form-label">Due Date & Time</label>
                <input type="datetime-local" class="form-control" id="due_datetime" name="due_datetime" value="{{ $task->due_datetime->format('Y-m-d\TH:i') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
