<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizerEventController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'total_events' => $user->organizedEvents()->count(),
            'active_events' => $user->organizedEvents()
                ->where('status', 'published')
                ->where('event_date', '>=', now())
                ->count(),
            'total_participants' => $user->organizedEvents()
                ->withCount('registrations')
                ->get()
                ->sum('registrations_count'),
            'total_attendances' => $user->organizedEvents()
                ->with('registrations.attendance')
                ->get()
                ->pluck('registrations')
                ->flatten()
                ->filter(fn($reg) => $reg->attendance)
                ->count(),
        ];

        $upcomingEvents = $user->organizedEvents()
            ->where('status', 'published')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        $recentRegistrations = \App\Models\Registration::whereHas('event', function($q) use ($user) {
                $q->where('organizer_id', $user->id);
            })
            ->with('event', 'user')
            ->latest()
            ->take(10)
            ->get();

        return view('organizer.dashboard', compact('stats', 'upcomingEvents', 'recentRegistrations'));
    }

    public function index(Request $request)
    {
        $query = auth()->user()->organizedEvents();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->withCount('registrations')->latest()->paginate(10)->withQueryString();

        return view('organizer.events.index', compact('events'));
    }

    public function create()
    {
        return view('organizer.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:draft,published',
        ]);

        $validated['organizer_id'] = auth()->id();

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Event::create($validated);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event created successfully');
    }

    public function show(Event $event)
    {
        // Check ownership
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $event->load('registrations.user', 'registrations.attendance');

        $stats = [
            'total_registered' => $event->registrations->count(),
            'total_attended' => $event->registrations->filter(fn($reg) => $reg->attendance)->count(),
            'attendance_rate' => $event->registrations->count() > 0 
                ? round(($event->registrations->filter(fn($reg) => $reg->attendance)->count() / $event->registrations->count()) * 100, 2)
                : 0,
        ];

        return view('organizer.events.show', compact('event', 'stats'));
    }

    public function edit(Event $event)
    {
        // Check ownership
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        return view('organizer.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        // Check ownership
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'quota' => 'required|integer|min:' . $event->registered_count,
            'status' => 'required|in:draft,published,completed,cancelled',
        ]);

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($validated);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event)
    {
        // Check ownership
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        // Prevent deletion if there are registrations
        if ($event->registrations()->count() > 0) {
            return redirect()->route('organizer.events.index')
                ->with('error', 'Cannot delete event with existing registrations');
        }

        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event deleted successfully');
    }

    public function participants(Event $event)
    {
        // Check ownership
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $event->load('registrations.user', 'registrations.attendance');

        return view('organizer.events.participants', compact('event'));
    }
}