<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Mentora</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background h-full overflow-hidden">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-lg hidden md:flex flex-col p-6">
        <h1 class="text-2xl font-bold text-primary mb-10">Mentora</h1>

        <nav class="flex flex-col gap-4">
            <a href="{{ url('/') }}" class="bg-primary/10 text-primary px-4 py-3 rounded-lg font-semibold">
                Dashboard
            </a>
            <a href="#" class="px-4 py-3 rounded-lg hover:bg-gray-100">
                Study Room
            </a>
            <a href="#" class="px-4 py-3 rounded-lg hover:bg-gray-100">
                Tutor
            </a>
            <a href="#" class="px-4 py-3 rounded-lg hover:bg-gray-100">
                Forum
            </a>
        </nav>

        @auth
        <div id="profileWrapper" class="mt-auto relative">

            <!-- BUTTON -->
            <div id="profileButton"
                class="flex items-center gap-3 bg-gray-100 p-3 rounded-xl hover:bg-gray-200 transition cursor-pointer">

                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="flex flex-col text-left">
                    <span class="font-semibold text-sm">
                        {{ auth()->user()->name }}
                    </span>
                    <span class="text-xs text-gray-500">
                        Account
                    </span>
                </div>
            </div>

            <!-- DROPDOWN -->
            <div id="dropdownMenu"
                class="hidden absolute bottom-16 left-0 w-full bg-white rounded-xl shadow-lg p-2 space-y-1">

                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 rounded-lg hover:bg-gray-100">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg hover:bg-red-50 text-red-500">
                        Logout
                    </button>
                </form>

            </div>

        </div>
        @endauth

        @guest
            <div class="mt-auto">
                <a href="{{ route('auth.redirect') }}" 
                class="block w-full text-center bg-primary text-white py-3 rounded-xl">
                    Login / Register
                </a>
            </div>
        @endguest
    </aside>

    <!-- RIGHT AREA -->
    <div class="flex-1 flex flex-col h-full">

        <main class="flex-1 overflow-y-auto p-6 md:p-10">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>

<script>
    const wrapper = document.getElementById('profileWrapper');
    const button = document.getElementById('profileButton');
    const dropdown = document.getElementById('dropdownMenu');

    // buka saat klik
    button.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
    });

    // close kalau mouse keluar dari wrapper (gabungan button + dropdown)
    wrapper.addEventListener('mouseleave', () => {
        dropdown.classList.add('hidden');
    });
</script>