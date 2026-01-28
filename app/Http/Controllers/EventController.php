<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $events = Event::with(['assignedTo', 'task'])
            ->when(! auth()->user()->isAdmin(), function ($query) {
                $query->where('assigned_to', auth()->id());
            })
            ->latest()
            ->paginate(15);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $this->authorize('create', Event::class);

        $employees = User::where('role', 'employee')->get();
        $tasks = Task::all();

        return view('events.create', compact('employees', 'tasks'));
    }

    public function store(StoreEventRequest $request)
    {
        $this->authorize('create', Event::class);

        DB::transaction(function () use ($request) {
            Event::create($request->validated());
        });

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        $event->load(['assignedTo', 'task']);

        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $employees = User::where('role', 'employee')->get();
        $tasks = Task::all();

        return view('events.edit', compact('event', 'employees', 'tasks'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        DB::transaction(function () use ($request, $event) {
            $event->update($request->validated());
        });

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
