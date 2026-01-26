@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Event Details</h4>
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $event->name }}</p>
        <p><strong>Date:</strong> {{ $event->date }}</p>
        <p><strong>Start Time:</strong> {{ $event->start_time }}</p>
        <p><strong>End Time:</strong> {{ $event->end_time }}</p>
        <p><strong>Related Task:</strong> {{ $event->task ? $event->task->title : 'None' }}</p>
        <p><strong>Assigned To:</strong> {{ $event->assignedTo->name }}</p>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
