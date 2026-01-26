<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    /**
     * JSON endpoint for FullCalendar
     * Called automatically when changing month/week/day or initial load
     */
    public function events(Request $request)
    {
        $start = $request->query('start'); // YYYY-MM-DD
        $end   = $request->query('end');   // YYYY-MM-DD

        $query = Event::query()
            ->whereBetween('date', [$start, $end])
            ->with(['assignedTo' => fn($q) => $q->select('id', 'name')]);

        // Role-based filtering
        if (! auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }

        $events = $query->get()->map(function (Event $event) {
            // Combine date + time into ISO8601 format
            $start = $event->date->format('Y-m-d') . 'T' . $event->start_time->format('H:i:s');
            $end   = $event->date->format('Y-m-d') . 'T' . $event->end_time->format('H:i:s');

            return [
                'id'          => $event->id,
                'title'       => $event->name . ($event->assignedTo ? ' (' . $event->assignedTo->name . ')' : ''),
                'start'       => $start,
                'end'         => $end,
                'allDay'      => false,               // important → shows time
                'extendedProps' => [
                    'assigned_to' => $event->assigned_to,
                    'task_id'     => $event->task_id,
                ],
                // Optional: add CSS class for styling
                'classNames'  => $event->assigned_to === auth()->id() ? ['my-event'] : ['other-event'],
            ];
        });

        return response()->json($events);
    }
}
