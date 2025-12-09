<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class RegistrationController extends Controller
{
    public function register(Event $event)
    {
        $user = auth()->user();

        // Check if event is published
        if ($event->status !== 'published') {
            return redirect()->back()
                ->with('error', 'This event is not available for registration.');
        }

        // Check if event is full
        if ($event->isFull()) {
            return redirect()->back()
                ->with('error', 'Sorry, this event is already full.');
        }

        // Check if already registered
        if ($event->isRegistered($user->id)) {
            return redirect()->back()
                ->with('error', 'You are already registered for this event.');
        }

        // Check if event date has passed
        if ($event->event_date < now()->toDateString()) {
            return redirect()->back()
                ->with('error', 'This event has already passed.');
        }

        // Create registration
        $registration = Registration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'status' => 'approved',
        ]);

        // Update event registered count
        $event->increment('registered_count');

        return redirect()->route('participant.registrations.ticket', $registration)
            ->with('success', 'Successfully registered! Here is your ticket.');
    }

    public function ticket(Registration $registration)
    {
        // Check ownership
        if ($registration->user_id !== auth()->id()) {
            abort(403);
        }

        $registration->load('event.organizer', 'attendance');

        // Generate QR Code (Endroid v6.1 - Simple approach)
        $qrCode = new QrCode($registration->registration_token);
        
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Get QR Code as data URI
        $qrCodeDataUri = $result->getDataUri();

        return view('participant.registrations.ticket', compact('registration', 'qrCodeDataUri'));
    }

    public function downloadTicket(Registration $registration)
    {
        // Check ownership
        if ($registration->user_id !== auth()->id()) {
            abort(403);
        }

        $registration->load('event.organizer', 'attendance');

        // Generate QR Code
        $qrCode = new QrCode($registration->registration_token);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrCodeDataUri = $result->getDataUri();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('participant.registrations.ticket-pdf', compact('registration', 'qrCodeDataUri'));
        
        return $pdf->download('ticket-' . $registration->event->slug . '-' . $registration->id . '.pdf');
    }

    public function cancel(Registration $registration)
    {
        // Check ownership
        if ($registration->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if event has already started or passed
        if ($registration->event->event_date < now()->toDateString()) {
            return redirect()->back()
                ->with('error', 'Cannot cancel registration. Event has already started or passed.');
        }

        // Check if already attended
        if ($registration->hasAttended()) {
            return redirect()->back()
                ->with('error', 'Cannot cancel registration. You have already attended this event.');
        }

        // Decrease event registered count
        $registration->event->decrement('registered_count');

        // Delete registration
        $registration->delete();

        return redirect()->route('participant.events.my')
            ->with('success', 'Registration cancelled successfully.');
    }
}