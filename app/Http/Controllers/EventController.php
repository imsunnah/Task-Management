<?php

namespace App\Http\Controllers;

use App\Models\{Event, Task, User};
use App\Http\Requests\StoreEventRequest;
use Illuminate\Support\Facades\{Log, DB};
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        try {
            $events = Event::with(['assignedTo', 'task'])
                ->when(!auth()->user()->isAdmin(), function ($query) {
                    return $query->where('assigned_to', auth()->id());
                })
                ->latest()
                ->paginate(15); // Better than get() for performance

            return view('events.index', compact('events'));
        } catch (Exception $e) {
            Log::error("Failed to fetch events: " . $e->getMessage());
            return back()->withErrors('Could not load events at this time.');
        }
    }
    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        // 1. Check if the user is authorized (usually Admin only)
        $this->authorize('create', Event::class);

        try {
            // 2. Fetch data needed for the smart dropdowns
            $employees = \App\Models\User::where('role', 'employee')->get();
            $tasks = \App\Models\Task::all();

            // 3. Return your smart blade view
            return view('events.create', compact('employees', 'tasks'));
        } catch (\Exception $e) {
            \Log::error("Failed to load event creation form: " . $e->getMessage());
            return redirect()->route('events.index')
                ->withErrors('Unable to open the event creator right now.');
        }
    }
    public function store(StoreEventRequest $request)
    {
        $this->authorize('create', Event::class);

        try {
            DB::beginTransaction();

            Event::create($request->validated());

            DB::commit();
            return redirect()->route('events.index')
                ->with('success', 'Event scheduled successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Event creation failed: " . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors('Something went wrong while saving the event.');
        }
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        try {
            $event->delete();
            return redirect()->route('events.index')
                ->with('success', 'Event removed.');
        } catch (Exception $e) {
            Log::error("Event deletion failed: " . $e->getMessage());
            return back()->withErrors('Task could not be deleted.');
        }
    }
    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);

        try {
            $event->load(['assignedTo', 'task']);
            return view('events.show', compact('event'));
        } catch (\Exception $e) {
            \Log::error("Failed to view event: " . $e->getMessage());
            return redirect()->route('events.index')
                ->withErrors('The event details could not be retrieved.');
        }
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        // Fetch data needed for the dropdowns
        $employees = \App\Models\User::where('role', 'employee')->get();
        $tasks = \App\Models\Task::all();

        return view('events.edit', compact('event', 'employees', 'tasks'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(\App\Http\Requests\StoreEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        try {
            \DB::beginTransaction();

            $event->update($request->validated());

            \DB::commit();
            return redirect()->route('events.index')
                ->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error("Event update failed: " . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors('Something went wrong while updating the event.');
        }
    }
}
