@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('page-description', 'Kelola event, organizer, dan peserta dalam satu tempat.')

@section('content')
<!-- Stats Grid with Gradient Cards -->
<div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Total Events -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-white opacity-5 rounded-full"></div>
        <div class="relative p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-blue-100 text-sm font-medium mb-1">Total Events</p>
            <p class="text-4xl font-bold text-white">{{ $stats['total_events'] }}</p>
        </div>
    </div>

    <!-- Active Events -->
    <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-white opacity-5 rounded-full"></div>
        <div class="relative p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-green-100 text-sm font-medium mb-1">Active Events</p>
            <p class="text-4xl font-bold text-white">{{ $stats['active_events'] }}</p>
        </div>
    </div>

    <!-- Total Organizers -->
    <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-white opacity-5 rounded-full"></div>
        <div class="relative p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-purple-100 text-sm font-medium mb-1">Organizers</p>
            <p class="text-4xl font-bold text-white">{{ $stats['total_organizers'] }}</p>
        </div>
    </div>

    <!-- Total Participants -->
    <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 to-orange-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-white opacity-5 rounded-full"></div>
        <div class="relative p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-orange-100 text-sm font-medium mb-1">Participants</p>
            <p class="text-4xl font-bold text-white">{{ $stats['total_participants'] }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Events -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Events</h2>
            <a href="{{ route('admin.events.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                View All →
            </a>
        </div>
        <div x-data="{ showAll: false }">
            <div class="space-y-4">
                @forelse($recentEvents as $index => $event)
                <div x-show="showAll || {{ $index }} < 5" 
                     x-transition
                     class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl hover:from-blue-50 hover:to-purple-50 transition-all duration-300 border border-gray-100">
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900">{{ $event->title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $event->event_date->format('M d, Y') }} • By {{ $event->organizer->name }}
                        </p>
                    </div>
                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                        {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $event->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ $event->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Belum ada event</p>
                @endforelse
            </div>
            
            @if($recentEvents->count() > 5)
            <div class="mt-4 text-center">
                <button @click="showAll = !showAll" 
                        class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                    <span x-show="!showAll">Show more...</span>
                    <span x-show="showAll" x-cloak>Show less</span>
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Registrations</h2>
            <a href="{{ route('admin.reports.participants') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                View All →
            </a>
        </div>
        <div x-data="{ showAll: false }">
            <div class="space-y-4">
                @forelse($recentRegistrations as $index => $registration)
                <div x-show="showAll || {{ $index }} < 5"
                     x-transition
                     class="flex items-start space-x-3 p-4 bg-gradient-to-r from-gray-50 to-purple-50 rounded-xl hover:from-purple-50 hover:to-pink-50 transition-all duration-300 border border-gray-100">
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
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Belum ada pendaftaran</p>
                @endforelse
            </div>
            
            @if($recentRegistrations->count() > 5)
            <div class="mt-4 text-center">
                <button @click="showAll = !showAll" 
                        class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                    <span x-show="!showAll">Show more...</span>
                    <span x-show="showAll" x-cloak>Show less</span>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection