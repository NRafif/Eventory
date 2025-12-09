<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Attendance;
use App\Models\Event;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function scan()
    {
        // Get organizer's events for dropdown
        $events = auth()->user()->organizedEvents()
            ->where('status', 'published')
            ->orderBy('event_date')
            ->get();

        return view('organizer.attendance.scan', compact('events'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // Find registration by token
        $registration = Registration::where('registration_token', $request->token)
            ->with('event', 'user')
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid QR Code. Registration not found.',
            ], 404);
        }

        // Check if event belongs to current organizer
        if ($registration->event->organizer_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. This event does not belong to you.',
            ], 403);
        }

        // Check if registration is approved
        if ($registration->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Registration is not approved.',
            ], 400);
        }

        // Check if already checked in
        if ($registration->hasAttended()) {
            $attendance = $registration->attendance;
            return response()->json([
                'success' => false,
                'message' => 'Already checked in at ' . $attendance->checked_in_at->format('d M Y H:i'),
                'data' => [
                    'participant_name' => $registration->user->name,
                    'event_name' => $registration->event->title,
                    'checked_in_at' => $attendance->checked_in_at->format('d M Y H:i'),
                ],
            ], 400);
        }

        // Create attendance record
        $attendance = Attendance::create([
            'registration_id' => $registration->id,
            'checked_in_at' => now(),
            'checked_in_by' => auth()->user()->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in successful!',
            'data' => [
                'participant_name' => $registration->user->name,
                'participant_email' => $registration->user->email,
                'event_name' => $registration->event->title,
                'event_date' => $registration->event->event_date->format('d M Y'),
                'checked_in_at' => $attendance->checked_in_at->format('d M Y H:i'),
                'checked_in_by' => $attendance->checked_in_by,
            ],
        ]);
    }

    public function export(Event $event)
    {
        // Check ownership
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $event->load('registrations.user', 'registrations.attendance');

        $data = [
            'event' => $event,
            'registrations' => $event->registrations,
            'total_registered' => $event->registrations->count(),
            'total_attended' => $event->registrations->filter(fn($reg) => $reg->attendance)->count(),
            'attendance_rate' => $event->registrations->count() > 0 
                ? round(($event->registrations->filter(fn($reg) => $reg->attendance)->count() / $event->registrations->count()) * 100, 2)
                : 0,
        ];

        $pdf = Pdf::loadView('organizer.attendance.pdf', $data);
        
        return $pdf->download('attendance-' . $event->slug . '-' . now()->format('Y-m-d') . '.pdf');
    }
}