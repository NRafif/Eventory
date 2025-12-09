@extends('layouts.dashboard')

@section('page-title', 'My Events')
@section('page-description', 'Lihat semua event yang sudah kamu daftarkan dan tiketnya')

@section('sidebar')
    @include('participant.partials.sidebar')
@endsection

@section('content')
<div class="max-w-7xl">
    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <input type="text" name="search" placeholder="Search my events..." 
                value="{{ request('search') }}"
                class="flex-1 rounded-lg border-gray-300">
            
            <select name="filter" class="rounded-lg border-gray-300">
                <option value="">All Events</option>
                <option value="upcoming" {{ request('filter') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="past" {{ request('filter') == 'past' ? 'selected' : '' }}>Past</option>
                <option value="attended" {{ request('filter') == 'attended' ? 'selected' : '' }}>Attended</option>
                <option value="not_attended" {{ request('filter') == 'not_attended' ? 'selected' : '' }}>Not Attended</option>
            </select>
            
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg whitespace-nowrap">
                Filter
            </button>
            
            @if(request('search') || request('filter'))
                <a href="{{ route('participant.events.my') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg whitespace-nowrap">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($registrations as $registration)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            <!-- Event Image/Gradient -->
            <div class="relative h-48 bg-gradient-to-br from-primary-400 to-primary-600">
                @if($registration->event->poster)
                    <img src="{{ Storage::url($registration->event->poster) }}" alt="{{ $registration->event->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                
                <!-- Status Badge -->
                <div class="absolute top-4 right-4">
                    @if($registration->attendance)
                        <span class="px-3 py-1 bg-green-500 text-white text-xs font-medium rounded-full">
                            ✓ Attended
                        </span>
                    @elseif($registration->event->event_date < now())
                        <span class="px-3 py-1 bg-gray-500 text-white text-xs font-medium rounded-full">
                            Past Event
                        </span>
                    @else
                        <span class="px-3 py-1 bg-blue-500 text-white text-xs font-medium rounded-full">
                            Registered
                        </span>
                    @endif
                </div>
            </div>

            <!-- Event Info -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $registration->event->title }}</h3>
                
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $registration->event->event_date->format('M d, Y') }}
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $registration->event->start_time->format('H:i') }} - {{ $registration->event->end_time->format('H:i') }}
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ Str::limit($registration->event->location, 30) }}
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('participant.registrations.ticket', $registration) }}" 
                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        View Ticket
                    </a>
                    
                    @if($registration->event->event_date >= now() && !$registration->attendance)
                    <form action="{{ route('participant.registrations.cancel', $registration) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Yakin mau batalkan pendaftaran ini?')"
                                class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-lg transition">
                            Cancel
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Event</h3>
            <p class="mt-2 text-gray-500">Yuk mulai jelajahi dan daftar event seru!</p>
            <a href="{{ route('events.index') }}" class="mt-6 inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari Event
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($registrations->hasPages())
    <div class="mt-8">
        {{ $registrations->links() }}
    </div>
    @endif
</div>
@endsection
