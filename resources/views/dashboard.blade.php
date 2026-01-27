@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-4">
    {{-- Header Section --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h2 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }}! </h2>
            <p class="text-muted mb-0">Here's what's happening with your projects today.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <span class="badge rounded-pill bg-light text-dark border px-3 py-2 me-2">
                <i class="bi bi-shield-lock text-primary me-1"></i> {{ ucfirst(auth()->user()->role) }}
            </span>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm rounded-3">
                <i class="bi bi-person-plus-fill me-1"></i> Add Employee
            </a>
            @endif
        </div>
    </div>

    {{-- Modern Stat Cards --}}
    <div class="row g-4 dashboard-stats">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-4 transition-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-check2-square fs-3 text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Productivity</h6>
                            <h4 class="fw-bold mb-0">Tasks</h4>
                        </div>
                    </div>
                    <p class="text-muted small">Stay on top of your deadlines and project milestones.</p>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary w-100 py-2 rounded-3 mt-2">
                        Manage Tasks <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-4 transition-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-calendar-event fs-3 text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Social</h6>
                            <h4 class="fw-bold mb-0">Events</h4>
                        </div>
                    </div>
                    <p class="text-muted small">Check upcoming company meetings and social gatherings.</p>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-success w-100 py-2 rounded-3 mt-2">
                        View Events <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-4 transition-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-clock-history fs-3 text-info"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Timeline</h6>
                            <h4 class="fw-bold mb-0">Schedule</h4>
                        </div>
                    </div>
                    <p class="text-muted small">Organize your week with our integrated calendar view.</p>
                    <a href="{{ route('calendar.index') }}" class="btn btn-outline-info w-100 py-2 rounded-3 mt-2">
                        Open Calendar <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .card-body i {
        line-height: 0;
    }

</style>
@endsection
