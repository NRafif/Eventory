<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Events Report</title>
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
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-published { background-color: #d4edda; color: #155724; }
        .status-draft { background-color: #f8d7da; color: #721c24; }
        .status-completed { background-color: #d1ecf1; color: #0c5460; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Events Report</h1>
        <p>Generated on {{ now()->format('F d, Y H:i') }}</p>
        <p>Total Events: {{ $events->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 30%;">Event</th>
                <th style="width: 20%;">Organizer</th>
                <th style="width: 15%;">Date</th>
                <th style="width: 15%;">Registrations</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $index => $event)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $event->title }}</strong><br>
                    <small>{{ $event->location }}</small>
                </td>
                <td>{{ $event->organizer->name }}</td>
                <td>{{ $event->event_date->format('M d, Y') }}</td>
                <td>{{ $event->registrations_count }} / {{ $event->quota }}</td>
                <td>
                    <span class="status status-{{ $event->status }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No events found</td>
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
