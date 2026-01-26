<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function index()
    {
        if (Gate::allows('view-all-events')) {
            $events = Event::all();
        } else {
            $events = Event::where('assigned_to', Auth::id())->get();
        }

        return view('events.index', compact('events'));
    }

    public function create()
    {
        Gate::authorize('create-event');

        $tasks = \App\Models\Task::all(); // For relating
        return view('events.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create-event');

        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'task_id' => 'nullable|exists:tasks,id',
            'assigned_to' => 'required|exists:users,id', // Admin assigns
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $tasks = \App\Models\Task::all();
        return view('events.edit', compact('event', 'tasks'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'task_id' => 'nullable|exists:tasks,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
