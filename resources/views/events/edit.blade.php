@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            {{-- Breadcrumb Navigation --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('events.index') }}" class="text-decoration-none">Events</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Event</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary py-3">
                    <h5 class="card-title text-white mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i> Modify Event Details
                    </h5>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('events.update', $event) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            {{-- Event Title --}}
                            <div class="col-12">
                                <label for="name" class="form-label fw-bold text-dark">Event Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0 py-2" id="name" name="name" value="{{ old('name', $event->name) }}" required>
                                </div>
                            </div>

                            {{-- Schedule Section --}}
                            <div class="col-12 mt-4">
                                <div class="p-3 rounded-3 bg-light border-start border-primary border-4">
                                    <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-clock-history me-2"></i>Schedule & Timing</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="date" class="form-label small fw-semibold">Event Date</label>
                                            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $event->date) }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="start_time" class="form-label small fw-semibold">Starts At</label>
                                            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time) }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="end_time" class="form-label small fw-semibold">Ends At</label>
                                            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Assignment Section --}}
                            <div class="col-md-6 mt-4">
                                <label for="task_id" class="form-label fw-bold text-dark">Link to Task</label>
                                <select class="form-select shadow-none" id="task_id" name="task_id">
                                    <option value="">No related task</option>
                                    @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}" {{ $event->task_id == $task->id ? 'selected' : '' }}>
                                        📋 {{ $task->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mt-4">
                                <label for="assigned_to" class="form-label fw-bold text-dark">Assigned Member</label>
                                <select class="form-select shadow-none" id="assigned_to" name="assigned_to" required>
                                    @foreach (\App\Models\User::where('role', 'employee')->get() as $user)
                                    <option value="{{ $user->id }}" {{ $event->assigned_to == $user->id ? 'selected' : '' }}>
                                        👤 {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Form Footer --}}
                            <div class="col-12 mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
                                <small class="text-muted">Created: {{ $event->created_at->format('M d, Y') }}</small>
                                <div>
                                    <a href="{{ route('events.index') }}" class="btn btn-light px-4 rounded-3 me-2">Discard</a>
                                    <button type="submit" class="btn btn-primary px-5 rounded-3 fw-bold shadow-sm">
                                        Update Schedule
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }

    .input-group-text {
        border-radius: 0.5rem 0 0 0.5rem;
    }

    .form-control {
        border-radius: 0.5rem;
    }

</style>
@endsection
