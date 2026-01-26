@extends('layouts.app')



@section('content')
<div class="row mb-4">
        <div class="col-12">
                <h2 class="fw-bold">Welcome back!</h2>
                <p class="text-muted">You are logged in as <span class="badge bg-info text-dark">{{ ucfirst(auth()->user()->role) }}</span></p>
            </div>
</div>
@if(auth()->user()->isAdmin())
<a href="{{ route('users.create') }}" class="btn btn-primary">Add New Employee</a>
@endif

{{-- Modern Stat Cards --}}
<div class="row dashboard-stats">
        <div class="col-md-4 mb-3">
                <div class="card bg-white h-100 shadow-sm">
                        <div class="card-body text-center">
                                <h5 class="text-muted">Tasks</h5>
                                <h2 class="fw-bold text-primary">Manage</h2>
                                <a href="{{ route('tasks.index') }}" class="btn btn-primary w-100 mt-2">Open Tasks</a>
                            </div>
                    </div>
            </div>
        <div class="col-md-4 mb-3">
                <div class="card bg-white h-100 shadow-sm">
                        <div class="card-body text-center">
                                <h5 class="text-muted">Events</h5>
                                <h2 class="fw-bold text-success">View</h2>
                                <a href="{{ route('events.index') }}" class="btn btn-success w-100 mt-2">Open Events</a>
                            </div>
                    </div>
            </div>
        <div class="col-md-4 mb-3">
                <div class="card bg-white h-100 shadow-sm">
                        <div class="card-body text-center">
                                <h5 class="text-muted">Schedule</h5>
                                <h2 class="fw-bold text-info">Calendar</h2>
                                <a href="{{ route('calendar.index') }}" class="btn btn-info text-white w-100 mt-2">Open Calendar</a>
                            </div>
                    </div>
            </div>
</div>
@endsection
