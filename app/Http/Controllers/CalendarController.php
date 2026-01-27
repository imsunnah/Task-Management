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
    public function events(Request $request)
    {
        $start = $request->query('start');
        $end   = $request->query('end');

        $query = Event::query()
            ->whereBetween('date', [$start, $end])
            ->with(['assignedTo' => fn($q) => $q->select('id', 'name')]);

        if (! auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }
        $events = $query->get()->map(function (Event $event) {
            return [
                'id'    => $event->id,
                'title' => ($event->assignedTo->name ?? 'Unassigned') . ': ' . $event->name,
                'start' => $event->date->format('Y-m-d') . 'T' . $event->start_time->format('H:i:s'),
                'end'   => $event->date->format('Y-m-d') . 'T' . $event->end_time->format('H:i:s'),
                'backgroundColor' => $event->assigned_to === auth()->id() ? '#0d6efd' : '#f8f9fa',
                'textColor'       => $event->assigned_to === auth()->id() ? '#fff' : '#212529',
                'borderColor'     => '#dee2e6',
                'extendedProps' => [
                    'description' => $event->name,
                    'task_title'  => $event->task ? $event->task->title : 'None',
                ],
            ];
        });

        return response()->json($events);
    }
}
