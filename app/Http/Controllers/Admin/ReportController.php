<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventsExport;
use App\Exports\ParticipantsExport;

class ReportController extends Controller
{
    public function events(Request $request)
    {
        $query = Event::with('organizer')->withCount('registrations');

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by organizer
        if ($request->has('organizer_id')) {
            $query->where('organizer_id', $request->organizer_id);
        }

        $events = $query->orderBy('event_date', 'desc')->paginate(15);
        $organizers = User::where('role', 'organizer')->get();

        return view('admin.reports.events', compact('events', 'organizers'));
    }

    public function participants(Request $request)
    {
        $query = Registration::with('event', 'user', 'attendance');

        // Filter by event
        if ($request->has('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereHas('event', function($q) use ($request) {
                $q->whereBetween('event_date', [$request->start_date, $request->end_date]);
            });
        }

        // Filter by attendance status
        if ($request->has('attendance_status')) {
            if ($request->attendance_status === 'attended') {
                $query->whereHas('attendance');
            } elseif ($request->attendance_status === 'not_attended') {
                $query->whereDoesntHave('attendance');
            }
        }

        $registrations = $query->latest()->paginate(15);
        $events = Event::orderBy('event_date', 'desc')->get();

        return view('admin.reports.participants', compact('registrations', 'events'));
    }

    public function attendance(Request $request)
    {
        $query = Attendance::with('registration.event', 'registration.user');

        // Filter by event
        if ($request->has('event_id')) {
            $query->whereHas('registration', function($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('checked_in_at', [$request->start_date, $request->end_date]);
        }

        $attendances = $query->latest('checked_in_at')->paginate(15);
        $events = Event::orderBy('event_date', 'desc')->get();

        // Statistics
        $stats = [
            'total_attendances' => Attendance::count(),
            'today_attendances' => Attendance::whereDate('checked_in_at', today())->count(),
            'this_month_attendances' => Attendance::whereMonth('checked_in_at', now()->month)->count(),
        ];

        return view('admin.reports.attendance', compact('attendances', 'events', 'stats'));
    }

    public function exportEvents(Request $request)
    {
        $query = Event::with('organizer')->withCount('registrations');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->orderBy('event_date', 'desc')->get();

        $pdf = Pdf::loadView('admin.reports.pdf.events', compact('events'));
        
        return $pdf->download('events-report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportParticipants(Request $request)
    {
        $query = Registration::with('event', 'user', 'attendance');

        if ($request->has('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereHas('event', function($q) use ($request) {
                $q->whereBetween('event_date', [$request->start_date, $request->end_date]);
            });
        }

        $registrations = $query->latest()->get();

        $pdf = Pdf::loadView('admin.reports.pdf.participants', compact('registrations'));
        
        return $pdf->download('participants-report-' . now()->format('Y-m-d') . '.pdf');
    }
}