@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Header --}}
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-3">
                    <i class="bi bi-clipboard-plus fs-3"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-dark">Create New Task</h2>
                    <p class="text-muted mb-0">Assign responsibilities and set project deadlines.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            {{-- Main Task Content (Left Side) --}}
                            <div class="col-md-7">
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-bold small text-uppercase tracking-wider">Task Title</label>
                                    <input type="text" class="form-control form-control-lg rounded-3 shadow-none border-light-subtle bg-light bg-opacity-50" id="title" name="title" placeholder="What needs to be done?" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold small text-uppercase tracking-wider">Description</label>
                                    <textarea class="form-control rounded-3 shadow-none border-light-subtle bg-light bg-opacity-50" id="description" name="description" rows="6" placeholder="Provide some context..."></textarea>
                                </div>
                            </div>

                            {{-- Task Settings (Right Side) --}}
                            <div class="col-md-5 border-start ps-md-4">
                                <div class="p-3 rounded-4 bg-light border border-light-subtle">
                                    <h6 class="fw-bold mb-4 mt-1"><i class="bi bi-sliders2-vertical me-2"></i>Task Settings</h6>

                                    <div class="mb-3">
                                        <label for="assigned_to" class="form-label small fw-semibold">Assign To</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-person"></i></span>
                                            <select class="form-select border-start-0 shadow-none" id="assigned_to" name="assigned_to" required>
                                                <option selected disabled>Select Employee</option>
                                                @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label for="status" class="form-label small fw-semibold">Status</label>
                                            <select class="form-select form-select-sm rounded-3 shadow-none" id="status" name="status" required>
                                                <option value="pending">Pending</option>
                                                <option value="in_progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="priority" class="form-label small fw-semibold">Priority</label>
                                            <select class="form-select form-select-sm rounded-3 shadow-none text-capitalize" id="priority" name="priority" required>
                                                <option value="low" class="text-success">Low</option>
                                                <option value="medium" class="text-warning" selected>Medium</option>
                                                <option value="high" class="text-danger">High</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label for="due_datetime" class="form-label small fw-semibold">Due Date & Time</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                            <input type="datetime-local" class="form-control border-start-0 shadow-none" id="due_datetime" name="due_datetime">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Footer --}}
                            <div class="col-12 mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('tasks.index') }}" class="btn btn-light px-4 py-2 rounded-3 fw-semibold">Cancel</a>
                                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 fw-bold shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Create Task
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
    .tracking-wider {
        letter-spacing: 0.05rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1) !important;
    }

    .input-group-text {
        color: #6c757d;
        border-color: #dee2e6;
    }

</style>
@endsection
