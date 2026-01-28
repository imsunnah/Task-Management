@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            {{-- Header --}}
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-3">
                    <i class="bi bi-calendar-event fs-3"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0">Schedule New Event</h2>
                    <p class="text-muted mb-0">
                        Plan team activities and optionally link them to tasks.
                    </p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">

                            {{-- Event Title --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Event title" value="{{ old('name') }}" required>
                                    <label for="name">
                                        Event Title <span class="text-danger">*</span>
                                    </label>

                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Date & Time --}}
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required>
                                    <label for="date">Date</label>
                                    @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                    <label for="start_time">Start Time</label>
                                    @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                    <label for="end_time">End Time</label>
                                    @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Associations --}}
                            <div class="col-12 mt-4">
                                <h6 class="text-muted text-uppercase fw-bold small mb-3">
                                    Associations
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">
                                            Related Task (Optional)
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-list-task"></i>
                                            </span>
                                            <select class="form-select @error('task_id') is-invalid @enderror" name="task_id">
                                                <option value="">None</option>
                                                @foreach ($tasks as $task)
                                                <option value="{{ $task->id }}" @selected(old('task_id')==$task->id)
                                                    >
                                                    {{ $task->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('task_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">
                                            Assign To Member
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-person"></i>
                                            </span>
                                            <select class="form-select @error('assigned_to') is-invalid @enderror" name="assigned_to" required>
                                                <option value="">Select employee</option>
                                                @foreach ($employees as $user)
                                                <option value="{{ $user->id }}" @selected(old('assigned_to')==$user->id)
                                                    >
                                                    {{ $user->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('assigned_to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="col-12 mt-5 text-end">
                                <hr class="opacity-25 mb-4">
                                <a href="{{ route('events.index') }}" class="btn btn-light px-4 me-2 rounded-3">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 fw-bold">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    Create Event
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
