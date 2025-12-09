@extends('layouts.dashboard')

@section('title', 'My Dashboard')
@section('page-title', 'My Dashboard')
@section('page-description', 'Selamat datang kembali! Ini yang terjadi hari ini')

@section('sidebar')
    @include('participant.partials.sidebar')
@endsection

@section('content')
<!-- Quick Actions -->
<div class="mb-8">
    <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg shadow-sm transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        Cari Event
    </a>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Event Terdaftar</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['registered_events'] }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Event Mendatang</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['upcoming_events'] }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Sudah Dihadiri</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['attended_events'] }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Event Tersedia</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['available_events'] }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-lg">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Upcoming Events -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">My Upcoming Events</h2>
            <a href="{{ route('participant.events.my') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                Lihat Semua →
            </a>
        </div>
        <div class="space-y-4">
            @forelse($upcomingEvents as $registration)
            <div class="p-4 bg-gradient-to-r from-primary-50 to-white rounded-lg border-l-4 border-primary-500">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="font-medium text-gray-900">{{ $registration->event->title }}</h3>
                    @if($registration->attendance)
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                        ✓ Attended
                    </span>
                    @else
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                        Registered
                    </span>
                    @endif
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-1">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $registration->event->event_date->format('l, M d, Y') }}
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-3">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $registration->event->location }}
                </div>
                <a href="{{ route('participant.registrations.ticket', $registration) }}" class="inline-flex items-center text-sm text-primary-600 hover:text-primary-700 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    View Ticket
                </a>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="mt-2 text-gray-500">Belum ada event mendatang</p>
                <a href="{{ route('events.index') }}" class="mt-4 inline-flex items-center text-sm text-primary-600 hover:text-primary-700 font-medium">
                    Cari Event →
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Available Events -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Available Events</h2>
            <a href="{{ route('events.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                Lihat Semua →
            </a>
        </div>
        <div class="space-y-4">
            @forelse($availableEvents as $event)
            <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <h3 class="font-medium text-gray-900 mb-2">{{ $event->title }}</h3>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $event->event_date->format('M d, Y') }} • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">
                        {{ $event->availableSlots() }} slot tersisa
                    </span>
                    <a href="{{ route('events.show', $event->slug) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Lihat Detail →
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="mt-2 text-gray-500">Belum ada event tersedia</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection