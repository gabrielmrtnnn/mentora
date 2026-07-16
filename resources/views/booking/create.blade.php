@extends('layouts.app')

@section('content')

{{-- Hapus h-full di sini agar tinggi mengikuti konten --}}
<div class="flex flex-col pb-10">

    <!-- BACK -->
    <div class="mb-2">
        <a href="{{ route('tutor') }}"
           class="text-primary text-sm font-medium hover:underline">
            ← {{ __('Kembali ke daftar tutor') }}
        </a>
    </div>

    {{-- Card Wrapper: Biarkan flex default (items-stretch) agar kiri & kanan sama tinggi --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex">

        <div class="w-72 border-r bg-white flex flex-col flex-shrink-0">

            <div class="p-5 border-b bg-white">
                <div class="flex flex-col items-center group">
                    <div
                        class="w-20 h-20 rounded-full bg-primary text-white flex items-center justify-center text-3xl font-bold shadow-lg shadow-primary/20 transition-transform duration-300 group-hover:scale-105">
                        {{ strtoupper(substr($tutor->user->name, 0, 1)) }}
                    </div>

                    <h2 class="mt-4 text-xl font-bold text-gray-900">
                        {{ $tutor->user->name }}
                    </h2>
                    <p class="text-gray-500 font-medium">
                        {{ __('Tutor Mentora') }}
                    </p>
                </div>

                <div class="flex flex-wrap justify-center gap-2 mt-6">
                    @if($tutor->tps)
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                            TPS
                        </span>
                    @endif
                    @if($tutor->literasi)
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                            Literasi
                        </span>
                    @endif
                    @if($tutor->numerasi)
                        <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-semibold">
                            Numerasi
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6 space-y-5">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <p class="text-gray-500 text-sm font-medium">Rating</p>
                    <h3 class="text-2xl font-bold text-yellow-500 mt-2 flex items-center gap-1">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        {{ $tutor->rating }}
                    </h3>
                </div>
            </div>

        </div>

        {{-- Area Formulir: Tidak ada class overflow lagi, biarkan meninggi secara alami --}}
        <div class="flex-1 bg-white">
            <div class="max-w-4xl mx-auto p-8">

                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                    Booking Session
                </h1>
                <p class="text-gray-500 mt-3 mb-10 text-lg">
                    {{ __('Pilih jadwal belajar yang sesuai bersama tutor pilihanmu.') }}
                </p>

                <form action="{{ route('booking.store', $tutor) }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-3 group-focus-within:text-primary transition-colors">
                            {{ __('Tanggal Belajar') }}
                        </label>
                        <input type="date"
                            name="session_date"
                            required
                            value="{{ old('session_date') }}"
                            min="{{ now()->format('Y-m-d') }}"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-200 outline-none">
                        @error('session_date')
                            <p class="text-red-500 mt-2 font-medium text-sm">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-3 group-focus-within:text-primary transition-colors">
                            {{ __('Jam Mulai') }}
                        </label>
                        <input type="time"
                            name="session_time"
                            required
                            value="{{ old('session_time') }}"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-200 outline-none">
                        @error('session_time')
                            <p class="text-red-500 mt-2 font-medium text-sm">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-4">
                            {{ __('Durasi Sesi') }}
                        </label>

                        <div class="grid grid-cols-3 gap-4">

                            @foreach([60, 90, 120] as $duration)

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="duration"
                                        value="{{ $duration }}"
                                        class="peer sr-only"
                                        {{ old('duration', 60) == $duration ? 'checked' : '' }}>

                                    <div
                                        class="rounded-2xl border-2 border-gray-200 bg-white py-5 text-center font-semibold transition-all duration-200
                                            hover:border-primary hover:bg-primary/5
                                            peer-checked:bg-primary
                                            peer-checked:border-primary
                                            peer-checked:text-white
                                            peer-checked:shadow-lg
                                            peer-checked:shadow-primary/20">

                                        {{ $duration }} {{ __('Menit') }}

                                    </div>

                                </label>

                            @endforeach

                        </div>

                    </div>

                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-3 group-focus-within:text-primary transition-colors">
                            {{ __('Catatan Khusus') }} <span class="text-gray-400 font-normal ml-1">({{ __('Opsional') }})</span>
                        </label>
                        <textarea rows="3"
                            name="note"
                            placeholder="{{ __('Contoh: Saya ingin fokus belajar TPS Penalaran Umum hari ini.') }}"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 resize-y focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-200 outline-none">{{ old('note') }}</textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-primary text-white py-4 rounded-2xl text-lg font-bold shadow-lg shadow-primary/30 hover:shadow-xl hover:bg-opacity-90 active:scale-[0.98] transition-all duration-200 outline-none focus:ring-4 focus:ring-primary/30">
                            {{ __('Konfirmasi Booking') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection