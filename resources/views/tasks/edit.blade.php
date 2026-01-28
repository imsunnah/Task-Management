@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Breadcrumb / Header --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Tasks</a></li>
                    <li class="breadcrumb-item active">Edit Task</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center mb-4">
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4 me-3">
                    <i class="bi bi-pencil-square fs-3"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-dark">Modify Task</h2>
                    <p class="text-muted mb-0">Update progress or reassign details for Task <strong>#{{ $task->id }}</strong></p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            {{-- Main Content (Left) --}}
                            <div class="col-md-7">
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Title</label>
                                    <input type="text" class="form-control form-control-lg rounded-3 shadow-none border-light-subtle" id="title" name="title" value="{{ old('title', $task->title) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Detailed Description</label>
                                    <textarea class="form-control rounded-3 shadow-none border-light-subtle" id="description" name="description" rows="8">{{ old('description', $task->description) }}</textarea>
                                </div>
                            </div>

                            {{-- Sidebar Settings (Right) --}}
                            <div class="col-md-5">
                                <div class="p-4 rounded-4 bg-light border border-light-subtle">
                                    <h6 class="fw-bold mb-4"><i class="bi bi-gear-fill me-2 text-secondary"></i>Task Parameters</h6>

                                    {{-- Assignee --}}
                                    <div class="mb-4">
                                        <label for="assigned_to" class="form-label small fw-semibold">Assigned Member</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-person-badge"></i></span>
                                            <select class="form-select border-start-0 shadow-none" id="assigned_to" name="assigned_to" required>
                                                @foreach ($employees as $user)
                                                <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="mb-4">
                                        <label for="status" class="form-label small fw-semibold">Current Status</label>
                                        <select class="form-select rounded-3 shadow-none border-{{ $task->status == 'completed' ? 'success' : 'primary' }}" id="status" name="status" required>
                                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>⚡ In Progress</option>
                                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                        </select>
                                    </div>

                                    {{-- Priority --}}
                                    <div class="mb-4">
                                        <label for="priority" class="form-label small fw-semibold">Priority Level</label>
                                        <div class="d-flex gap-2">
                                            @foreach(['low' => 'success', 'medium' => 'warning', 'high' => 'danger'] as $p => $color)
                                            <input type="radio" class="btn-check" name="priority" id="btn-{{ $p }}" value="{{ $p }}" {{ $task->priority == $p ? 'selected' : '' }} {{ $task->priority == $p ? 'checked' : '' }}>
                                            <label class="btn btn-outline-{{ $color }} flex-fill btn-sm rounded-3" for="btn-{{ $p }}">{{ ucfirst($p) }}</label>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Due Date --}}
                                    <div class="mb-2">
                                        <label for="due_datetime" class="form-label small fw-semibold">Deadline</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-alarm"></i></span>
                                            <input type="datetime-local" class="form-control border-start-0 shadow-none" id="due_datetime" name="due_datetime" value="{{ old('due_datetime', $task->due_datetime ? $task->due_datetime->format('Y-m-d\TH:i') : '') }}" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- Meta Info --}}
                                <div class="mt-4 px-2">
                                    <div class="d-flex justify-content-between text-muted small mb-1">
                                        <span>Created:</span>
                                        <span>{{ $task->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted small">
                                        <span>Last Update:</span>
                                        <span>{{ $task->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer Actions --}}
                            <div class="col-12 mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-end align-items-center">

                                    <div>
                                        <a href="{{ route('tasks.index') }}" class="btn btn-light px-4 rounded-3 me-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary px-5 rounded-3 fw-bold shadow-sm">
                                            Save Changes
                                        </button>
                                    </div>
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
    .tracking-wider {
        letter-spacing: 0.08rem;
    }

    .btn-check:checked+.btn-outline-success {
        background-color: #198754;
        color: #fff;
    }

    .btn-check:checked+.btn-outline-warning {
        background-color: #ffc107;
        color: #000;
    }

    .btn-check:checked+.btn-outline-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .form-control:focus {
        border-color: #0d6efd;
    }

</style>
@endsection
