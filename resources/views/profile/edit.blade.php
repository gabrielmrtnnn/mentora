@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center text-white text-xl font-bold">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-xl font-bold text-textMain">
                {{ auth()->user()->name }}
            </h1>
            <p class="text-sm text-textSub">
                {{ auth()->user()->email }}
            </p>
        </div>
    </div>

    <div class="bg-card rounded-2xl shadow-sm p-6">
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- KHUSUS TUTOR: UPDATE KEAHLIAN --}}
    @if(auth()->user()->role == 'tutor')
    <div class="bg-card rounded-2xl shadow-sm p-6">
        @include('profile.partials.update-skills-form')
    </div>
    <div class="bg-card rounded-2xl shadow-sm p-6">
        @include('profile.partials.update-bio-form')
    </div>
    @endif

    <div class="bg-card rounded-2xl shadow-sm p-6">
        @include('profile.partials.update-password-form')
    </div>

    <div class="bg-card rounded-2xl shadow-sm p-6">
        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection