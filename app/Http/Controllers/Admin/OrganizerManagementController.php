<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrganizerManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'organizer');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $organizers = $query->withCount('organizedEvents')->latest()->paginate(10);

        return view('admin.organizers.index', compact('organizers'));
    }

    public function create()
    {
        return view('admin.organizers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'organizer';

        User::create($validated);

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer created successfully');
    }

    public function show(User $organizer)
    {
        if ($organizer->role !== 'organizer') {
            abort(404);
        }

        $organizer->load('organizedEvents.registrations');
        
        $stats = [
            'total_events' => $organizer->organizedEvents->count(),
            'active_events' => $organizer->organizedEvents()
                ->where('status', 'published')
                ->where('event_date', '>=', now())
                ->count(),
            'total_participants' => $organizer->organizedEvents()
                ->withCount('registrations')
                ->get()
                ->sum('registrations_count'),
        ];

        return view('admin.organizers.show', compact('organizer', 'stats'));
    }

    public function edit(User $organizer)
    {
        if ($organizer->role !== 'organizer') {
            abort(404);
        }

        return view('admin.organizers.edit', compact('organizer'));
    }

    public function update(Request $request, User $organizer)
    {
        if ($organizer->role !== 'organizer') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $organizer->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $organizer->update($validated);

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer updated successfully');
    }

    public function destroy(User $organizer)
    {
        if ($organizer->role !== 'organizer') {
            abort(404);
        }

        // Check if organizer has events
        if ($organizer->organizedEvents()->count() > 0) {
            return redirect()->route('admin.organizers.index')
                ->with('error', 'Cannot delete organizer with existing events');
        }

        $organizer->delete();

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer deleted successfully');
    }
}