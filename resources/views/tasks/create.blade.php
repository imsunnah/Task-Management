@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-3">
                    <i class="bi bi-clipboard-plus fs-3"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0">Create New Task</h2>
                    <p class="text-muted mb-0">
                        Assign responsibilities and set deadlines clearly.
                    </p>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-7">
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase tracking-wider">
                                        Task Title
                                    </label>
                                    <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" placeholder="What needs to be done?" value="{{ old('title') }}" required>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase tracking-wider">
                                        Description
                                    </label>
                                    <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" placeholder="Provide additional details...">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5 border-start ps-md-4">
                                <div class="p-3 rounded-4 bg-light border">
                                    <h6 class="fw-bold mb-4">
                                        <i class="bi bi-sliders2-vertical me-2"></i>
                                        Task Settings
                                    </h6>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">
                                            Assign To
                                        </label>
                                        <select name="assigned_to" class="form-select form-select-sm @error('assigned_to') is-invalid @enderror" required>
                                            <option value="">Select employee</option>
                                            @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" @selected(old('assigned_to')==$employee->id)
                                                >
                                                {{ $employee->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('assigned_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">
                                                Status
                                            </label>
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="pending" @selected(old('status','pending')==='pending' )>Pending</option>
                                                <option value="in_progress" @selected(old('status')==='in_progress' )>In Progress</option>
                                                <option value="completed" @selected(old('status')==='completed' )>Completed</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">
                                                Priority
                                            </label>
                                            <select name="priority" class="form-select form-select-sm text-capitalize">
                                                <option value="low" @selected(old('priority')==='low' )>Low</option>
                                                <option value="medium" @selected(old('priority','medium')==='medium' )>Medium</option>
                                                <option value="high" @selected(old('priority')==='high' )>High</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold">
                                            Due Date & Time
                                        </label>
                                        <input type="datetime-local" name="due_datetime" class="form-control form-control-sm @error('due_datetime') is-invalid @enderror" value="{{ old('due_datetime') }}">
                                        @error('due_datetime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                                <a href="{{ route('tasks.index') }}" class="btn btn-light px-4">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-5 fw-bold">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    Create Task
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
