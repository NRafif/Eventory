@extends('layouts.app')

@section('title', 'Discover Amazing Events')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
        <div class="text-center animate-fade-in">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                Discover Amazing Events
                <span class="block text-primary-200 mt-2">Near You</span>
            </h1>
            <p class="mt-6 text-xl sm:text-2xl text-primary-100 max-w-3xl mx-auto">
                Kenalan dengan banyak orang, rasakan pengalaman baru, dan ciptakan momen tak terlupakan lewat event pilihan kami
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-lg text-primary-700 bg-white hover:bg-primary-50 transform hover:scale-105 transition duration-200 shadow-lg">
                    Lihat Event
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                @guest
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-primary-700 transform hover:scale-105 transition duration-200">
                    Mulai Sekarang
                </a>
                @endguest
            </div>
        </div>

        <!-- Stats -->
        <div class="mt-20 grid grid-cols-1 gap-6 sm:grid-cols-3 animate-slide-up">
            <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6 text-center border border-white border-opacity-20 hover:bg-opacity-20 transition duration-300">
                <div class="text-4xl font-bold text-white">{{ $stats['total_events'] }}+</div>
                <div class="mt-2 text-primary-100 font-medium">Total Events</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6 text-center border border-white border-opacity-20 hover:bg-opacity-20 transition duration-300">
                <div class="text-4xl font-bold text-white">{{ $stats['upcoming_events'] }}</div>
                <div class="mt-2 text-primary-100 font-medium">Upcoming Events</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6 text-center border border-white border-opacity-20 hover:bg-opacity-20 transition duration-300">
                <div class="text-4xl font-bold text-white">{{ $stats['completed_events'] }}</div>
                <div class="mt-2 text-primary-100 font-medium">Completed Events</div>
            </div>
        </div>
    </div>

    <!-- Wave Bottom -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 0L60 10C120 20 240 40 360 46.7C480 53 600 47 720 43.3C840 40 960 40 1080 46.7C1200 53 1320 67 1380 73.3L1440 80V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z" fill="rgb(249 250 251)"/>
        </svg>
    </div>
</div>

<!-- Features Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-slide-up">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                Kenapa Memilih Eventory?
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Semua yang kamu butuhkan untuk menemukan, mendaftar, dan mengelola event — semuanya dalam satu tempat.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pendaftaran Mudah</h3>
                <p class="text-gray-600">
                    Daftar ke event hanya dalam hitungan detik dengan proses yang simpel. Tanpa form ribet atau prosedur panjang
                </p>
            </div>

            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Tiket QR Code</h3>
                <p class="text-gray-600">
                    Dapatkan tiket digital instan dengan QR code unik. Check-in cepat, tanpa kertas, dan sepenuhnya contactless
                </p>
            </div>

            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Aman & Terpercaya</h3>
                <p class="text-gray-600">
                    Data kamu dilindungi dengan standar keamanan terbaik. Pendaftaran aman dan pengelolaan event yang andal
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Events Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-2">
                    Upcoming Events
                </h2>
                <p class="text-lg text-gray-600">
                    Jangan sampai kelewatan kesempatan menarik ini
                </p>
            </div>
            <a href="{{ route('events.index') }}" class="hidden sm:inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 transition duration-150">
                View All
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        @if($upcomingEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($upcomingEvents as $event)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48 bg-gradient-to-br from-primary-400 to-primary-600 overflow-hidden">
                        @if($event->poster)
                            <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-primary-700">
                                {{ $event->availableSlots() }} slots left
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $event->event_date->format('M d, Y') }} • {{ $event->start_time->format('H:i') }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                            {{ $event->title }}
                        </h3>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $event->location }}
                        </div>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ Str::limit($event->description, 100) }}
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                By {{ $event->organizer->name }}
                            </span>
                            <a href="{{ route('events.show', $event->slug) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium text-sm">
                                Lihat Detail
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center sm:hidden">
                <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 transition duration-150">
                    View All Events
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Event</h3>
                <p class="mt-2 text-gray-500">Cek kembali nanti untuk keseruan event baru ya!</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-primary-600 to-primary-800 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">
            Siap Untuk Memulai?
        </h2>
        <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
            Bergabunglah dengan ribuan event enthusiast lain dan mulai menemukan pengalaman luar biasa hari ini
        </p>
        @guest
            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-primary-700 transform hover:scale-105 transition duration-200">
                Create Free Account
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        @else
            <a href="{{ route('events.index') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-primary-700 transform hover:scale-105 transition duration-200">
                Browse All Events
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        @endguest
    </div>
</section>
@endsection