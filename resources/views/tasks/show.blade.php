@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Task Details</h4>
    </div>
    <div class="card-body">
        <p><strong>Title:</strong> {{ $task->title }}</p>
        <p><strong>Description:</strong> {{ $task->description }}</p>
        <p><strong>Assigned To:</strong> {{ $task->assignedTo->name }}</p>
        <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
        <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
        <p><strong>Due:</strong> {{ $task->due_datetime }}</p>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
