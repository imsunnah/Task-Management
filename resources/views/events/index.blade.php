@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-5">
    @if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        <div class="toast show align-items-center text-white bg-success border-0 shadow-lg rounded-4" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif
    @if($errors->any())
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        @foreach($errors->all() as $error)
        <div class="toast show align-items-center text-white bg-danger border-0 shadow-lg rounded-4 mb-2" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $error }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Event Schedule</h2>
            <p class="text-muted mb-0">Track meetings, deadlines, and team activities.</p>
        </div>
        @can('create', \App\Models\Event::class)
        <div class="mt-3 mt-md-0">
            <a href="{{ route('events.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                <i class="bi bi-plus-circle-fill me-2"></i>New Event
            </a>
        </div>
        @endcan
    </div>

    {{-- Events Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th class="ps-4 py-3 border-0">Event Details</th>
                        <th class="py-3 border-0">Date & Time</th>
                        <th class="py-3 border-0">Associated Task</th>
                        <th class="py-3 border-0 text-center">Status</th>
                        <th class="text-end pe-4 py-3 border-0">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($events as $event)
                    <tr>
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                <div class="event-icon me-3 bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $event->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</div>
                            <div class="text-muted small">
                                {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                            </div>
                        </td>
                        <td class="py-4">
                            @if($event->task)
                            <span class="badge bg-light text-dark border fw-medium rounded-pill px-3 py-2">
                                <i class="bi bi-hash me-1"></i>{{ $event->task->title }}
                            </span>
                            @else
                            <span class="text-muted small italic">No task linked</span>
                            @endif
                        </td>
                        <td class="text-center py-4">
                            @php
                            $startTime = \Carbon\Carbon::parse($event->date)->setTimeFromTimeString($event->start_time);
                            $isPast = $startTime->isPast();
                            @endphp
                            @if($isPast)
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill fw-medium">Completed</span>
                            @else
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-medium">Upcoming</span>
                            @endif
                        </td>
                        <td class="text-end pe-4 py-4">
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                @can('view', $event)
                                <a href="{{ route('events.show', $event) }}" class="btn btn-white btn-sm px-3 text-info" title="View"><i class="bi bi-eye"></i></a>
                                @endcan

                                @can('update', $event)
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-white btn-sm px-3 text-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                @endcan

                                @can('delete', $event)
                                <button type="button" class="btn btn-white btn-sm px-3 text-danger" data-bs-toggle="modal" data-bs-target="#deleteEvent{{ $event->id }}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @can('delete', $event)
                    <div class="modal fade" id="deleteEvent{{ $event->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content border-0 shadow-lg rounded-5">
                                <div class="modal-body p-4 text-center">
                                    <div class="text-danger mb-3">
                                        <i class="bi bi-exclamation-circle-fill fs-1"></i>
                                    </div>
                                    <h5 class="fw-bold">Delete Event?</h5>
                                    <p class="text-muted small">This will permanently remove <strong>{{ $event->name }}</strong>. This cannot be undone.</p>
                                    <div class="d-flex justify-content-center gap-2 mt-4">
                                        <button type="button" class="btn btn-light px-3 py-2 rounded-3 btn-sm fw-bold text-muted" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger px-3 py-2 rounded-3 btn-sm fw-bold shadow-sm">Delete Event</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="py-5">
                                <i class="bi bi-calendar-x fs-1 opacity-25 d-block mb-3"></i>
                                <h5 class="text-muted fw-normal">No events found in the schedule</h5>
                                <p class="text-muted small">Start by creating a new activity for your team.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .event-icon {
        transition: all 0.3s ease-in-out;
    }

    tr:hover {
        background-color: #fbfcfd;
    }

    tr:hover .event-icon {
        background-color: #0d6efd !important;
        color: white !important;
        transform: scale(1.1);
    }

    .btn-white {
        background-color: white;
        border: 1px solid #edf2f7;
    }

    .btn-white:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }

    .rounded-5 {
        border-radius: 1.5rem !important;
    }

</style>
@endsection
