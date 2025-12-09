<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::where('status', 'published')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(6)
            ->get();

        $stats = [
            'total_events' => Event::where('status', 'published')->count(),
            'upcoming_events' => Event::where('status', 'published')
                ->where('event_date', '>=', now())->count(),
            'completed_events' => Event::where('status', 'completed')->count(),
        ];

        return view('home', compact('upcomingEvents', 'stats'));
    }

    public function events(Request $request)
    {
        $query = Event::where('status', 'published')
            ->where('event_date', '>=', now());

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('event_date', $request->date);
        }

        $events = $query->orderBy('event_date')->paginate(12)->withQueryString();

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load('organizer', 'registrations.user');
        
        return view('events.show', compact('event'));
    }
}