@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            {{-- Header Section --}}
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-3">
                    <i class="bi bi-calendar-event fs-3"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0">Schedule New Event</h2>
                    <p class="text-muted mb-0">Plan your team activities and link them to ongoing tasks.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            {{-- Event Name --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Meeting Name" required>
                                    <label for="name">Event Title</label>
                                </div>
                            </div>

                            {{-- Date & Time Row --}}
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="date" name="date" required>
                                    <label for="date">Date</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                                    <label for="start_time">Start Time</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="time" class="form-control" id="end_time" name="end_time" required>
                                    <label for="end_time">End Time</label>
                                </div>
                            </div>

                            {{-- Assignments Section --}}
                            <div class="col-12 mt-4">
                                <h6 class="text-muted text-uppercase fw-bold small mb-3">Associations</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Related Task (Optional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-list-task"></i></span>
                                            <select class="form-select border-start-0" id="task_id" name="task_id">
                                                <option value="">None</option>
                                                @foreach ($tasks as $task)
                                                <option value="{{ $task->id }}">{{ $task->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Assign To Member</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                            <select class="form-select border-start-0" id="assigned_to" name="assigned_to" required>
                                                @foreach (\App\Models\User::where('role', 'employee')->get() as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Section --}}
                            <div class="col-12 mt-5 text-end">
                                <hr class="opacity-25 mb-4">
                                <a href="{{ route('events.index') }}" class="btn btn-light px-4 me-2 rounded-3">Cancel</a>
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 fw-bold shadow-sm">
                                    <i class="bi bi-plus-lg me-1"></i> Create Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control,
    .form-select {
        border: 1px solid #e2e8f0;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.05);
    }

    .input-group-text {
        color: #64748b;
    }

</style>
@endsection
