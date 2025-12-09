<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Report - {{ $event->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
        .info-row {
            margin: 5px 0;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-box {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #4F46E5;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-attended {
            background-color: #DEF7EC;
            color: #03543F;
        }
        .status-not-attended {
            background-color: #FEE;
            color: #991B1B;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN KEHADIRAN EVENT</h1>
        <p>{{ $event->title }}</p>
        <p>{{ $event->event_date->format('l, d F Y') }} | {{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }} WIB</p>
    </div>

    <!-- Event Info -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Penyelenggara:</span>
            <span>{{ $event->organizer->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Lokasi:</span>
            <span>{{ $event->location }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kuota:</span>
            <span>{{ $event->quota }} orang</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Export:</span>
            <span>{{ now()->format('d F Y, H:i') }} WIB</span>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats">
        <div class="stat-box">
            <div class="stat-number">{{ $total_registered }}</div>
            <div class="stat-label">Total Terdaftar</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $total_attended }}</div>
            <div class="stat-label">Sudah Hadir</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $attendance_rate }}%</div>
            <div class="stat-label">Tingkat Kehadiran</div>
        </div>
    </div>

    <!-- Attendance Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama Peserta</th>
                <th style="width: 30%;">Email</th>
                <th style="width: 15%;">Tgl Registrasi</th>
                <th style="width: 20%;">Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $index => $registration)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $registration->user->name }}</td>
                <td>{{ $registration->user->email }}</td>
                <td>{{ $registration->registered_at->format('d/m/Y') }}</td>
                <td>
                    @if($registration->attendance)
                        <span class="status-badge status-attended">
                            ✓ Hadir ({{ $registration->attendance->checked_in_at->format('H:i') }})
                        </span>
                    @else
                        <span class="status-badge status-not-attended">
                            ✗ Belum Hadir
                        </span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem Eventory</p>
        <p>© {{ date('Y') }} Eventory - Event Management System</p>
    </div>
</body>
</html>
