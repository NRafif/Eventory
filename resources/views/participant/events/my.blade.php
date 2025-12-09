@extends('layouts.dashboard')

@section('page-title', 'My Events')
@section('page-description', 'Event yang sudah kamu daftarkan')

@section('sidebar')
    @include('participant.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Search events..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
            <select name="filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                <option value="">All Events</option>
                <option value="upcoming" {{ request('filter') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="past" {{ request('filter') == 'past' ? 'selected' : '' }}>Past</option>
                <option value="attended" {{ request('filter') == 'attended' ? 'selected' : '' }}>Attended</option>
                <option value="not_attended" {{ request('filter') == 'not_attended' ? 'selected' : '' }}>Not Attended</option>
            </select>
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">
                Search
            </button>
        </form>
    </div>

    <!-- Events Grid -->
    @if($registrations->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($registrations as $registration)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                    <div class="h-48 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                        @if($registration->event->poster)
                            <img src="{{ asset('storage/' . $registration->event->poster) }}" 
                                alt="{{ $registration->event->title }}" 
                                class="w-full h-full object-cover">
                        @else
                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                {{ $registration->event->title }}
                            </h3>
                            @if($registration->attendance)
                                <span class="flex-shrink-0 ml-2 px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    ✓ Attended
                                </span>
                            @endif
                        </div>
                        
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $registration->event->event_date->format('d M Y') }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $registration->event->location }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $registration->event->organizer->name }}
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('participant.registrations.ticket', $registration) }}" 
                                class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-center px-4 py-2 rounded-lg text-sm font-medium">
                                View Ticket
                            </a>
                            
                            @if($registration->event->event_date >= now()->toDateString() && !$registration->attendance)
                                <form action="{{ route('participant.registrations.cancel', $registration) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Yakin mau batalkan pendaftaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $registrations->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Events Found</h3>
            <p class="text-gray-600 mb-4">Kamu belum daftar event apapun nih.</p>
            <a href="{{ route('participant.events.index') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">
                Cari Event
            </a>
        </div>
    @endif
</div>
@endsection
