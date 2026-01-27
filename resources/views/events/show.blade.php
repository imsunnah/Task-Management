@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Navigation & Actions --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('events.index') }}" class="btn btn-link text-decoration-none text-muted p-0">
                    <i class="bi bi-arrow-left me-1"></i> Back to Schedule
                </a>
                <div class="d-flex gap-2">
                    @can('update', $event)
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-warning btn-sm rounded-3 px-3">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    @endcan
                </div>
            </div>

            {{-- Main Event Card --}}
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                {{-- Decorative Header Background --}}
                <div class="bg-primary py-5 px-4 text-white text-center position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                    <div class="icon-box bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-calendar-check fs-2"></i>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $event->name }}</h2>
                    <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill">
                        Event ID: #EV-{{ $event->id }}
                    </span>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row g-4">
                        {{-- Left Column: Time & Date --}}
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3 tracking-wider">Time & Venue</h6>
                            <div class="d-flex align-items-start mb-4">
                                <div class="bg-light p-3 rounded-4 me-3 text-primary">
                                    <i class="bi bi-calendar3 fs-4"></i>
                                </div>
                                <div>
                                    <div class="text-dark fw-bold fs-5">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</div>
                                    <div class="text-muted">{{ \Carbon\Carbon::parse($event->date)->format('l') }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="bg-light p-3 rounded-4 me-3 text-primary">
                                    <i class="bi bi-clock fs-4"></i>
                                </div>
                                <div>
                                    <div class="text-dark fw-bold fs-5">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                        <span class="text-muted fw-normal mx-1">to</span>
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                    </div>
                                    <div class="text-muted small">Duration: {{ \Carbon\Carbon::parse($event->start_time)->diff(\Carbon\Carbon::parse($event->end_time))->format('%h hr %i min') }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Personnel & Tasks --}}
                        <div class="col-md-6 border-start ps-md-5">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3 tracking-wider">Assignments</h6>

                            {{-- Assigned Person --}}
                            <div class="mb-4">
                                <label class="text-muted small d-block mb-2">Assigned To</label>
                                <div class="d-flex align-items-center p-2 rounded-4 border bg-white shadow-sm">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($event->assignedTo->name) }}&background=random" class="rounded-circle me-3" width="40" alt="Avatar">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $event->assignedTo->name }}</div>
                                        <div class="text-muted small">Team Member</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Linked Task --}}
                            <div>
                                <label class="text-muted small d-block mb-2">Linked Project Task</label>
                                @if($event->task)
                                <div class="p-3 rounded-4 bg-light border-start border-info border-4">
                                    <div class="fw-bold text-dark"><i class="bi bi-list-check me-2"></i>{{ $event->task->title }}</div>
                                    <div class="text-muted small">View task details for context</div>
                                </div>
                                @else
                                <div class="p-3 rounded-4 bg-light text-muted small">
                                    <i class="bi bi-info-circle me-1"></i> No task linked to this event.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="mt-5 pt-4 border-top text-center">
                        <p class="text-muted small">
                            This event was scheduled on {{ $event->created_at->format('M d, Y') }}
                            at {{ $event->created_at->format('g:i A') }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tracking-wider {
        letter-spacing: 0.1rem;
    }

    .card {
        transition: transform 0.3s ease;
    }

    .rounded-5 {
        border-radius: 2rem !important;
    }

</style>
@endsection
