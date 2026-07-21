<style>
    /* Memaksa submenu tertutup rapat (tinggi 0 dan margin 0) 
      saat sidebar berada dalam mode default/tertutup (class w-20).
      Aturan ini akan menimpa (override) state dari JavaScript.
    */
    aside.w-20 #tutorSubMenu {
        max-height: 0px !important;
        margin-top: 0px !important;
        opacity: 0 !important;
        pointer-events: none !important;
        overflow: hidden !important;
    }
</style>

<aside id="sidebar"
    class="fixed top-0 left-0 h-full w-20 bg-white shadow-lg
           flex flex-col p-4 z-[70]
           transition-all duration-300 overflow-hidden">

    <!-- LOGO -->
    <div class="flex items-center px-2 mt-2 mb-8 pt-4">
        <img src="{{ asset('images/logo.png') }}"
             alt="Mentora Logo"
             class="h-8 w-8 shrink-0">

        <span class="sidebar-text
            max-w-0 opacity-0 overflow-hidden
            whitespace-nowrap transition-all duration-300
            text-2xl font-bold text-primary ml-3">
            Mentora
        </span>
    </div>

    <!-- NAVIGATION -->
    <nav class="flex flex-col gap-4" aria-label="Main Navigation">

        <!-- DASHBOARD -->
        <a href="{{ route('home') }}"
           class="group flex items-center px-3.5 py-3 rounded-xl transition-all
           {{ request()->routeIs('home') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">

            <img src="{{ asset('icons/dashboard.svg') }}"
                 class="w-5 h-5 shrink-0 object-contain transition-all {{ request()->routeIs('home') ? '' : 'grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100' }}"
                 alt="Dashboard">

            <span class="sidebar-text ml-3
                max-w-0 opacity-0 overflow-hidden
                whitespace-nowrap transition-all duration-300">
                {{ __('Beranda') }}
            </span>
        </a>

        <!-- STUDY ROOM -->
        <a href="{{ route('study-room') }}"
           class="group flex items-center px-3.5 py-3 rounded-xl transition-all
           {{ request()->routeIs('study-room*') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">

            <img src="{{ asset('icons/study-room.svg') }}"
                 class="w-5 h-5 shrink-0 object-contain transition-all {{ request()->routeIs('study-room*') ? '' : 'grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100' }}"
                 alt="{{ __('Ruang Belajar') }}">

            <span class="sidebar-text ml-3
                max-w-0 opacity-0 overflow-hidden
                whitespace-nowrap transition-all duration-300">
                {{ __('Ruang Belajar') }}
            </span>
        </a>

        <!-- TUTOR -->
        <div class="flex flex-col">
            <button id="tutorMenuToggle"
               class="group w-full flex items-center justify-between px-3.5 py-3 rounded-xl transition-all
               {{ request()->routeIs('tutor*', 'booking.index', 'booking.create') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">

                <div class="flex items-center">
                    <img src="{{ asset('icons/tutor.svg') }}"
                         class="w-5 h-5 shrink-0 object-contain transition-all {{ request()->routeIs('tutor*', 'booking.index', 'booking.create') ? '' : 'grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100' }}"
                         alt="Tutor">

                    <span class="sidebar-text ml-3
                        max-w-0 opacity-0 overflow-hidden
                        whitespace-nowrap transition-all duration-300">
                        {{ __('Tutor') }}
                    </span>
                </div>

                <svg id="tutorArrow" class="sidebar-text max-w-0 opacity-0 overflow-hidden w-4 h-4 transition-transform duration-300 {{ request()->routeIs('tutor*', 'booking.index', 'booking.create') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div id="tutorSubMenu"
                 class="overflow-hidden transition-all duration-300 flex-col gap-1
                 {{ request()->routeIs('tutor*', 'booking.index') ? 'flex max-h-40 mt-1' : 'flex max-h-0 mt-0' }}">

                    @if (!auth()->check() || auth()->user()->role != 'tutor')
                        <a href="{{ route('tutor') }}"
                        class="group flex items-center px-3.5 py-2.5 rounded-xl transition-all
                        {{ request()->routeIs('tutor') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            
                            <div class="w-5 h-5 shrink-0"></div>
        
                            <span class="sidebar-text ml-3 text-sm
                                max-w-0 opacity-0 overflow-hidden
                                whitespace-nowrap transition-all duration-300">
                                {{ __('Cari Tutor') }}
                            </span>
                        </a>
                        
                        @if (!auth()->check() || auth()->user()->role != 'admin')
                            <a href="{{ route('booking.index') }}"
                            class="group flex items-center px-3.5 py-2.5 rounded-xl transition-all
                            {{ request()->routeIs('booking.index') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                                
                                <div class="w-5 h-5 shrink-0"></div>
            
                                <span class="sidebar-text ml-3 text-sm
                                    max-w-0 opacity-0 overflow-hidden
                                    whitespace-nowrap transition-all duration-300">
                                    {{ __('Booking Saya') }}
                                </span>
                            </a>
                        @endif
                    @endif

                @auth
                    @if(auth()->user()->role=='tutor')
                    <a href="{{ route('tutor.dashboard') }}"
                       class="group flex items-center px-3.5 py-2.5 rounded-xl transition-all
                       {{ request()->routeIs('tutor.dashboard*') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                        
                        <div class="w-5 h-5 shrink-0"></div>

                        <span class="sidebar-text ml-3 text-sm
                            max-w-0 opacity-0 overflow-hidden
                            whitespace-nowrap transition-all duration-300">
                            {{ __('Dashboard Tutor') }}
                        </span>
                    </a>
                    @endif

                    @if (auth()->user()->role=='admin')
                        <a href="{{ route('admin.tutor') }}"
                       class="group flex items-center px-3.5 py-2.5 rounded-xl transition-all
                       {{ request()->routeIs('admin.tutor-applications') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                        
                        <div class="w-5 h-5 shrink-0"></div>

                        <span class="sidebar-text ml-3 text-sm
                            max-w-0 opacity-0 overflow-hidden
                            whitespace-nowrap transition-all duration-300">
                            {{ __('Pengajuan Tutor') }}
                        </span>
                    </a>
                    @endif
                @endauth
            </div>
        </div>
    
        <!-- FORUM -->
        <a href="{{ route('forum') }}"
           class="group flex items-center px-3.5 py-3 rounded-xl transition-all
           {{ request()->routeIs('forum*') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">

            <img src="{{ asset('icons/forum.svg') }}"
                 class="w-5 h-5 shrink-0 object-contain transition-all {{ request()->routeIs('forum*') ? '' : 'grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100' }}"
                 alt="Forum">

            <span class="sidebar-text ml-3
                max-w-0 opacity-0 overflow-hidden
                whitespace-nowrap transition-all duration-300">
                {{ __('Forum') }}
            </span>
        </a>

        @auth
        @if(auth()->user()->isAdmin())
            <!-- ADMIN: REPORT FORUM -->
            <a href="{{ route('admin.reports') }}"
               class="group flex items-center px-3.5 py-3 rounded-xl transition
               {{ request()->routeIs('admin.reports') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">

                <span class="w-5 h-5 shrink-0 flex items-center justify-center">🚩</span>

                <span class="sidebar-text ml-3
                    max-w-0 opacity-0 overflow-hidden
                    whitespace-nowrap transition-all duration-300">
                    {{ __('Report Forum') }}
                </span>
            </a>
        @endif
        @endauth

    </nav>

    <!-- LANGUAGE SWITCH -->
    <div class="flex items-center px-3.5 py-3 rounded-xl text-gray-500 mt-2">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
        </svg>

        <div class="sidebar-text ml-3
            max-w-0 opacity-0 overflow-hidden
            whitespace-nowrap transition-all duration-300
            flex items-center gap-1.5 text-sm font-semibold">
            <a href="{{ route('language.switch', 'id') }}"
               class="{{ app()->getLocale() === 'id' ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
                ID
            </a>
            <span class="text-gray-300">|</span>
            <a href="{{ route('language.switch', 'en') }}"
               class="{{ app()->getLocale() === 'en' ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
                EN
            </a>
        </div>
    </div>

    <!-- USER PROFILE -->
    @auth
    <div id="profileWrapper" class="mt-auto relative">

        <div id="profileButton"
            class="flex items-center p-2 transition cursor-pointer">

            <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0 shadow-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="profile-text ml-3
                        max-w-0 opacity-0 overflow-hidden
                        whitespace-nowrap transition-all duration-300
                        flex flex-col text-left">

                <span class="font-semibold text-sm text-gray-800 leading-tight">
                    {{ auth()->user()->name }}
                </span>

                <span class="text-xs text-gray-400 mt-0.5">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

        </div>

        <div id="dropdownMenu"
             class="hidden absolute bottom-14 left-2 w-48 bg-white rounded-2xl border-2 border-gray-100 p-2 space-y-1 z-50">

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                {{ __('Profil') }}
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 text-left px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition">
                    {{ __('Keluar') }}
                </button>
            </form>

        </div>

    </div>
    @endauth

    <!-- GUEST -->
    @guest
    <div class="mt-auto">
        <a href="{{ route('auth.redirect') }}"
           class="flex items-center px-3.5 py-3 rounded-xl bg-primary text-white hover:bg-primary/90 transition shadow-sm">

            <img src="{{ asset('icons/profile.svg') }}"
                 class="w-5 h-5 shrink-0 object-contain"
                 alt="Login">

            <span class="sidebar-text ml-3
                        max-w-0 opacity-0 overflow-hidden
                        whitespace-nowrap transition-all duration-300
                        font-semibold text-sm">
                {{ __('Masuk / Daftar') }}
            </span>
        </a>
    </div>
    @endguest

</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('tutorMenuToggle');
        const subMenu = document.getElementById('tutorSubMenu');
        const arrow = document.getElementById('tutorArrow');

        if(toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault(); 
                
                if(subMenu.classList.contains('max-h-0')) {
                    // Cukup atur tinggi (height) saja, tidak perlu sentuh opacity
                    subMenu.classList.remove('max-h-0', 'mt-0');
                    subMenu.classList.add('max-h-40', 'mt-1');
                    if(arrow) arrow.classList.add('rotate-180');
                } else {
                    subMenu.classList.add('max-h-0', 'mt-0');
                    subMenu.classList.remove('max-h-40', 'mt-1');
                    if(arrow) arrow.classList.remove('rotate-180');
                }
            });
        }
    });
</script>