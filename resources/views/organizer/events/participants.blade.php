@extends('layouts.dashboard')

@section('page-title', 'Participants - ' . $event->title)
@section('page-description', 'Kelola peserta event dan kehadiran')

@section('sidebar')
    @include('organizer.partials.sidebar')
@endsection

@section('content')
<div class="max-w-7xl">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $event->title }}</h2>
                <p class="text-gray-600 mt-1">{{ $event->registrations->count() }} peserta terdaftar</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('organizer.attendance.export', $event) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    Export List
                </a>
                <a href="{{ route('organizer.events.show', $event) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Back
                </a>
            </div>
        </div>
    </div>

    <!-- Participants Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Participant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attendance</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($event->registrations as $index => $registration)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                                    <span class="text-primary-600 font-semibold">{{ substr($registration->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $registration->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $registration->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $registration->user->phone ?? '-' }}</div>
                            <div class="text-sm text-gray-500">{{ $registration->user->address ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $registration->registered_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $registration->getStatusBadgeClass() }}">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($registration->attendance)
                                <div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">✓ Attended</span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $registration->attendance->checked_in_at->format('M d, H:i') }}</p>
                                </div>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Not Yet</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada peserta</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
