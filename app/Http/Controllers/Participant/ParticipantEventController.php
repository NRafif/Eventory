<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class ParticipantEventController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'registered_events' => $user->registrations()->count(),
            'upcoming_events' => $user->registrations()
                ->whereHas('event', function($q) {
                    $q->where('event_date', '>=', now())
                      ->where('status', 'published');
                })
                ->count(),
            'attended_events' => $user->registrations()
                ->whereHas('attendance')
                ->count(),
            'available_events' => Event::where('status', 'published')
                ->where('event_date', '>=', now())
                ->whereDoesntHave('registrations', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->count(),
        ];

        // Upcoming registered events
        $upcomingEvents = $user->registrations()
            ->whereHas('event', function($q) {
                $q->where('event_date', '>=', now())
                  ->where('status', 'published');
            })
            ->with('event.organizer', 'attendance')
            ->orderBy('registered_at', 'desc')
            ->take(5)
            ->get();

        // Available events to register
        $availableEvents = Event::where('status', 'published')
            ->where('event_date', '>=', now())
            ->whereDoesntHave('registrations', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereColumn('registered_count', '<', 'quota')
            ->orderBy('event_date')
            ->take(6)
            ->get();

        return view('participant.dashboard', compact('stats', 'upcomingEvents', 'availableEvents'));
    }

    public function myEvents(Request $request)
    {
        $user = auth()->user();

        $query = $user->registrations()
            ->with('event.organizer', 'attendance');

        // Filter
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'upcoming':
                    $query->whereHas('event', function($q) {
                        $q->where('event_date', '>=', now())
                          ->where('status', 'published');
                    });
                    break;
                case 'past':
                    $query->whereHas('event', function($q) {
                        $q->where('event_date', '<', now())
                          ->orWhere('status', 'completed');
                    });
                    break;
                case 'attended':
                    $query->whereHas('attendance');
                    break;
                case 'not_attended':
                    $query->whereDoesntHave('attendance')
                        ->whereHas('event', function($q) {
                            $q->where('event_date', '<', now());
                        });
                    break;
            }
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('event', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest('registered_at')->paginate(12);

        return view('participant.events.my', compact('registrations'));
    }

    public function index(Request $request)
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

        return view('participant.events.browse', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load('organizer', 'registrations.user');
        
        $isRegistered = $event->isRegistered(auth()->id());
        $registration = null;
        
        if ($isRegistered) {
            $registration = $event->registrations()
                ->where('user_id', auth()->id())
                ->first();
        }
        
        return view('participant.events.show', compact('event', 'isRegistered', 'registration'));
    }
}