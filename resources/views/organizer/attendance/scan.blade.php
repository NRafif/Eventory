@extends('layouts.dashboard')

@section('page-title', 'QR Scanner')
@section('page-description', 'Scan tiket peserta untuk check-in')

@section('sidebar')
    @include('organizer.partials.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Scanner Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="mb-6">
            <label for="event-select" class="block text-sm font-medium text-gray-700 mb-2">Select Event</label>
            <select id="event-select" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                <option value="">Pilih event...</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->title }} - {{ $event->event_date->format('d M Y') }}</option>
                @endforeach
            </select>
        </div>

        <!-- Scanner Area -->
        <div class="border-4 border-dashed border-gray-300 rounded-lg p-8 text-center">
            <div id="scanner-container" class="hidden">
                <video id="qr-video" class="w-full max-w-md mx-auto rounded-lg"></video>
                <p class="text-sm text-gray-600 mt-4">Posisikan QR code di dalam frame</p>
            </div>
            
            <div id="scanner-placeholder" class="py-12">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">QR Code Scanner</h3>
                <p class="text-gray-600 mb-2">Pilih event untuk mulai scan</p>
                <p class="text-xs text-gray-500 mb-4">Browser akan minta izin akses kamera saat kamu klik tombol di bawah</p>
                <button id="start-scan-btn" disabled class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium disabled:bg-gray-400 disabled:cursor-not-allowed">
                    Start Scanning
                </button>
            </div>
        </div>

        <!-- Manual Input -->
        <div class="mt-6">
            <p class="text-sm text-gray-600 mb-2">Atau masukkan kode tiket manual:</p>
            <div class="flex gap-2">
                <input type="text" id="manual-token" placeholder="Masukkan token pendaftaran..." 
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                <button id="manual-checkin-btn" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-medium">
                    Check In
                </button>
            </div>
        </div>
    </div>

    <!-- Result Card -->
    <div id="result-card" class="hidden bg-white rounded-lg shadow-sm p-6">
        <div id="result-content"></div>
    </div>

    <!-- Recent Check-ins -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Check-ins</h3>
        <div id="recent-checkins" class="space-y-3">
            <p class="text-gray-600 text-center py-4">Belum ada check-in</p>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let html5QrCode = null;
let selectedEventId = null;
let recentCheckins = [];

// Event selection
document.addEventListener('DOMContentLoaded', function() {
    const eventSelect = document.getElementById('event-select');
    const startBtn = document.getElementById('start-scan-btn');
    
    if (eventSelect) {
        eventSelect.addEventListener('change', function() {
            selectedEventId = this.value;
            console.log('Event selected:', selectedEventId);
            if (startBtn) {
                startBtn.disabled = !selectedEventId;
                console.log('Button disabled:', startBtn.disabled);
            }
        });
    }
});

// Start scanning
document.getElementById('start-scan-btn').addEventListener('click', function() {
    if (!selectedEventId) {
        alert('Pilih event dulu ya');
        return;
    }
    
    document.getElementById('scanner-placeholder').classList.add('hidden');
    document.getElementById('scanner-container').classList.remove('hidden');
    
    html5QrCode = new Html5Qrcode("qr-video");
    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        onScanSuccess,
        onScanError
    ).catch(err => {
        console.error('Error starting camera:', err);
        document.getElementById('scanner-container').classList.add('hidden');
        document.getElementById('scanner-placeholder').classList.remove('hidden');
        alert('Gagal membuka kamera. Pastikan browser punya izin akses kamera dan kamu menggunakan HTTPS atau localhost.');
    });
});

// Scan success
function onScanSuccess(decodedText, decodedResult) {
    html5QrCode.pause();
    checkIn(decodedText);
}

function onScanError(errorMessage) {
    // Ignore scan errors
}

// Check-in function
function checkIn(token) {
    fetch('{{ route("organizer.attendance.checkin") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ token: token })
    })
    .then(response => response.json())
    .then(data => {
        showResult(data);
        if (data.success) {
            addToRecentCheckins(data.data);
            setTimeout(() => {
                if (html5QrCode) {
                    html5QrCode.resume();
                }
            }, 2000);
        } else {
            setTimeout(() => {
                if (html5QrCode) {
                    html5QrCode.resume();
                }
            }, 3000);
        }
    })
    .catch(error => {
        showResult({
            success: false,
            message: 'Error jaringan. Coba lagi ya.'
        });
        setTimeout(() => {
            if (html5QrCode) {
                html5QrCode.resume();
            }
        }, 3000);
    });
}

// Manual check-in
document.getElementById('manual-checkin-btn').addEventListener('click', function() {
    const token = document.getElementById('manual-token').value.trim();
    if (!token) {
        alert('Masukkan token pendaftaran dulu');
        return;
    }
    checkIn(token);
    document.getElementById('manual-token').value = '';
});

// Show result
function showResult(data) {
    const resultCard = document.getElementById('result-card');
    const resultContent = document.getElementById('result-content');
    
    if (data.success) {
        resultContent.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-green-900">Check-in Successful!</h3>
                    <div class="mt-2 text-sm text-gray-700">
                        <p><strong>Name:</strong> ${data.data.participant_name}</p>
                        <p><strong>Email:</strong> ${data.data.participant_email}</p>
                        <p><strong>Event:</strong> ${data.data.event_name}</p>
                        <p><strong>Time:</strong> ${data.data.checked_in_at}</p>
                    </div>
                </div>
            </div>
        `;
    } else {
        resultContent.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-red-900">Check-in Failed</h3>
                    <p class="mt-2 text-sm text-gray-700">${data.message}</p>
                    ${data.data ? `
                        <div class="mt-2 text-sm text-gray-600">
                            <p><strong>Name:</strong> ${data.data.participant_name}</p>
                            <p><strong>Already checked in at:</strong> ${data.data.checked_in_at}</p>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    }
    
    resultCard.classList.remove('hidden');
}

// Add to recent check-ins
function addToRecentCheckins(data) {
    recentCheckins.unshift(data);
    if (recentCheckins.length > 5) {
        recentCheckins.pop();
    }
    updateRecentCheckins();
}

function updateRecentCheckins() {
    const container = document.getElementById('recent-checkins');
    if (recentCheckins.length === 0) {
        container.innerHTML = '<p class="text-gray-600 text-center py-4">Belum ada check-in</p>';
        return;
    }
    
    container.innerHTML = recentCheckins.map(checkin => `
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div>
                <p class="font-medium text-gray-900">${checkin.participant_name}</p>
                <p class="text-sm text-gray-600">${checkin.event_name}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">${checkin.checked_in_at}</p>
                <span class="text-xs text-green-600">✓ Checked in</span>
            </div>
        </div>
    `).join('');
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (html5QrCode) {
        html5QrCode.stop();
    }
});
</script>
@endsection
