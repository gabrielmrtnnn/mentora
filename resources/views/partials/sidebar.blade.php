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
                Dashboard
            </span>
        </a>

        <!-- STUDY ROOM -->
        <a href="{{ route('study-room') }}"
           class="group flex items-center px-3.5 py-3 rounded-xl transition-all
           {{ request()->routeIs('study-room*') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">

            <img src="{{ asset('icons/study-room.svg') }}"
                 class="w-5 h-5 shrink-0 object-contain transition-all {{ request()->routeIs('study-room*') ? '' : 'grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100' }}"
                 alt="Study Room">

            <span class="sidebar-text ml-3
                max-w-0 opacity-0 overflow-hidden
                whitespace-nowrap transition-all duration-300">
                Study Room
            </span>
        </a>

        <!-- TUTOR -->
        <a href="{{ route('tutor') }}"
           class="group flex items-center px-3.5 py-3 rounded-xl transition-all
           {{ request()->routeIs('tutor*') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">

            <img src="{{ asset('icons/tutor.svg') }}"
                 class="w-5 h-5 shrink-0 object-contain transition-all {{ request()->routeIs('tutor*') ? '' : 'grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100' }}"
                 alt="Tutor">

            <span class="sidebar-text ml-3
                max-w-0 opacity-0 overflow-hidden
                whitespace-nowrap transition-all duration-300">
                Tutor
            </span>
        </a>

        <!-- FORUM -->
        <a href="#"
           class="group flex items-center px-3.5 py-3 rounded-xl transition-all
           {{ request()->routeIs('forum*') ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">

            <img src="{{ asset('icons/forum.svg') }}"
                 class="w-5 h-5 shrink-0 object-contain transition-all {{ request()->routeIs('forum*') ? '' : 'grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100' }}"
                 alt="Forum">

            <span class="sidebar-text ml-3
                max-w-0 opacity-0 overflow-hidden
                whitespace-nowrap transition-all duration-300">
                Forum
            </span>
        </a>

    </nav>

    <!-- USER PROFILE -->
    @auth
    <div id="profileWrapper" class="mt-auto relative">

        <div id="profileButton"
            class="flex items-center bg-gray-50 p-2 rounded-xl hover:bg-gray-100 transition cursor-pointer border border-gray-100/80">

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
             class="hidden absolute bottom-16 left-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 p-2 space-y-1 z-50">

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 text-left px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition">
                     Logout
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
                Login / Register
            </span>
        </a>
    </div>
    @endguest

</aside>