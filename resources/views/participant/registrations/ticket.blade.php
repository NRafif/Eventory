@extends('layouts.dashboard')

@section('page-title', 'Tiket Event')
@section('page-description', 'Tiket digital kamu dengan QR code')

@section('sidebar')
    @include('participant.partials.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Ticket Card -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header with Gradient -->
        <div class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 p-8 text-white">
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xl font-bold">Eventory</span>
                    </div>
                    <span class="px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-sm font-medium">
                        E-Ticket
                    </span>
                </div>
                
                <h1 class="text-3xl font-bold mb-2">{{ $registration->event->title }}</h1>
                <p class="text-primary-100">Diselenggarakan oleh {{ $registration->event->organizer->name }}</p>
            </div>
        </div>

        <!-- Ticket Body -->
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Event Details -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Event</h3>
                    <dl class="space-y-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <dt class="text-sm text-gray-600">Tanggal</dt>
                                <dd class="font-medium text-gray-900">{{ $registration->event->event_date->format('l, d F Y') }}</dd>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <dt class="text-sm text-gray-600">Waktu</dt>
                                <dd class="font-medium text-gray-900">{{ $registration->event->start_time->format('H:i') }} - {{ $registration->event->end_time->format('H:i') }} WIB</dd>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <dt class="text-sm text-gray-600">Lokasi</dt>
                                <dd class="font-medium text-gray-900">{{ $registration->event->location }}</dd>
                            </div>
                        </div>
                    </dl>
                </div>

                <!-- Participant Details -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Peserta</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-600">Nama</dt>
                            <dd class="font-medium text-gray-900">{{ $registration->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-600">Email</dt>
                            <dd class="font-medium text-gray-900">{{ $registration->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-600">ID Registrasi</dt>
                            <dd class="font-mono text-sm text-gray-900">#{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-600">Status</dt>
                            <dd>
                                @if($registration->attendance)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">✓ Sudah Hadir</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Terdaftar</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="border-t border-gray-200 pt-8">
                <div class="text-center">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code Kamu</h3>
                    <p class="text-sm text-gray-600 mb-6">Tunjukkan QR code ini di pintu masuk event untuk check-in</p>
                    
                    <div class="inline-block p-6 bg-white border-4 border-gray-200 rounded-2xl shadow-lg">
                        <img src="{{ $qrCodeDataUri }}" alt="QR Code" class="w-64 h-64">
                    </div>
                    
                    <p class="mt-4 text-xs text-gray-500">ID Tiket: {{ $registration->id }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('participant.registrations.download', $registration) }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download Tiket PDF
                </a>
                <a href="{{ route('participant.events.my') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Event Saya
                </a>
            </div>
        </div>
    </div>

    <!-- Important Notes -->
    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
        <div class="flex">
            <svg class="w-5 h-5 text-yellow-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <div>
                <h4 class="text-sm font-medium text-yellow-800">Catatan Penting</h4>
                <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside space-y-1">
                    <li>Datang 15 menit sebelum event dimulai ya</li>
                    <li>Jangan lupa bawa KTP atau identitas lain untuk verifikasi</li>
                    <li>Tiket ini nggak bisa dipindahtangankan ke orang lain</li>
                    <li>Simpan QR code ini baik-baik dan jangan dibagikan ke siapapun</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    @page {
        size: A4;
        margin: 1cm;
    }
    
    body {
        margin: 0;
        padding: 0;
    }
    
    /* Hide everything except ticket */
    body > div:not(.max-w-4xl),
    nav, header, footer, aside,
    button, .bg-yellow-50,
    [class*="sidebar"],
    [class*="navigation"] {
        display: none !important;
    }
    
    /* Show only ticket content */
    .max-w-4xl {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Ensure ticket card fits on one page */
    .bg-white.rounded-2xl {
        page-break-inside: avoid;
        box-shadow: none !important;
        border: 1px solid #e5e7eb;
    }
    
    /* Prevent QR code section from breaking */
    .border-t.border-gray-200.pt-8 {
        page-break-inside: avoid;
        margin-top: 20px;
    }
    
    /* Ensure QR code is visible and centered */
    .inline-block.p-6 {
        page-break-inside: avoid;
    }
    
    /* Hide action buttons */
    .mt-8.flex {
        display: none !important;
    }
    
    /* Adjust spacing for print */
    .p-8 {
        padding: 1.5rem !important;
    }
    
    .mb-8 {
        margin-bottom: 1rem !important;
    }
}
</style>
@endsection
