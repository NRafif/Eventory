@extends('layouts.dashboard')

@section('page-title', $organizer->name)
@section('page-description', 'Profil organizer dan statistik event')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="max-w-7xl">
    <!-- Organizer Info -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div class="flex items-center">
                <div class="w-20 h-20 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                    <span class="text-3xl font-bold text-primary-600">{{ substr($organizer->name, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $organizer->name }}</h2>
                    <p class="text-gray-600">{{ $organizer->email }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.organizers.edit', $organizer) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Edit
                </a>
                <a href="{{ route('admin.organizers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-gray-900 mb-3">Contact Information</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Phone:</dt>
                        <dd class="font-medium">{{ $organizer->phone ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Address:</dt>
                        <dd class="font-medium">{{ $organizer->address ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Joined:</dt>
                        <dd class="font-medium">{{ $organizer->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="font-semibold text-gray-900 mb-3">Statistics</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Total Events:</dt>
                        <dd class="font-medium">{{ $stats['total_events'] }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Active Events:</dt>
                        <dd class="font-medium">{{ $stats['active_events'] }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Total Participants:</dt>
                        <dd class="font-medium">{{ $stats['total_participants'] }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Events List -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Events ({{ $organizer->organizedEvents->count() }})</h3>
        <div class="space-y-4">
            @forelse($organizer->organizedEvents as $event)
            <div class="p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border border-gray-100">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">{{ $event->title }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $event->event_date->format('M d, Y') }} • {{ $event->location }}</p>
                        <div class="flex gap-4 mt-2 text-sm text-gray-600">
                            <span>{{ $event->registered_count }}/{{ $event->quota }} registered</span>
                            <span>{{ $event->registrations->filter(fn($r) => $r->attendance)->count() }} attended</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $event->getStatusBadgeClass() }}">
                            {{ ucfirst($event->status) }}
                        </span>
                        <a href="{{ route('admin.events.show', $event) }}" class="text-sm text-primary-600 hover:text-primary-700">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 py-8">Belum ada event</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
