@extends('layouts.dashboard')

@section('page-title', 'My Events')

@section('header-actions')
    <a href="{{ route('organizer.events.create') }}" class="bg-white hover:bg-primary-50 text-primary-700 font-bold py-2 px-4 rounded-lg text-sm shadow-lg transition">
        Create New Event
    </a>
@endsection

@section('sidebar')
    @include('organizer.partials.sidebar')
@endsection

@section('content')
    <div class="max-w-7xl">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Search & Filter -->
                    <form method="GET" class="mb-6">
                        <div class="flex gap-4">
                            <input type="text" name="search" placeholder="Cari event..." 
                                value="{{ request('search') }}"
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                            
                            @if(request('search') || request('status'))
                                <a href="{{ route('organizer.events.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>

                    <!-- Events Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registrations</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($events as $event)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($event->location, 30) }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $event->event_date->format('d M Y') }}
                                            <div class="text-xs text-gray-500">{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                <span class="font-semibold">{{ $event->registrations_count }}</span> / {{ $event->quota }}
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                <div class="bg-blue-600 h-2 rounded-full" 
                                                    style="width: {{ $event->quota > 0 ? ($event->registrations_count / $event->quota * 100) : 0 }}%"></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $event->getStatusBadgeClass() }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium space-x-2">
                                            <a href="{{ route('organizer.events.show', $event) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('organizer.events.edit', $event) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('organizer.events.destroy', $event) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                    onclick="return confirm('Yakin? Ini bakal gagal kalau ada yang udah daftar.')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada event ditemukan. <a href="{{ route('organizer.events.create') }}" class="text-blue-600 hover:text-blue-900">Buat event pertama kamu</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $events->links() }}
                    </div>
            </div>
        </div>
    </div>
@endsection
