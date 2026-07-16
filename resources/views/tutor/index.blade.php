@extends('layouts.app')

@section('content')

<div class="max-w-6xl">

    <!-- STATUS APPLY -->
    @auth
        @if(isset($application) && $application && $application->status === 'pending')
            <div class="bg-yellow-100 text-yellow-700 p-4 rounded-xl mb-6">
                ⏳ Pengajuan kamu sedang direview
            </div>
        @endif
    @endauth

    <!-- HERO -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

        <div>
            <p class="text-sm font-semibold text-blue-600 mb-2">
                Mentora • Tutor
            </p>

            <h1 class="text-5xl font-extrabold tracking-tight text-gray-900">
                Tutor
            </h1>

            <p class="text-gray-500 mt-2">
                Belajar langsung dengan tutor berpengalaman untuk mempersiapkan SNBT.
            </p>
        </div>

        {{-- Action Button --}}
        <div class="flex justify-end">

            @auth

                @if(auth()->user()->role === 'student')

                    <a href="{{ route('tutor.apply.page') }}"
                    class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-2xl font-semibold shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
                        Apply as Tutor
                    </a>

                @elseif(auth()->user()->role === 'tutor')

                    <div
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-green-50 text-green-700 font-semibold border border-green-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"/>
                        </svg>
                        Kamu sudah menjadi Tutor
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}"
                class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-2xl font-semibold shadow-sm hover:shadow-lg transition">
                    Login
                </a>
            @endauth
        </div>
    </div>

    @if (session('success_message'))
        <div
            class="flex items-center p-4 mb-4 text-sm text-green-700 bg-green-100 border-l-4 border-green-500 rounded-xl"
            role="alert">

            <svg
                class="w-5 h-5 shrink-0"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>

            <div class="ml-3 font-medium">
                {{ session('success_message') }}
            </div>

            <button
                type="button"
                onclick="this.parentElement.remove()"
                class="ml-auto text-green-700 hover:text-green-900">

                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>

            </button>

        </div>
    @endif
            
    
    <!-- SEARCH -->
    <div class="mb-5">
        <input
            type="text"
            id="searchInput"
            placeholder="Cari tutor..."
            class="w-full px-4 py-2 bg-white border border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary">
    </div>

    <!-- FILTER -->
    <div class="flex flex-wrap gap-3 mb-8">

        <button class="filter-btn px-4 py-2 bg-primary text-white font-semibold rounded-full"
            data-filter="all">
            Semua
        </button>

        <button class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-full"
            data-filter="tps">
            TPS
        </button>

        <button class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-full"
            data-filter="numerasi">
            Numerasi
        </button>

        <button class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-full"
            data-filter="literasi">
            Literasi
        </button>

    </div>

    <!-- LIST TUTOR -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse($tutors as $tutor)

            <div
                class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition tutor-card"
                data-name="{{ strtolower($tutor->user->name) }}"
                data-tps="{{ $tutor->tps ? 'true' : 'false' }}"
                data-literasi="{{ $tutor->literasi ? 'true' : 'false' }}"
                data-numerasi="{{ $tutor->numerasi ? 'true' : 'false' }}"
            >

                <!-- HEADER -->
                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 bg-primary text-white flex items-center justify-center rounded-full font-bold">
                        {{ strtoupper(substr($tutor->user->name, 0, 1)) }}
                    </div>

                    <div>
                        <h2 class="font-semibold text-lg">
                            {{ $tutor->user->name }}
                        </h2>

                        <p class="text-xs text-gray-400">
                            Tutor Mentora
                        </p>
                    </div>

                </div>

                <!-- SKILLS -->
                <div class="flex flex-wrap gap-2 mb-4">

                    @if($tutor->tps)
                        <span class="px-2 py-1 bg-blue-100 text-blue-600 text-xs rounded-full">
                            TPS
                        </span>
                    @endif

                    @if($tutor->literasi)
                        <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full">
                            Literasi
                        </span>
                    @endif

                    @if($tutor->numerasi)
                        <span class="px-2 py-1 bg-purple-100 text-purple-600 text-xs rounded-full">
                            Numerasi
                        </span>
                    @endif

                </div>

                <!-- RATING -->
                <p class="text-yellow-500 text-sm mb-2">
                    ⭐ {{ $tutor->rating }} ({{ $tutor->total_reviews }} review)
                </p>

                <!-- EMAIL -->
                <p class="text-sm text-gray-500 mb-3">
                    {{ $tutor->user->email }}
                </p>

                <!-- BIO -->
                <p class="text-xs text-gray-400 mb-4 line-clamp-3">
                    @if ($tutor->bio)
                    {{ $tutor->bio }}
                    @else
                    No Bio Yet
                    @endif
                </p>

                <!-- BUTTONS -->
                <div class="flex gap-2">

                    <a href="{{ route('tutor.show', $tutor->id) }}"
                        class="w-full block text-center border border-primary text-primary font-semibold py-2 rounded-xl hover:bg-blue-50 transition">
                        Lihat Profil
                    </a>

                    <a href="{{ route('booking.create', $tutor->id) }}" class="w-full block text-center bg-primary text-white font-semibold py-2 rounded-xl hover:opacity-90 transition">
                        Book Sekarang
                    </a>

                </div>

            </div>

        @empty

            <div class="col-span-3">
                <div class="bg-white rounded-2xl shadow p-10 text-center">
                    <h3 class="font-bold text-xl mb-2">
                        Belum Ada Tutor
                    </h3>

                    <p class="text-gray-500">
                        Tutor yang telah disetujui akan muncul di sini.
                    </p>
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const tutorCards = document.querySelectorAll('.tutor-card');
    const filterButtons = document.querySelectorAll('.filter-btn');

    let currentFilter = 'all';

    // SEARCH
    searchInput.addEventListener('input', applyFilter);

    // FILTER BUTTON
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            currentFilter = btn.dataset.filter;

            filterButtons.forEach(b => {
                b.classList.remove('bg-primary', 'text-white')
                b.classList.add('bg-gray-200', 'text-gray-700');});
            
            btn.classList.remove('bg-gray-200');
            btn.classList.add('bg-primary', 'text-white');

            applyFilter();
        });
    });

    function applyFilter() {

        const search = searchInput.value.toLowerCase();

        tutorCards.forEach(card => {

            const name = card.dataset.name;

            let matchFilter = true;

            if(currentFilter === 'tps') {
                matchFilter = card.dataset.tps === 'true';
            }

            if(currentFilter === 'literasi') {
                matchFilter = card.dataset.literasi === 'true';
            }

            if(currentFilter === 'numerasi') {
                matchFilter = card.dataset.numerasi === 'true';
            }

            const matchSearch = name.includes(search);

            card.style.display =
                (matchSearch && matchFilter)
                ? 'block'
                : 'none';
        });
    }

});
</script>