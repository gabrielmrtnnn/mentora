@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="mb-8">
        <a href="{{ route('booking.index') }}"
           class="text-primary font-semibold hover:underline">
            ← Kembali ke My Booking
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        {{-- LEFT --}}
        <div>
            <div class="bg-white rounded-3xl shadow border p-8">

                <div class="w-28 h-28 rounded-full bg-primary text-white flex items-center justify-center text-4xl font-bold mx-auto">
                    {{ strtoupper(substr($booking->tutor->user->name,0,1)) }}
                </div>

                <h2 class="text-2xl font-bold text-center mt-5">
                    {{ $booking->tutor->user->name }}
                </h2>

                <p class="text-center text-gray-500">
                    Tutor Mentora
                </p>

                <div class="mt-6 flex justify-center">

                    @switch($booking->status)

                        @case('pending')

                            <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                Pending
                            </span>

                        @break

                        @case('confirmed')
                            <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 font-semibold">
                                Confirmed
                            </span>
                        @break

                        @case('completed')
                            <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold">
                                Completed
                            </span>
                        @break

                        @default
                            <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 font-semibold">
                                Cancelled
                            </span>
                    @endswitch
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow border p-8">
                <h1 class="text-3xl font-bold mb-8">
                    Booking Detail
                </h1>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-gray-500 text-sm">
                            Tanggal
                        </p>
                        <h2 class="font-bold text-lg mt-2">
                            {{ \Carbon\Carbon::parse($booking->session_date)->format('d F Y') }}
                        </h2>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-gray-500 text-sm">
                            Jam
                        </p>

                        <h2 class="font-bold text-lg mt-2">
                            {{ $booking->session_time }}
                        </h2>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-gray-500 text-sm">
                            Durasi
                        </p>

                        <h2 class="font-bold text-lg mt-2">
                            {{ $booking->duration }} menit
                        </h2>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-gray-500 text-sm">
                            Status
                        </p>

                        <h2 class="font-bold text-lg mt-2 capitalize">
                            {{ $booking->status }}
                        </h2>
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="font-bold text-lg mb-3">
                        Catatan
                    </h2>

                    <div class="bg-gray-50 rounded-2xl p-5">
                        {{ $booking->note ?: 'Tidak ada catatan.' }}
                    </div>
                </div>

                <div class="mt-10 flex gap-4">
                    <a href="{{ route('chat.start',$booking->tutor->user->id) }}"
                        class="px-6 py-3 rounded-xl border border-primary text-primary font-semibold">
                        Chat Tutor
                    </a>

                    @if($booking->status=='confirmed')
                        <button class="px-6 py-3 rounded-xl bg-primary text-white font-semibold">
                            Join Meeting
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection