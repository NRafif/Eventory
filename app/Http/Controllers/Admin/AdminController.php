<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_events' => Event::count(),
            'active_events' => Event::where('status', 'published')
                ->where('event_date', '>=', now())->count(),
            'total_organizers' => User::where('role', 'organizer')->count(),
            'total_participants' => User::where('role', 'participant')->count(),
            'total_registrations' => Registration::count(),
        ];

        $recentEvents = Event::with('organizer')
            ->latest()
            ->take(10)
            ->get();

        $recentRegistrations = Registration::with('event', 'user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentRegistrations'));
    }
}