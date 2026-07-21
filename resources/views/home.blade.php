@extends('layouts.app')

@section('content')

<section id="topBanner"
class="
    fixed
    top-0
    left-0
    right-0
    z-50
    bg-gradient-to-r
    from-blue-600
    to-blue-700
    text-white
    px-6
    py-3
    shadow-md
    transition-all
    duration-300
    ml-0
    lg:ml-20">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">
        <div class="flex items-center gap-4">

            <button id="sidebarOpenBtn"
                type="button"
                class="lg:hidden p-2 bg-white rounded-xl shadow text-gray-600 hover:bg-gray-100 transition">
                <svg class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
                </svg>
            </button>

            <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4">
                <p class="text-lg md:text-xl font-bold tracking-wide">
                    🎯 SNBT 2026
                </p>

                <p class="text-sm md:text-base opacity-80">
                    {{ __('dimulai dalam') }}
                </p>
            </div>

        </div>

        <div class="flex items-center gap-3 text-center">

            <div class="bg-white text-primary px-3 py-2 rounded-lg w-16">
                <p id="days" class="text-xl font-bold">00</p>
                <span class="text-xs text-gray-500">{{ __('Hari') }}</span>
            </div>

            <div class="bg-white text-primary px-3 py-2 rounded-lg w-16">
                <p id="hours" class="text-xl font-bold">00</p>
                <span class="text-xs text-gray-500">{{ __('Jam') }}</span>
            </div>

            <div class="bg-white text-primary px-3 py-2 rounded-lg w-16">
                <p id="minutes" class="text-xl font-bold">00</p>
                <span class="text-xs text-gray-500">{{ __('Menit') }}</span>
            </div>

            <div class="bg-white text-primary px-3 py-2 rounded-lg w-16">
                <p id="seconds" class="text-xl font-bold transition-all duration-200"></p>
                <span class="text-xs text-gray-500">{{ __('Detik') }}</span>
            </div>

        </div>

        @guest
            <a href="{{ route('auth.redirect') }}" class="bg-accent text-black hover:bg-accent-hover text-sm font-semibold px-4 py-2 rounded-lg">
                {{ __('Mulai belajar') }}
            </a>
        @endguest

        @auth
            <a href="{{ route('study-room') }}" class="bg-accent text-black hover:bg-accent-hover text-sm font-semibold px-4 py-2 rounded-lg">
                {{ __('Mulai belajar') }}
            </a>
        @endauth
    </div>
</section>

<div class="mt-20 flex flex-col flex-1 min-h-0">

    <div class="flex gap-6 flex-1 min-h-0">

        <!-- FORUM FEED -->
        <div class="flex-1 overflow-y-auto no-scrollbar pr-2 flex flex-col gap-4 min-h-0 mt-6">

            <div>
                <h1 class="text-4xl font-bold mb-2">{{ __('Forum Belajar SNBT') }}</h1>
                <p class="text-textgray">{{ __('Lihat pertanyaan siswa lain 👀') }}</p>
            </div>

            <!-- SEARCH -->
            <a href={{ route('forum') }}#searchInput
                class="w-full px-4 py-2 bg-white text-gray-400 cursor-text border border-gray-200 rounded-2xl shadow-sm">
                {{ __('Cari diskusi...') }}
            </a>

            <!-- QUESTION CARDS -->
            @foreach($questions as $thread)

            <a href="{{ route('forum.show', $thread) }}"
            class="block bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition">

                <h2 class="font-semibold text-lg">
                    {{ $thread->title }}
                </h2>
                <p class="mb-3 text-gray-600 line-clamp-2">

                    {{ Str::limit(strip_tags($thread->body),150) }}

                </p>
                
                @guest
                <div class="blur-sm pointer-events-none select-none">
                @endguest


                @if($thread->images->isNotEmpty())
                    @php
                        $images = $thread->images;
                    @endphp

                    <div class="grid gap-2 mb-5 {{ $images->count() == 1 ? 'grid-cols-1' : 'grid-cols-2' }}">

                        @foreach($images->take(2) as $index => $image)

                            <div class="relative h-64 overflow-hidden rounded-2xl">

                                <img src="{{ $image->url }}"
                                    class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition"
                                    @click="lightboxImage='{{ $image->url }}'">

                                @if($images->count() > 2 && $index == 1)
                                    <div class="absolute inset-0 bg-black/45 flex items-center justify-center text-white text-3xl font-bold">
                                        +{{ $images->count() - 2 }}
                                    </div>
                                @endif

                            </div>

                        @endforeach

                    </div>
                @endif

                <div class="flex items-center gap-2 mt-2 text-sm text-gray-500">

                    <span>{{ $thread->replies_count }} {{ __('jawaban') }}</span>

                    <span>•</span>

                    <span>{{ $thread->created_at->diffForHumans() }}</span>

                </div>

                @guest
                </div>
                @endguest

            </a>

            @endforeach

        </div>


        <!-- RIGHT STATS -->
        <div class="w-64 flex flex-col gap-6 sticky top-[80px] h-fit self-start">

            <div class="bg-white p-3 rounded-2xl shadow-sm">
                <p class="font-semibold mb-3">{{ __('Waktu Belajar Mingguan') }}</p>

                <div class="flex items-end justify-between gap-2 h-24 w-full">
                    @php
                        $maxValue = max(array_column($weekly, 'total')) ?: 1;
                    @endphp

                    <div class="flex items-end gap-2">

                    @foreach($weekly as $day => $data)
                        @php
                            $height = $data['total'] > 0 ? ($data['total'] / $maxValue) * 50 : 5;
                        @endphp

                        <div class="relative group flex flex-col items-center w-6">

                            <!-- BAR -->
                            <div 
                                class="bg-primary w-full rounded transition-all duration-500"
                                style="height: {{ $height }}px;">
                            </div>

                            <!-- LABEL -->
                            <span class="text-[10px] mt-2 text-gray-400">
                                @php
                                    $hariMap = app()->getLocale() === 'en'
                                        ? ['Mon' => 'Mon', 'Tue' => 'Tue', 'Wed' => 'Wed', 'Thu' => 'Thu', 'Fri' => 'Fri', 'Sat' => 'Sat', 'Sun' => 'Sun']
                                        : ['Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab', 'Sun' => 'Min'];
                                @endphp
                                {{ $hariMap[\Carbon\Carbon::parse($day)->format('D')] }}
                            </span>

                            <!-- TOOLTIP -->
                            <div class="absolute bottom-full mb-2 hidden group-hover:block bg-white shadow-lg rounded-lg p-3 text-xs w-36 z-10">

                                <p class="font-semibold mb-1">
                                    {{ \Carbon\Carbon::parse($day)->format('d M') }}
                                </p>

                                <p>{{ __('Total') }}: {{ round($data['total'],1) }} {{ __('jam') }}</p>

                                <div class="mt-1 text-gray-500">
                                    TPS: {{ round($data['TPS'],1) }}{{ __('j') }} <br>
                                    Numerasi: {{ round($data['Numerasi'],1) }}{{ __('j') }} <br>
                                    Literasi: {{ round($data['Literasi'],1) }}{{ __('j') }}
                                </div>

                            </div>

                        </div>

                    @endforeach

                    </div>

                </div>
            </div>

            <div class="bg-white p-3 rounded-2xl shadow-sm">
                <p class="font-semibold mb-4">{{ __('Fokus Belajar') }}</p>

                <!-- TPS -->
                <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                        <span>TPS</span>
                        <span>{{ round($tps, 2) }} {{ __('jam') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 h-2 rounded-full">
                        <div class="bg-primary h-2 rounded-full"
                            style="width: {{ ($tps / $max) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Numerasi -->
                <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                        <span>Numerasi</span>
                        <span>{{ round($numerasi, 2) }} {{ __('jam') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 h-2 rounded-full">
                        <div class="bg-primary h-2 rounded-full"
                            style="width: {{ ($numerasi / $max) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Literasi -->
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Literasi</span>
                        <span>{{ round($literasi, 2) }} {{ __('jam') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 h-2 rounded-full">
                        <div class="bg-primary h-2 rounded-full"
                            style="width: {{ ($literasi / $max) * 100 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-primary text-white p-6 rounded-2xl text-center">
                <p class="text-lg">🔥 {{ __('Streak Belajar') }}</p>
                <p class="text-4xl font-bold">
                    {{ $streak }} {{ __('Hari') }}
                </p>
            </div>

        </div>

    </div>
</div>

@endsection

<script>
    const targetDate = new Date("May 5, 2026 07:00:00").getTime();

    const timer = setInterval(() => {
        const now = new Date().getTime();
        const distance = targetDate - now;

        const days = Math.floor(distance / (1000*60*60*24));
        const hours = Math.floor((distance % (1000*60*60*24))/(1000*60*60));
        const minutes = Math.floor((distance % (1000*60*60))/(1000*60));
        const seconds = Math.floor((distance % (1000*60))/1000);

        document.getElementById("countdown").innerHTML =
            days + "h " + hours + "j " + minutes + "m " + seconds + "d";
    }, 1000);
</script>
