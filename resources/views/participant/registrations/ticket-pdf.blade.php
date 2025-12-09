<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket - {{ $registration->event->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .ticket {
            border: 3px solid #2563eb;
            border-radius: 15px;
            overflow: hidden;
            max-width: 700px;
            margin: 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 30px;
            position: relative;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .logo-text {
            font-size: 20px;
            font-weight: bold;
            margin-left: 10px;
        }
        .badge {
            float: right;
            background: rgba(255,255,255,0.2);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }
        .event-title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0 5px 0;
        }
        .organizer {
            font-size: 13px;
            opacity: 0.9;
        }
        .body {
            padding: 30px;
            background: white;
        }
        .details-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        .details-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
        }
        .detail-item {
            margin-bottom: 12px;
        }
        .detail-label {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 3px;
        }
        .detail-value {
            font-size: 12px;
            color: #1f2937;
            font-weight: 600;
        }
        .qr-section {
            text-align: center;
            padding: 25px 0;
            border-top: 2px dashed #e5e7eb;
            margin-top: 20px;
        }
        .qr-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .qr-subtitle {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 20px;
        }
        .qr-container {
            display: inline-block;
            padding: 15px;
            background: white;
            border: 3px solid #e5e7eb;
            border-radius: 10px;
        }
        .qr-container img {
            width: 200px;
            height: 200px;
        }
        .ticket-id {
            margin-top: 15px;
            font-size: 10px;
            color: #9ca3af;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-registered {
            background: #dbeafe;
            color: #1e40af;
        }
        .status-attended {
            background: #d1fae5;
            color: #065f46;
        }
        .footer-note {
            margin-top: 25px;
            padding: 15px;
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 5px;
        }
        .footer-note-title {
            font-size: 11px;
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
        }
        .footer-note ul {
            margin: 0;
            padding-left: 20px;
            color: #78350f;
        }
        .footer-note li {
            margin-bottom: 5px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="logo">
                    <span class="logo-text">📅 Eventory</span>
                    <span class="badge">E-TICKET</span>
                </div>
                <div class="event-title">{{ $registration->event->title }}</div>
                <div class="organizer">Diselenggarakan oleh {{ $registration->event->organizer->name }}</div>
            </div>
        </div>

        <!-- Body -->
        <div class="body">
            <div class="details-grid">
                <div class="details-col">
                    <div class="section-title">Detail Event</div>
                    <div class="detail-item">
                        <div class="detail-label">📅 Tanggal</div>
                        <div class="detail-value">{{ $registration->event->event_date->format('l, d F Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">🕐 Waktu</div>
                        <div class="detail-value">{{ $registration->event->start_time->format('H:i') }} - {{ $registration->event->end_time->format('H:i') }} WIB</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">📍 Lokasi</div>
                        <div class="detail-value">{{ $registration->event->location }}</div>
                    </div>
                </div>
                <div class="details-col">
                    <div class="section-title">Data Peserta</div>
                    <div class="detail-item">
                        <div class="detail-label">Nama</div>
                        <div class="detail-value">{{ $registration->user->name }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $registration->user->email }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">ID Registrasi</div>
                        <div class="detail-value">#{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status</div>
                        <div>
                            @if($registration->attendance)
                                <span class="status-badge status-attended">✓ Sudah Hadir</span>
                            @else
                                <span class="status-badge status-registered">Terdaftar</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code -->
            <div class="qr-section">
                <div class="qr-title">QR Code Kamu</div>
                <div class="qr-subtitle">Tunjukkan QR code ini di pintu masuk event untuk check-in</div>
                <div class="qr-container">
                    <img src="{{ $qrCodeDataUri }}" alt="QR Code">
                </div>
                <div class="ticket-id">ID Tiket: {{ $registration->id }}</div>
            </div>

            <!-- Footer Note -->
            <div class="footer-note">
                <div class="footer-note-title">Catatan Penting</div>
                <ul>
                    <li>Datang 15 menit sebelum event dimulai ya</li>
                    <li>Jangan lupa bawa KTP atau identitas lain untuk verifikasi</li>
                    <li>Tiket ini nggak bisa dipindahtangankan ke orang lain</li>
                    <li>Simpan QR code ini baik-baik dan jangan dibagikan ke siapapun</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
