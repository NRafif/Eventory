@extends('layouts.dashboard')

@section('title', 'Organizer Dashboard')
@section('page-title', 'Organizer Dashboard')

@section('sidebar')
    @include('organizer.partials.sidebar')
@endsection

@section('content')
<!-- Quick Actions -->
<div class="mb-8">
    <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg shadow-sm transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Create New Event
    </a>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Events</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_events'] }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Active Events</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['active_events'] }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Participants</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_participants'] }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Attendances</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_attendances'] }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-lg">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Upcoming Events -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Upcoming Events</h2>
            <a href="{{ route('organizer.events.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                View All →
            </a>
        </div>
        <div class="space-y-4">
            @forelse($upcomingEvents as $event)
            <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="font-medium text-gray-900">{{ $event->title }}</h3>
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                        {{ $event->registered_count }}/{{ $event->quota }}
                    </span>
                </div>
                <p class="text-sm text-gray-500">
                    {{ $event->event_date->format('M d, Y') }} • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                </p>
                <p class="text-sm text-gray-600 mt-1">{{ $event->location }}</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('organizer.events.show', $event) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Lihat Detail
                    </a>
                    <span class="text-gray-300">•</span>
                    <a href="{{ route('organizer.events.participants', $event) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Participants
                    </a>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">Tidak ada event mendatang</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Registrations</h2>
        </div>
        <div class="space-y-4">
            @forelse($recentRegistrations as $registration)
            <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-primary-600 font-semibold text-sm">
                            {{ substr($registration->user->name, 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $registration->user->name }}</p>
                    <p class="text-sm text-gray-500 truncate">{{ $registration->event->title }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $registration->registered_at->diffForHumans() }}</p>
                </div>
                @if($registration->attendance)
                <span class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Attended
                </span>
                @endif
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">Belum ada pendaftaran</p>
            @endforelse
        </div>
    </div>
</div>
@endsection