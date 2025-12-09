@extends('layouts.dashboard')

@section('page-title', $event->title)
@section('page-description', 'Detail event dan manajemen peserta')

@section('sidebar')
    @include('organizer.partials.sidebar')
@endsection

@section('content')
<div class="max-w-7xl">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg p-6 text-white">
            <p class="text-blue-100 text-sm mb-1">Total Registered</p>
            <p class="text-3xl font-bold">{{ $stats['total_registered'] }}</p>
            <p class="text-blue-100 text-xs mt-2">dari {{ $event->quota }} kuota</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-lg p-6 text-white">
            <p class="text-green-100 text-sm mb-1">Total Attended</p>
            <p class="text-3xl font-bold">{{ $stats['total_attended'] }}</p>
            <p class="text-green-100 text-xs mt-2">{{ $stats['attendance_rate'] }}% tingkat kehadiran</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl shadow-lg p-6 text-white">
            <p class="text-purple-100 text-sm mb-1">Available Slots</p>
            <p class="text-3xl font-bold">{{ $event->availableSlots() }}</p>
            <p class="text-purple-100 text-xs mt-2">tersisa</p>
        </div>
    </div>

    <!-- Event Info -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $event->title }}</h2>
                <div class="flex gap-4 text-sm text-gray-600">
                    <span>📅 {{ $event->event_date->format('M d, Y') }}</span>
                    <span>🕐 {{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</span>
                    <span>📍 {{ $event->location }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('organizer.events.participants', $event) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                    View Participants
                </a>
                <a href="{{ route('organizer.events.edit', $event) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Edit
                </a>
                <a href="{{ route('organizer.events.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Back
                </a>
            </div>
        </div>

        <div class="mb-4">
            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $event->getStatusBadgeClass() }}">
                {{ ucfirst($event->status) }}
            </span>
        </div>

        <div class="prose max-w-none">
            <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
            <p class="text-gray-600 whitespace-pre-line">{{ $event->description }}</p>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Registrations</h3>
        <div class="space-y-3">
            @forelse($event->registrations->take(10) as $registration)
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-purple-50 rounded-xl">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                        <span class="text-primary-600 font-semibold">{{ substr($registration->user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $registration->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $registration->registered_at->diffForHumans() }}</p>
                    </div>
                </div>
                @if($registration->attendance)
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">✓ Attended</span>
                @else
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Not Yet</span>
                @endif
            </div>
            @empty
            <p class="text-center text-gray-500 py-8">Belum ada pendaftaran</p>
            @endforelse
        </div>

        @if($event->registrations->count() > 10)
        <div class="mt-4 text-center">
            <a href="{{ route('organizer.events.participants', $event) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                Lihat semua {{ $event->registrations->count() }} peserta →
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
