<!-- resources/views/tasks/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Task Details</h1>
    <p><strong>Title:</strong> {{ $task->title }}</p>
    <p><strong>Description:</strong> {{ $task->description }}</p>
    <p><strong>Assigned To:</strong> {{ $task->assignedTo->name }}</p>
    <p><strong>Status:</strong> {{ $task->status }}</p>
    <p><strong>Priority:</strong> {{ $task->priority }}</p>
    <p><strong>Due:</strong> {{ $task->due_datetime ? $task->due_datetime->format('Y-m-d H:i') : 'N/A' }}</p>
</div>
@endsection
