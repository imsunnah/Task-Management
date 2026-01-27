@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<style>
    /* FullCalendar Customization */
    :root {
        --fc-border-color: #f1f5f9;
        --fc-button-bg-color: #0d6efd;
        --fc-button-border-color: #0d6efd;
    }

    #calendar {
        background: white;
        padding: 20px;
        border-radius: 15px;
    }

    .fc .fc-toolbar-title {
        font-weight: 800;
        color: #1e293b;
        font-size: 1.5rem;
    }

    .fc .fc-button-primary {
        border-radius: 8px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .fc .fc-daygrid-day-number {
        font-weight: 600;
        color: #64748b;
        padding: 8px;
        text-decoration: none;
    }

    .fc-event {
        cursor: pointer;
        padding: 2px 5px;
        border-radius: 6px !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .fc-v-event {
        border: 1px solid #e2e8f0;
    }

</style>

<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold text-dark mb-0">Event Calendar</h2>
            <p class="text-muted">Visual schedule of all team activities</p>
        </div>
        <div class="col-auto">
            <div class="d-flex gap-2">
                <span class="badge bg-primary px-3 py-2 rounded-pill small">Your Events</span>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill small">Team Events</span>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div id="calendar"></div>
        </div>
    </div>
</div>

{{-- Event Detail Modal (Replaces ugly alert) --}}
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-calendar-event fs-3"></i>
                </div>
                <h5 class="fw-bold mb-1" id="modalTitle"></h5>
                <p class="text-muted small mb-3" id="modalTime"></p>
                <div class="bg-light p-3 rounded-3 text-start small mb-3">
                    <div class="mb-1"><strong>Task:</strong> <span id="modalTask"></span></div>
                </div>
                <div class="d-grid">
                    <button type="button" class="btn btn-light rounded-3 fw-bold" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const modal = new bootstrap.Modal(document.getElementById('eventModal'));

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
            , height: 'auto'
            , headerToolbar: {
                left: 'prev,next today'
                , center: 'title'
                , right: 'dayGridMonth,timeGridWeek'
            }
            , events: '/calendar/events'
            , eventDisplay: 'block'
            , eventTimeFormat: {
                hour: 'numeric'
                , minute: '2-digit'
                , meridiem: 'short'
            },

            eventClick: function(info) {
                // Populate Modal
                document.getElementById('modalTitle').innerText = info.event.title;
                document.getElementById('modalTime').innerText = info.event.start.toLocaleTimeString([], {
                    hour: '2-digit'
                    , minute: '2-digit'
                }) + ' - ' + info.event.end.toLocaleTimeString([], {
                    hour: '2-digit'
                    , minute: '2-digit'
                });
                document.getElementById('modalTask').innerText = info.event.extendedProps.task_title;

                modal.show();
            }
        });
        calendar.render();
    });

</script>
@endsection
