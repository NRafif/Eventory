@extends('layouts.dashboard')

@section('page-title', $event->title)
@section('page-description', 'Detail event dan informasi peserta')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="max-w-7xl">
    <!-- Event Info Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $event->title }}</h2>
                <p class="text-gray-600">Organized by {{ $event->organizer->name }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.events.edit', $event) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Edit Event
                </a>
                <a href="{{ route('admin.events.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-gray-900 mb-3">Event Details</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Date:</dt>
                        <dd class="font-medium">{{ $event->event_date->format('M d, Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Time:</dt>
                        <dd class="font-medium">{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Location:</dt>
                        <dd class="font-medium">{{ $event->location }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Status:</dt>
                        <dd><span class="px-2 py-1 text-xs font-medium rounded-full {{ $event->getStatusBadgeClass() }}">{{ ucfirst($event->status) }}</span></dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="font-semibold text-gray-900 mb-3">Registration Stats</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Quota:</dt>
                        <dd class="font-medium">{{ $event->quota }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Registered:</dt>
                        <dd class="font-medium">{{ $event->registered_count }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Available:</dt>
                        <dd class="font-medium">{{ $event->availableSlots() }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Attended:</dt>
                        <dd class="font-medium">{{ $event->registrations->filter(fn($r) => $r->attendance)->count() }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-gray-900 mb-3">Description</h3>
            <p class="text-gray-600 whitespace-pre-line">{{ $event->description }}</p>
        </div>
    </div>

    <!-- Participants List -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Participants ({{ $event->registrations->count() }})</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attendance</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($event->registrations as $registration)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $registration->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $registration->user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $registration->registered_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $registration->getStatusBadgeClass() }}">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($registration->attendance)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">✓ Attended</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Not Yet</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada peserta</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
