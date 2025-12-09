@extends('layouts.dashboard')

@section('page-title', 'Profile Settings')
@section('page-description', 'Kelola pengaturan akun dan preferensi kamu')

@section('sidebar')
    @if(auth()->user()->isAdmin())
        @include('admin.partials.sidebar')
    @elseif(auth()->user()->isOrganizer())
        @include('organizer.partials.sidebar')
    @else
        @include('participant.partials.sidebar')
    @endif
@endsection

@section('content')
    <div class="max-w-7xl space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
    </div>
@endsection
