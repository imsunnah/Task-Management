<?php
// app/Http/Controllers/EventController.php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    use AuthorizesRequests; // <--- This must be here
    public function index()
    {
        $query = Event::with(['assignedTo', 'task']);

        if (! auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }

        $events = $query->latest()->get();

        return view('events.index', compact('events'));
    }


    public function create()
    {
        $this->authorize('create', Event::class);   // uses policy → only admin

        $employees = User::where('role', 'employee')->get();
        $tasks = Task::all();   // or filter if needed

        return view('events.create', compact('employees', 'tasks'));
    }


    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'date'       => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'task_id'    => 'nullable|exists:tasks,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }


    public function show(Event $event)
    {
        $this->authorize('view', $event);
        return view('events.show', compact('event'));
    }


    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $employees = User::where('role', 'employee')->get();
        $tasks = Task::all();

        return view('events.edit', compact('event', 'employees', 'tasks'));
    }


    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            // same rules as in store
        ]);

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }


    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);   // only admin

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
