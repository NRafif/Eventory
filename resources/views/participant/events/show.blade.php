@extends('layouts.dashboard')

@section('page-title', $event->title)
@section('page-description', 'Detail lengkap event')

@section('sidebar')
    @include('participant.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Event Header -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="h-64 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
            @if($event->poster)
                <img src="{{ asset('storage/' . $event->poster) }}" 
                    alt="{{ $event->title }}" 
                    class="w-full h-full object-cover">
            @else
                <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            @endif
        </div>
        
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $event->getStatusBadgeClass() }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>
                
                @if($isRegistered)
                    <a href="{{ route('participant.registrations.ticket', $registration) }}" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium">
                        Lihat Tiket Saya
                    </a>
                @elseif($event->isFull())
                    <button disabled class="bg-gray-400 text-white px-6 py-3 rounded-lg font-medium cursor-not-allowed">
                        Kuota Penuh
                    </button>
                @elseif($event->event_date < now()->toDateString())
                    <button disabled class="bg-gray-400 text-white px-6 py-3 rounded-lg font-medium cursor-not-allowed">
                        Event Sudah Lewat
                    </button>
                @else
                    <form action="{{ route('participant.events.register', $event) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium">
                            Daftar Sekarang
                        </button>
                    </form>
                @endif
            </div>

            <!-- Event Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-gray-400 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $event->event_date->format('l, d F Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-gray-400 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">Waktu</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $event->getFormattedTime() }} WIB</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-gray-400 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">Lokasi</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $event->location }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-gray-400 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">Penyelenggara</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $event->organizer->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-gray-400 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">Kuota</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $event->registered_count }} / {{ $event->quota }} orang</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-primary-600 h-2 rounded-full" style="width: {{ ($event->registered_count / $event->quota) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Tentang Event Ini</h2>
        <div class="prose max-w-none text-gray-700">
            {!! nl2br(e($event->description)) !!}
        </div>
    </div>

    <!-- Registered Participants -->
    @if($event->registrations->count() > 0)
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Peserta Terdaftar ({{ $event->registrations->count() }} orang)</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($event->registrations->take(12) as $reg)
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-primary-700 font-semibold">{{ substr($reg->user->name, 0, 1) }}</span>
                        </div>
                        <span class="text-sm text-gray-700 truncate">{{ $reg->user->name }}</span>
                    </div>
                @endforeach
            </div>
            @if($event->registrations->count() > 12)
                <p class="text-sm text-gray-600 mt-4">Dan {{ $event->registrations->count() - 12 }} peserta lainnya...</p>
            @endif
        </div>
    @endif
</div>
@endsection
