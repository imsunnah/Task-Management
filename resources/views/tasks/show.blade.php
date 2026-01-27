@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('tasks.index') }}" class="btn btn-link text-decoration-none text-muted p-0">
                    <i class="bi bi-arrow-left me-1"></i> Back to Task List
                </a>
                <div class="d-flex gap-2">
                    @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning btn-sm rounded-3 px-3">
                        <i class="bi bi-pencil me-1"></i> Edit Task
                    </a>
                    @endcan
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                @php
                $priorityColors = ['low' => 'success', 'medium' => 'warning', 'high' => 'danger'];
                $theme = $priorityColors[$task->priority] ?? 'primary';
                @endphp
                <div class="bg-{{ $theme }} py-4 px-4 text-white position-relative">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge bg-white bg-opacity-25 text-white mb-2 text-uppercase fw-bold" style="letter-spacing: 1px;">
                                {{ $task->priority }} Priority
                            </span>
                            <h2 class="fw-bold mb-0">{{ $task->title }}</h2>
                        </div>
                        <div class="text-end">
                            <div class="small opacity-75">Due Date</div>
                            <div class="fw-bold fs-5">
                                {{ $task->due_datetime ? $task->due_datetime->format('M d, Y') : 'No Limit' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row g-5">
                        <div class="col-md-7">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3">Task Objective</h6>
                            <div class="bg-light p-4 rounded-4 text-dark shadow-sm min-vh-25">
                                {!! nl2br(e($task->description)) ?: '<span class="text-muted italic">No description provided for this task.</span>' !!}
                            </div>

                            <div class="mt-4">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Progress Tracking</h6>
                                <div class="progress rounded-pill" style="height: 10px;">
                                    @php
                                    $prog = ['pending' => 10, 'in_progress' => 50, 'completed' => 100];
                                    @endphp
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $task->status == 'completed' ? 'success' : 'primary' }}" role="progressbar" style="width: {{ $prog[$task->status] }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 small text-muted font-monospace">
                                    <span>Pending</span>
                                    <span>In Progress</span>
                                    <span>Completed</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="sticky-top" style="top: 20px;">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3 text-md-end">Assignment</h6>

                                <div class="card border border-light-subtle rounded-4 mb-4 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignedTo->name) }}&background=random&size=100" class="rounded-circle me-3 border" width="50" height="50">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $task->assignedTo->name }}</div>
                                                <div class="text-muted small">Assigned Personnel</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 rounded-4 border bg-white shadow-sm mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small">Current Status:</span>
                                        <span class="badge bg-{{ $task->status == 'completed' ? 'success' : 'info' }} rounded-pill text-capitalize">
                                            {{ str_replace('_', ' ', $task->status) }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small">Due Time:</span>
                                        <span class="fw-bold small">{{ $task->due_datetime ? $task->due_datetime->format('g:i A') : '--:--' }}</span>
                                    </div>
                                </div>
                                <div class="ps-3 border-start">
                                    <div class="small text-muted mb-2">
                                        <i class="bi bi-clock-history me-1"></i> Created {{ $task->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="small text-muted">
                                        <i class="bi bi-arrow-repeat me-1"></i> Updated {{ $task->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-5 {
        border-radius: 2rem !important;
    }

    .min-vh-25 {
        min-height: 150px;
    }

    .progress {
        background-color: #e9ecef;
    }

</style>
@endsection
