<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = $request->user()->reminders();
        
        match($filter) {
            'due' => $query->due(),
            'upcoming' => $query->upcoming(),
            'completed' => $query->where('completed', true),
            default => $query->orderBy('due_date'),
        };
        
        $reminders = $query->paginate(15);
        
        return view('reminders.index', compact('reminders', 'filter'));
    }

    public function create()
    {
        return view('reminders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:now',
            'remind_at' => 'nullable|date|before:due_date|after:now',
        ]);

        $request->user()->reminders()->create($validated);

        return redirect()->route('reminders.index')
            ->with('success', 'Reminder created successfully.');
    }

    public function edit(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        return view('reminders.edit', compact('reminder'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'remind_at' => 'nullable|date|before:due_date',
        ]);

        $reminder->update($validated);

        return redirect()->route('reminders.index')
            ->with('success', 'Reminder updated successfully.');
    }

    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);
        
        $reminder->delete();

        return redirect()->route('reminders.index')
            ->with('success', 'Reminder deleted successfully.');
    }

    public function complete(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $reminder->update(['completed' => true]);

        return back()->with('success', 'Reminder marked as complete.');
    }

    public function uncomplete(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $reminder->update(['completed' => false]);

        return back()->with('success', 'Reminder marked as incomplete.');
    }
}
