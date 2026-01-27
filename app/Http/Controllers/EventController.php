<?php

namespace App\Http\Controllers;

use App\Models\{Event, Task, User};
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use Illuminate\Support\Facades\{Log, DB};
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $events = Event::with(['assignedTo', 'task'])
            ->when(!auth()->user()->isAdmin(), function ($query) {
                return $query->where('assigned_to', auth()->id());
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
        try {
            DB::transaction(fn() => Event::create($request->validated()));

            return redirect()->route('events.index')->with('success', 'Event scheduled!');
        } catch (\Throwable $e) {
            Log::error('Store failed: ' . $e->getMessage());
            return back()->withInput()->withErrors('Error saving event.');
        }
    }



    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        try {
            $event->delete();

            return redirect()->route('events.index')
                ->with('success', 'Event removed.');
        } catch (\Throwable $e) {

            Log::error('Event deletion failed', [
                'event_id' => $event->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors('Event could not be deleted.');
        }
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
        try {
            DB::transaction(fn() => $event->update($request->validated()));

            return redirect()->route('events.index')->with('success', 'Event updated!');
        } catch (\Throwable $e) {
            Log::error('Update failed: ' . $e->getMessage());
            return back()->withInput()->withErrors('Error updating event.');
        }
    }
}
