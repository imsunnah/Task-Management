@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
<style>
    /* Prevent the calendar from looking cramped on small screens */
    #calendar {
        min-height: 600px;
        margin-top: 10px;
    }

</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Event Schedule</h4>
            <a href="{{ route('events.create') }}" class="btn btn-sm btn-light">Add Event</a>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek'
            , headerToolbar: {
                left: 'prev,next today'
                , center: 'title'
                , right: 'dayGridMonth,timeGridWeek,timeGridDay'
            }
            , slotMinTime: '08:00:00'
            , slotMaxTime: '20:00:00'
            , allDaySlot: false
            , events: @json($events)
            , eventTimeFormat: {
                hour: '2-digit'
                , minute: '2-digit'
                , meridiem: false
                , hour12: false
            },
            // Better UX: Open in new tab or current based on preference
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                    info.jsEvent.preventDefault();
                }
            },
            // Accessibility & Polish
            eventMouseEnter: function(info) {
                info.el.style.cursor = 'pointer';
            }
        });
        calendar.render();
    });

</script>
@endsection
