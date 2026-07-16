@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-primary to-blue-600 text-white p-10 shadow-xl">
        <div class="absolute right-0 top-0 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="uppercase tracking-widest text-sm opacity-80 font-medium">
                    Tutor Dashboard
                </p>

                <h1 class="text-4xl md:text-5xl font-black mt-2">
                    Welcome Back,
                    {{ auth()->user()->name }}
                </h1>

                <p class="mt-4 text-blue-100 text-lg">
                    {{ __('Berikut ringkasan aktivitas mengajarmu hari ini.') }}
                </p>
            </div>

            <div class="hidden lg:flex">
                <div class="w-32 h-32 rounded-full bg-white/20 flex items-center justify-center text-6xl font-bold border-4 border-white/30 backdrop-blur-sm">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTICS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- Students --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 font-medium">Total Students</p>
                    <h2 class="text-4xl font-black mt-2 text-gray-800">
                        {{ $totalStudents }}
                    </h2>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Upcoming --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 font-medium">Upcoming Sessions</p>
                    <h2 class="text-4xl font-black mt-2 text-gray-800">
                        {{ $upcoming }}
                    </h2>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Completed --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 font-medium">Completed</p>
                    <h2 class="text-4xl font-black mt-2 text-gray-800">
                        {{ $completed }}
                    </h2>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Rating --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 font-medium">Rating</p>
                    <h2 class="text-4xl font-black mt-2 text-gray-800">
                        {{ number_format($tutor->rating ?? 5, 1) }}
                    </h2>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-500">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- BOOKING REQUESTS --}}
    <div class="bg-white rounded-3xl shadow-sm p-6 md:p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Booking Requests</h2>
                <p class="text-gray-500 text-sm mt-1">{{ __('Menunggu persetujuan') }}</p>
            </div>
            @if($pendingRequests->count() > 0)
                <span class="bg-amber-100 text-amber-700 px-4 py-1.5 rounded-full text-sm font-semibold flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $pendingRequests->count() }} New
                </span>
            @endif
        </div>

        @forelse($pendingRequests as $request)
            <div class="border border-gray-100 rounded-2xl p-5 mb-4 hover:border-gray-300 transition duration-200">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">
                            {{ $request->student->name }}
                        </h3>
                        <div class="flex items-center gap-2 text-gray-500 text-sm mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($request->session_date)->format('d M Y') }} • {{ \Carbon\Carbon::parse($request->session_time)->format('H:i') }}</span>
                        </div>

                        @if($request->note)
                            <div class="mt-3 bg-gray-50 rounded-xl p-3 text-sm text-gray-600 border border-gray-100">
                                <span class="font-medium">Note:</span> {{ $request->note }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <form action="{{ route('booking.reject', $request) }}" method="POST" class="w-1/2 md:w-auto">
                            @csrf
                            @method('PATCH')
                            <button class="w-full flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 transition font-medium">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reject
                            </button>
                        </form>

                        <form action="{{ route('booking.approve', $request) }}" method="POST" class="w-1/2 md:w-auto">
                            @csrf
                            @method('PATCH')
                            <button class="w-full flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white hover:bg-blue-600 transition shadow-sm font-medium">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                Approve
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-10 flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-700">{{ __('Tidak ada booking baru') }}</h3>
                <p class="text-gray-500 mt-1 text-sm">{{ __('Semua permintaan dari student sudah diproses.') }}</p>
            </div>
        @endforelse
    </div>

    {{-- TODAY + UPCOMING SESSIONS --}}
    <div class="grid lg:grid-cols-2 gap-8">
        
        {{-- TODAY'S SESSION --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Today's Sessions</h2>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('Jadwal mengajar hari ini') }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>

            @forelse($todaySessions as $session)
                <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-0">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr($session->student->name,0,1)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $session->student->name }}</h3>
                            <p class="text-gray-500 text-sm mt-0.5">
                                {{ \Carbon\Carbon::parse($session->session_time)->format('H:i') }} • {{ $session->duration }} {{ __('menit') }}
                            </p>
                        </div>
                    </div>
                    <div>
                        @switch($session->status)
                            @case('pending')
                                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold border border-amber-100">Pending</span>
                            @break
                            @case('approved')
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold border border-emerald-100">Approved</span>
                            @break
                            @case('completed')
                                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold border border-blue-100">Completed</span>
                            @break
                            @default
                                <span class="px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-semibold border border-red-100">Cancelled</span>
                        @endswitch
                    </div>
                </div>
            @empty
                <div class="py-10 flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">{{ __('Tidak ada sesi hari ini') }}</h3>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('Nikmati waktu luangmu atau siapkan materi esok hari.') }}</p>
                </div>
            @endforelse
        </div>

        {{-- UPCOMING SESSION --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Upcoming Schedule</h2>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('Jadwal beberapa hari ke depan') }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
            </div>

            @forelse($recentBookings as $booking)
                <div class="flex justify-between items-center py-4 border-b border-gray-100 last:border-0">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr($booking->student->name,0,1)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $booking->student->name }}</h3>
                            <p class="text-gray-500 text-sm mt-0.5">
                                {{ \Carbon\Carbon::parse($booking->session_date)->format('d M Y') }} • {{ \Carbon\Carbon::parse($booking->session_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="bg-gray-50 text-gray-600 px-3 py-1 rounded-lg text-sm font-medium border border-gray-100">
                            {{ $booking->duration }} min
                        </span>
                    </div>
                </div>
            @empty
                <div class="py-10 flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2.25m0 0v2.25m0-2.25h2.25m-2.25 0H9.75M2.25 12a9.75 9.75 0 1119.5 0 9.75 9.75 0 01-19.5 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">{{ __('Belum ada jadwal') }}</h3>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('Jadwal berikutnya akan muncul di sini.') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- BOTTOM SECTION --}}
    <div class="grid lg:grid-cols-3 gap-8">
        
        {{-- RECENT HISTORY --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Booking History</h2>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('Aktivitas pesanan terakhir') }}</p>
                </div>
                <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-sm font-semibold border border-blue-100">
                    {{ $recentBookings->count() }} Records
                </span>
            </div>

            @forelse($recentBookings as $booking)
                <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 px-2 -mx-2 rounded-xl transition">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-bold">
                            {{ strtoupper(substr($booking->student->name,0,1)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $booking->student->name }}</h3>
                            <p class="text-gray-500 text-sm mt-0.5">
                                {{ __('Sesi pada') }} {{ \Carbon\Carbon::parse($booking->session_date)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-700">
                            {{ \Carbon\Carbon::parse($booking->session_time)->format('H:i') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $booking->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="py-12 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.252 2.252 0 00-.1.661z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">{{ __('Belum ada history') }}</h3>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('Data riwayat booking akan tampil di sini.') }}</p>
                </div>
            @endforelse
        </div>

        {{-- QUICK ACTIONS & INSIGHT --}}
        <div class="space-y-6">
            
            {{-- Performance Card --}}
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.48 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <p class="uppercase tracking-widest text-xs font-semibold text-gray-300">Tutor Rating</p>
                    <div class="flex items-center gap-2 mt-2">
                        <h2 class="text-5xl font-black">{{ number_format($tutor->rating ?? 5, 1) }}</h2>
                        <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.48 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"/>
                        </svg>
                    </div>
                    <p class="mt-4 text-sm text-gray-300 leading-relaxed">
                        {{ __('Pertahankan kualitas mengajarmu agar semakin banyak student yang percaya dan melakukan booking.') }}
                    </p>
                </div>
            </div>

            {{-- Menus --}}
            <div class="bg-white rounded-3xl shadow-sm p-6">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('booking.index') }}" class="flex items-center gap-4 rounded-2xl border border-gray-100 p-4 hover:border-blue-200 hover:bg-blue-50/50 transition group">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-100 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 text-sm">{{ __('Semua Booking') }}</p>
                            <p class="text-xs text-gray-500">{{ __('Kelola jadwal & pesanan') }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    <a href="{{ route('chat.index') }}" class="flex items-center gap-4 rounded-2xl border border-gray-100 p-4 hover:border-blue-200 hover:bg-blue-50/50 transition group">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600 group-hover:bg-teal-100 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 text-sm">{{ __('Pesan Student') }}</p>
                            <p class="text-xs text-gray-500">{{ __('Balas chat terbaru') }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-teal-600 transition" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 rounded-2xl border border-gray-100 p-4 hover:border-blue-200 hover:bg-blue-50/50 transition group">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-100 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 text-sm">Edit Profile</p>
                            <p class="text-xs text-gray-500">{{ __('Perbarui info tutor') }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Motivation/Tips --}}
            <div class="bg-amber-50 border border-amber-100 rounded-3xl p-6 relative overflow-hidden">
                <div class="absolute -right-2 -top-2 text-amber-200/50">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 text-amber-700 mb-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.82 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.496 1.509 1.333 1.509 2.316V18" />
                        </svg>
                        <h3 class="font-bold text-sm">{{ __('Tips Hari Ini') }}</h3>
                    </div>
                    <p class="text-amber-800 text-sm leading-relaxed">
                        {{ __('Tutor yang merespon chat dengan cepat biasanya mendapatkan lebih banyak booking dan rating yang lebih tinggi.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection