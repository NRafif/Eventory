<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EventManagementController;
use App\Http\Controllers\Admin\OrganizerManagementController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Organizer\OrganizerEventController;
use App\Http\Controllers\Organizer\AttendanceController;
use App\Http\Controllers\Participant\ParticipantEventController;
use App\Http\Controllers\Participant\RegistrationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [HomeController::class, 'events'])->name('events.index');
Route::get('/events/{event:slug}', [HomeController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isOrganizer()) {
            return redirect()->route('organizer.dashboard');
        } else {
            return redirect()->route('participant.dashboard');
        }
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Event Management
    Route::resource('events', EventManagementController::class);
    
    // Organizer Management
    Route::resource('organizers', OrganizerManagementController::class);
    
    // Reports
    Route::get('/reports/events', [ReportController::class, 'events'])->name('reports.events');
    Route::get('/reports/participants', [ReportController::class, 'participants'])->name('reports.participants');
    Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('/reports/export/events', [ReportController::class, 'exportEvents'])->name('reports.export.events');
    Route::get('/reports/export/participants', [ReportController::class, 'exportParticipants'])->name('reports.export.participants');
});

/*
|--------------------------------------------------------------------------
| Organizer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/dashboard', [OrganizerEventController::class, 'dashboard'])->name('dashboard');
    
    // Event Management
    Route::resource('events', OrganizerEventController::class);
    Route::get('/events/{event}/participants', [OrganizerEventController::class, 'participants'])->name('events.participants');
    
    // Attendance
    Route::get('/attendance/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::get('/attendance/export/{event}', [AttendanceController::class, 'export'])->name('attendance.export');
});

/*
|--------------------------------------------------------------------------
| Participant Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:participant'])->prefix('participant')->name('participant.')->group(function () {
    Route::get('/dashboard', [ParticipantEventController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-events', [ParticipantEventController::class, 'myEvents'])->name('events.my');
    Route::get('/events', [ParticipantEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event:slug}', [ParticipantEventController::class, 'show'])->name('events.show');
    
    // Registration
    Route::post('/events/{event}/register', [RegistrationController::class, 'register'])->name('events.register');
    Route::get('/registrations/{registration}/ticket', [RegistrationController::class, 'ticket'])->name('registrations.ticket');
    Route::get('/registrations/{registration}/download', [RegistrationController::class, 'downloadTicket'])->name('registrations.download');
    Route::delete('/registrations/{registration}', [RegistrationController::class, 'cancel'])->name('registrations.cancel');
});

require __DIR__.'/auth.php';