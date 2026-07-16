@php
use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col">
    <div class="mb-8">
        <p class="text-sm font-semibold text-primary">
            Mentora • Booking
        </p>

        <div class="flex justify-between items-end mt-2">
            <div>
                <h1 class="text-5xl font-extrabold text-gray-900">
                    My Booking
                </h1>
                <p class="text-gray-500 mt-2">
                    {{ __('Semua sesi belajar yang pernah kamu booking.') }}
                </p>
            </div>

            <a href="{{ route('tutor') }}"
               class="bg-primary text-white px-6 py-3 rounded-2xl font-semibold hover:opacity-90 transition shadow-sm hover:shadow-md">
                + {{ __('Booking Baru') }}
            </a>
        </div>
    </div>

    @forelse($bookings as $booking)
        @php
            $start = Carbon::parse($booking->session_date.' '.$booking->session_time);
            $end = $start->copy()->addMinutes($booking->duration);
        @endphp
        
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg transition mb-6 overflow-hidden min-h-[340px] h-auto">
            <div class="flex flex-col lg:flex-row h-full">
                <div class="flex-1 p-8 flex flex-col">
                    <div class="flex items-start gap-5">
                        <div class="w-20 h-20 rounded-full bg-primary text-white flex items-center justify-center text-2xl font-bold shrink-0">
                            {{ strtoupper(substr($booking->tutor->user->name,0,1)) }}
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">
                                        {{ $booking->tutor->user->name }}
                                    </h2>
                                    <p class="text-gray-500 mt-1">{{ __('Tutor Mentora') }}</p>
                                </div>

                                {{-- STATUS & RATE BUTTON WRAPPER --}}
                                <div class="flex flex-col items-end gap-3">
                                    @if($booking->status == 'pending')
                                        <span class="px-5 py-2 rounded-full bg-yellow-100 text-yellow-700 font-semibold text-sm">
                                            Pending
                                        </span>
                                    @elseif($booking->status == 'approved')
                                        <span class="px-5 py-2 rounded-full bg-green-100 text-green-700 font-semibold text-sm">
                                            Approved
                                        </span>
                                    @elseif($booking->status == 'completed')
                                        <span class="px-5 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold text-sm">
                                            Completed
                                        </span>
                                        
                                        {{-- RATE TUTOR BUTTON --}}
                                        @if(!$booking->review)
                                            <button type="button" 
                                                    onclick="openReviewModal('{{ $booking->id }}', '{{ $booking->tutor->user->name }}')"
                                                    class="flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 text-amber-600 rounded-xl hover:bg-amber-100 hover:scale-105 transition shadow-sm text-sm font-bold">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                </svg>
                                                Rate Tutor
                                            </button>
                                        @endif
                                    @else
                                        <span class="px-5 py-2 rounded-full bg-red-100 text-red-700 font-semibold text-sm">
                                            Rejected
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                                <div class="bg-gray-50 rounded-2xl p-5">
                                    <p class="text-gray-500 text-sm">{{ __('Tanggal') }}</p>
                                    <p class="font-bold text-lg mt-1">
                                        {{ \Carbon\Carbon::parse($booking->session_date)->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-5">
                                    <p class="text-gray-500 text-sm">{{ __('Jam') }}</p>
                                    <p class="font-bold text-lg mt-1">{{ $booking->session_time }}</p>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-5">
                                    <p class="text-gray-500 text-sm">{{ __('Durasi') }}</p>
                                    <p class="font-bold text-lg mt-1">{{ $booking->duration }} {{ __('menit') }}</p>
                                </div>
                            </div>

                            @if($booking->note)
                                <div class="mt-6 bg-gray-50 rounded-2xl p-5 border border-gray-100">
                                    <p class="text-sm font-semibold text-gray-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        {{ __('Catatan') }}
                                    </p>
                                    <p class="text-gray-700 break-words whitespace-pre-wrap">{{ $booking->note }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:w-72 bg-primary flex flex-col justify-between p-8 relative overflow-hidden">
                    {{-- Dekorasi pattern di background sidebar --}}
                    <div class="absolute right-0 top-0 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <p class="text-white/70 text-sm font-medium">{{ __('Dibuat') }}</p>
                        <p class="text-white font-bold mt-1 text-lg">{{ $booking->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="space-y-3 mt-8 relative z-10">
                        <a href="{{ route('chat.start', $booking->tutor->id) }}"
                           class="w-full flex justify-center items-center gap-2 bg-white/10 text-white py-3.5 rounded-2xl font-bold hover:bg-white hover:text-primary transition border border-white/20">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                            </svg>
                            {{ __('Chat Tutor') }}
                        </a>

                        <div class="meeting-action-container" 
                             data-start="{{ $start->toIso8601String() }}" 
                             data-end="{{ $end->toIso8601String() }}">
                             
                            @if($booking->status == "approved")
                                <a href="{{ route('meeting', $booking) }}"
                                   class="join-button hidden w-full flex justify-center items-center gap-2 bg-white text-primary py-3.5 rounded-2xl font-bold transition hover:bg-gray-100 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    Join Meeting
                                </a>

                                <button class="countdown-button w-full bg-black/20 text-white/80 py-3.5 rounded-2xl cursor-not-allowed font-semibold text-sm backdrop-blur-sm" disabled>
                                    Preparing Meeting...
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="flex-1 flex items-center justify-center">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 w-full max-w-2xl mx-auto py-20 text-center">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mx-auto mb-6">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">{{ __('Belum ada booking') }}</h2>
                <p class="text-gray-500 mt-3 text-lg">{{ __('Cari tutor favoritmu dan mulai sesi belajar pertama.') }}</p>
                <a href="{{ route('tutor') }}" class="inline-flex items-center gap-2 mt-8 bg-primary text-white px-8 py-4 rounded-2xl font-bold hover:bg-blue-600 hover:shadow-lg transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    {{ __('Cari Tutor') }}
                </a>
            </div>
        </div>
    @endforelse
</div>

<script>
    function updateMeetingButtons() {
        const now = Date.now();
        const containers = document.querySelectorAll('.meeting-action-container');

        containers.forEach(container => {
            const startStr = container.dataset.start;
            const endStr = container.dataset.end;

            if (!startStr || !endStr) return;

            const startTime = new Date(startStr).getTime();
            const endTime = new Date(endStr).getTime();

            const joinBtn = container.querySelector('.join-button');
            const countdownBtn = container.querySelector('.countdown-button');

            if (!joinBtn || !countdownBtn) return;

            const diff = startTime - now;

            if (diff > 30 * 60 * 1000) {
                // Lebih dari 30 menit sebelum meeting
                const h = Math.floor(diff / 3600000);
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);
                countdownBtn.innerHTML = `Opens in ${h}h ${m}m ${s}s`;
                countdownBtn.classList.remove('hidden');
                joinBtn.classList.add('hidden');
            } else if (now < endTime) {
                // Dalam rentang 30 menit sebelum mulai hingga waktu selesai
                countdownBtn.classList.add("hidden");
                joinBtn.classList.remove("hidden");
            } else {
                // Meeting sudah selesai
                countdownBtn.innerHTML = "Meeting Ended";
                countdownBtn.classList.remove("bg-black/20", "text-white/80", "cursor-not-allowed");
                countdownBtn.classList.add("bg-white/20", "text-white");
                countdownBtn.classList.remove("hidden");
                joinBtn.classList.add("hidden");
            }
        });
    }

    // Script untuk membuka Modal Review
    function openReviewModal(bookingId, tutorName) {
        document.getElementById('modalBookingId').value = bookingId;
        document.getElementById('modalTutorName').innerText = tutorName;
        document.getElementById('reviewModal').classList.remove('hidden');
    }

    // Script untuk menutup Modal Review
    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
        document.getElementById('reviewForm').reset();
    }

    updateMeetingButtons();
    setInterval(updateMeetingButtons, 1000);
</script>
@endsection

{{-- MODAL REVIEW POPUP --}}
<div id="reviewModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                
                <form id="reviewForm" action="{{ route('review.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" id="modalBookingId">
                    
                    <div class="bg-white px-8 pb-4 pt-8">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-2xl font-bold text-gray-900" id="modal-title">Rate Tutor</h3>
                            <button type="button" onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600 transition">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <p class="text-gray-500 text-sm mb-6">
                            {{ __('Bagaimana pengalaman belajarmu dengan') }} <span id="modalTutorName" class="font-bold text-gray-800">Tutor</span>?
                        </p>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Penilaian') }}</label>
                            <div class="star-rating text-4xl cursor-pointer">
                                <input type="radio" id="star5" name="rating" value="5" class="hidden" required />
                                <label for="star5" class="text-gray-300 transition hover:scale-110">★</label>
                                
                                <input type="radio" id="star4" name="rating" value="4" class="hidden" />
                                <label for="star4" class="text-gray-300 transition hover:scale-110">★</label>
                                
                                <input type="radio" id="star3" name="rating" value="3" class="hidden" />
                                <label for="star3" class="text-gray-300 transition hover:scale-110">★</label>
                                
                                <input type="radio" id="star2" name="rating" value="2" class="hidden" />
                                <label for="star2" class="text-gray-300 transition hover:scale-110">★</label>
                                
                                <input type="radio" id="star1" name="rating" value="1" class="hidden" />
                                <label for="star1" class="text-gray-300 transition hover:scale-110">★</label>
                            </div>
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Ulasan (Opsional)') }}</label>
                            <textarea id="comment" name="comment" rows="4" 
                                      class="block w-full rounded-2xl border-gray-200 shadow-sm focus:border-primary focus:ring-primary sm:text-sm p-4 border bg-gray-50 focus:bg-white transition" 
                                      placeholder="{{ __('Ceritakan pengalamanmu belajar di sesi ini...') }}"></textarea>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50/50 border-t border-gray-100 px-8 py-5 flex justify-end gap-3 rounded-b-3xl">
                        <button type="button" onclick="closeReviewModal()" 
                                class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition">
                            {{ __('Batal') }}
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-primary text-white rounded-xl hover:bg-blue-600 font-bold transition shadow-sm hover:shadow-md">
                            {{ __('Kirim Review') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- CSS untuk efek hover & klik bintang --}}
<style>
    .star-rating {
        display: flex;
        flex-direction: row-reverse; 
        justify-content: flex-end;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #fbbf24;
    }
</style>