@extends('layouts.app')

@section('content')

<style>
    [x-cloak] {
        display: none !important;
    }

    @keyframes shake-subtle {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-4px);
        }

        75% {
            transform: translateX(4px);
        }
    }

    .shake-subtle {
        animation: shake-subtle .2s ease-in-out 2;
    }
</style>

<div id="studyRoomContainer"
    class="w-full pb-8"
    x-data="{
        openCreateModal:false,
        activeTab:'{{ session('active_tab') ?? 'solo' }}'
    }">

    @include('study-room.components.header')

    @if(session('success'))

        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl font-bold flex items-center gap-2">

            {{ session('success') }}

        </div>

    @endif

    @include('study-room.solo.index')

    @include('study-room.group.index')

</div>

@include('study-room.modals.session-modal')

@include('study-room.modals.warning-modal')

<audio id="alarmSound" preload="auto">
    <source src="{{ asset('sound/bell.mp3') }}" type="audio/mpeg">
</audio>

@endsection

@push('scripts')
    @vite('resources/js/study-room.js')
@endpush