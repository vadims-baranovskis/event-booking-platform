<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()->role === 'admin', 403);
    }

    public function index()
    {
        $this->ensureAdmin();

        $events = Event::query()
            ->with('category')
            ->orderBy('event_date')
            ->get();

        return view('admin.events.index', [
            'events' => $events,
        ]);
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('admin.events.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_tickets' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Event::create([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'price' => $validated['price'],
            'available_tickets' => $validated['available_tickets'],
            'image' => $validated['image'] ?: 'images/events/zaigo-ogre.png',
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $this->ensureAdmin();

        return view('admin.events.edit', [
            'event' => $event,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_tickets' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $event->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'price' => $validated['price'],
            'available_tickets' => $validated['available_tickets'],
            'image' => $validated['image'] ?: 'images/events/zaigo-ogre.png',
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->ensureAdmin();

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}