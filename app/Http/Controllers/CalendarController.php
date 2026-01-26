<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CalendarController extends Controller
{
    public function index()
    {
        // Fetch events based on role
        if (Gate::allows('view-all-events')) {
            $events = Event::all();
        } else {
            $events = Event::where('assigned_to', Auth::id())->get();
        }

        // Prepare events for FullCalendar JSON
        $calendarEvents = $events->map(function ($event) {
            return [
                'title' => $event->name,
                'start' => $event->date . 'T' . $event->start_time,
                'end' => $event->date . 'T' . $event->end_time,
                'url' => route('events.show', $event->id),
            ];
        });

        return view('calendar.index', compact('calendarEvents'));
    }
}
