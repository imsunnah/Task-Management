@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Calendar</h4>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
            , headerToolbar: {
                left: 'prev,next today'
                , center: 'title'
                , right: 'dayGridMonth,timeGridWeek,timeGridDay'
            }
            , events: @json($calendarEvents)
            , eventTimeFormat: {
                hour: '2-digit'
                , minute: '2-digit'
                , hour12: false
            }
            , editable: false
        });

        calendar.render();
    });

</script>


@endsection
