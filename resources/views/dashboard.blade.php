@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Dashboard</h4>
    </div>
    <div class="card-body">
        <p>Welcome, {{ auth()->user()->name }}! Your role is {{ auth()->user()->role }}.</p>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary">View Tasks</a>
        <a href="{{ route('events.index') }}" class="btn btn-primary">View Events</a>
        <a href="{{ route('calendar.index') }}" class="btn btn-primary">View Calendar</a>
    </div>
</div>
@endsection
