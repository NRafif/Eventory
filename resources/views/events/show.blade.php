@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="bg-gradient-to-br from-primary-50 to-white py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Event Header -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Event Image -->
            <div class="relative h-96 bg-gradient-to-br from-primary-400 to-primary-600">
                @if($event->poster)
                    <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                
                <!-- Status Badge -->
                <div class="absolute top-6 right-6">
                    <span class="px-4 py-2 rounded-full text-sm font-medium {{ $event->getStatusBadgeClass() }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>
            </div>

            <!-- Event Info -->
            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
                
                <!-- Event Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-primary-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $event->event_date->format('l, d F Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-primary-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Waktu</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $event->getFormattedTime() }} WIB</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-primary-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <svg class="w-6 h-6 text-primary-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Penyelenggara</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $event->organizer->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-primary-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Kuota</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $event->registered_count }} / {{ $event->quota }} orang terdaftar</p>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-primary-600 h-2 rounded-full transition-all" style="width: {{ ($event->registered_count / $event->quota) * 100 }}%"></div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $event->availableSlots() }} slot tersisa</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex justify-center mb-8">
                    @auth
                        @if(auth()->user()->role === 'participant')
                            @if($event->isRegistered(auth()->id()))
                                @php
                                    $registration = $event->registrations()->where('user_id', auth()->id())->first();
                                @endphp
                                <a href="{{ route('participant.registrations.ticket', $registration) }}" class="inline-flex items-center px-8 py-4 bg-green-600 hover:bg-green-700 text-white text-lg font-medium rounded-lg transition">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Sudah Terdaftar - Lihat Tiket
                                </a>
                            @elseif($event->isFull())
                                <button disabled class="inline-flex items-center px-8 py-4 bg-gray-400 text-white text-lg font-medium rounded-lg cursor-not-allowed">
                                    Kuota Penuh
                                </button>
                            @elseif($event->event_date < now())
                                <button disabled class="inline-flex items-center px-8 py-4 bg-gray-400 text-white text-lg font-medium rounded-lg cursor-not-allowed">
                                    Event Sudah Lewat
                                </button>
                            @else
                                <form action="{{ route('participant.events.register', $event) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white text-lg font-medium rounded-lg transition shadow-lg">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                        Daftar Sekarang
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white text-lg font-medium rounded-lg transition shadow-lg">
                                Login untuk Daftar
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white text-lg font-medium rounded-lg transition shadow-lg">
                            Login untuk Daftar
                        </a>
                    @endauth
                </div>

                <!-- Description -->
                <div class="border-t border-gray-200 pt-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Tentang Event Ini</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Registered Participants -->
        @if($event->registrations->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Peserta Terdaftar ({{ $event->registrations->count() }} orang)</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($event->registrations->take(18) as $registration)
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mb-2">
                                <span class="text-primary-700 font-semibold text-lg">{{ substr($registration->user->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm text-gray-700 text-center truncate w-full">{{ $registration->user->name }}</span>
                        </div>
                    @endforeach
                </div>
                @if($event->registrations->count() > 18)
                    <p class="text-sm text-gray-600 mt-6 text-center">Dan {{ $event->registrations->count() - 18 }} peserta lainnya...</p>
                @endif
            </div>
        @endif

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('events.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Events
            </a>
        </div>
    </div>
</div>
@endsection
