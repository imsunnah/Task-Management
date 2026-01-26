@extends('layouts.app')

@section('content')
<head>
    <title>Event Calendar</title>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <style>
        #calendar {
            max-width: 1100px;
            margin: 40px auto;
            font-family: sans-serif;
        }

        .my-event {
            background-color: #28a745 !important;
            border-color: #1e7e34 !important;
        }

        .other-event {
            background-color: #007bff !important;
            border-color: #0062cc !important;
        }

    </style>
</head>
<body>

    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
                , headerToolbar: {
                    left: 'prev,next today'
                    , center: 'title'
                    , right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                // Link to your Controller method
                events: '/calendar/events',

                loading: function(isLoading) {
                    if (isLoading) {
                        console.log("Loading events...");
                    }
                },

                eventClick: function(info) {
                    alert('Event: ' + info.event.title);
                    // You can access your extendedProps here:
                    console.log('Task ID:', info.event.extendedProps.task_id);
                }
            });
            calendar.render();
        });

    </script>
</body>
@endsection
