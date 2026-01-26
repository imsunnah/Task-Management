<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CalendarController extends Controller
{
    public function index()
    {
        // Eager load task to avoid N+1 query issues
        $query = Event::with('task');

        if (!Gate::allows('view-all-events')) {
            $query->where('assigned_to', Auth::id());
        }

        $events = $query->get()->map(fn($e) => [
            'id'    => $e->id,
            'title' => $e->name . ($e->task ? " — {$e->task->title}" : ''),
            'start' => $e->date->format('Y-m-d') . 'T' . $e->start_time->format('H:i:s'),
            'end'   => $e->date->format('Y-m-d') . 'T' . $e->end_time->format('H:i:s'),
            'url'   => route('events.show', $e->id),
            'color' => $e->task ? '#3788d8' : '#2c3e50', // Optional: Color code by type
        ]);

        return view('calendar.index', compact('events'));
    }
}
