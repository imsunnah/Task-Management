@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Events</h4>
        @can('create', \App\Models\Event::class)
        <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Create Event</a>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Related Task</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->date }}</td>
                    <td>{{ $event->start_time }}</td>
                    <td>{{ $event->end_time }}</td>
                    <td>{{ $event->task ? $event->task->title : 'None' }}</td>
                    <td>
                        <!-- resources/views/events/index.blade.php -->



                        <!-- Inside the table loop -->
                        @can('view', $event)
                        <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-info">View</a>
                        @endcan

                        @can('update', $event)
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endcan

                        @can('delete', $event)
                        <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
