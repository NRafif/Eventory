<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Participants Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-attended { background-color: #d4edda; color: #155724; }
        .badge-not-attended { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Participants Report</h1>
        <p>Generated on {{ now()->format('F d, Y H:i') }}</p>
        <p>Total Participants: {{ $registrations->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Participant</th>
                <th style="width: 30%;">Event</th>
                <th style="width: 20%;">Registered</th>
                <th style="width: 20%;">Attendance</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $registration)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $registration->user->name }}</strong><br>
                    <small>{{ $registration->user->email }}</small>
                </td>
                <td>
                    <strong>{{ $registration->event->title }}</strong><br>
                    <small>{{ $registration->event->event_date->format('M d, Y') }}</small>
                </td>
                <td>{{ $registration->registered_at->format('M d, Y H:i') }}</td>
                <td>
                    @if($registration->attendance)
                        <span class="badge badge-attended">✓ Attended</span><br>
                        <small>{{ $registration->attendance->checked_in_at->format('M d, H:i') }}</small>
                    @else
                        <span class="badge badge-not-attended">Not Yet</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">No participants found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Eventory - Event Management System</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>
