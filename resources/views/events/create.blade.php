@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Create Event</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>
            <div class="mb-3">
                <label for="task_id" class="form-label">Related Task (Optional)</label>
                <select class="form-select" id="task_id" name="task_id">
                    <option value="">None</option>
                    @foreach ($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="assigned_to" class="form-label">Assigned To</label>
                <select class="form-select" id="assigned_to" name="assigned_to" required>
                    @foreach (\App\Models\User::where('role', 'employee')->get() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
@endsection
