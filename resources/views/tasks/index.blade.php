@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-5">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Project Tasks</h2>
            <p class="text-muted mb-0">Manage and monitor team responsibilities.</p>
        </div>
        @can('create', \App\Models\Task::class)
        <div class="mt-3 mt-md-0">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Create Task
            </a>
        </div>
        @endcan
    </div>

    {{-- Tasks Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th class="ps-4 py-3">Task Title</th>
                        <th class="py-3">Assignee</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Priority</th>
                        <th class="py-3">Due Date</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                    <tr>
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                <div class="task-dot me-3 bg-{{ $task->status === 'completed' ? 'success' : 'primary' }}"></div>
                                <div class="fw-bold text-dark">{{ $task->title }}</div>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignedTo->name ?? 'NA') }}&background=random&size=32" class="rounded-circle me-2" alt="avatar">
                                <span class="text-muted small fw-medium">{{ $task->assignedTo->name ?? 'Unassigned' }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            @php
                            $statusColors = [
                            'pending' => 'bg-warning text-dark',
                            'in_progress' => 'bg-info text-white',
                            'completed' => 'bg-success text-white'
                            ];
                            @endphp
                            <span class="badge {{ $statusColors[$task->status] ?? 'bg-secondary' }} px-3 py-2 rounded-pill small fw-medium text-capitalize">
                                {{ str_replace('_', ' ', $task->status) }}
                            </span>
                        </td>
                        <td class="py-4">
                            @php
                            $priorityColors = ['low' => 'success', 'medium' => 'warning', 'high' => 'danger'];
                            $color = $priorityColors[$task->priority] ?? 'secondary';
                            @endphp
                            <div class="d-flex align-items-center text-{{ $color }} small fw-bold">
                                <i class="bi bi-flag-fill me-1"></i>
                                <span class="text-capitalize">{{ $task->priority }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="small fw-bold {{ $task->due_datetime && $task->due_datetime->isPast() && $task->status !== 'completed' ? 'text-danger' : 'text-dark' }}">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $task->due_datetime ? $task->due_datetime->format('M d, H:i') : 'No Deadline' }}
                            </div>
                        </td>
                        <td class="text-end pe-4 py-4">
                            <div class="btn-group shadow-sm rounded-3">
                                @can('view', $task)
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-white btn-sm px-3 text-info" title="View"><i class="bi bi-eye"></i></a>
                                @endcan

                                @can('update', $task)
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-white btn-sm px-3 text-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                @endcan

                                @can('delete', $task)
                                <button type="button" class="btn btn-white btn-sm px-3 text-danger" data-bs-toggle="modal" data-bs-target="#deleteTask{{ $task->id }}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>

                    {{-- Delete Modal --}}
                    @can('delete', $task)
                    <div class="modal fade" id="deleteTask{{ $task->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content border-0 shadow rounded-5">
                                <div class="modal-body p-4 text-center">
                                    <i class="bi bi-exclamation-circle text-danger fs-1 mb-3 d-block"></i>
                                    <h5 class="fw-bold">Remove Task?</h5>
                                    <p class="text-muted small mb-4">Are you sure you want to delete <strong>{{ $task->title }}</strong>?</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger px-3 shadow-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-list-check fs-1 opacity-25 d-block mb-3"></i>
                            No tasks found. Time to delegate!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .task-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .btn-white {
        background-color: white;
        border: 1px solid #f1f5f9;
    }

    .btn-white:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }

    tr:hover {
        background-color: #fcfdfe;
    }

    .rounded-5 {
        border-radius: 1.25rem !important;
    }

</style>
@endsection
