@extends('layouts.dashboard')

@section('page-title', 'Participants Report')
@section('page-description', 'Lihat dan ekspor laporan pendaftaran peserta.')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="max-w-7xl">
    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Event</label>
                <select name="event_id" class="w-full rounded-lg border-gray-300">
                    <option value="">All Events</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Attendance</label>
                <select name="attendance_status" class="w-full rounded-lg border-gray-300">
                    <option value="">All</option>
                    <option value="attended" {{ request('attendance_status') == 'attended' ? 'selected' : '' }}>Attended</option>
                    <option value="not_attended" {{ request('attendance_status') == 'not_attended' ? 'selected' : '' }}>Not Attended</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                    class="w-full rounded-lg border-gray-300">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg whitespace-nowrap">
                    Filter
                </button>
                <a href="{{ route('admin.reports.export.participants', request()->all()) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg whitespace-nowrap">
                    Export PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Participants Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Participant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attendance</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($registrations as $registration)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                                    <span class="text-primary-600 font-semibold">
                                        {{ substr($registration->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $registration->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $registration->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $registration->event->title }}</div>
                            <div class="text-sm text-gray-500">{{ $registration->event->event_date->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $registration->registered_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $registration->getStatusBadgeClass() }}">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($registration->attendance)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    ✓ Attended
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                    Not Yet
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada pendaftaran ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t">
            {{ $registrations->links() }}
        </div>
    </div>
</div>
@endsection
