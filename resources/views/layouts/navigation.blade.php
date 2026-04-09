<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <span class="text-xl font-bold text-primary">Mentora 🚀</span>
                    </a>
                </div>

                <!-- Nav Links -->
                <div class="hidden sm:flex space-x-8 sm:ms-10">
                    <a href="/" class="text-gray-700 hover:text-primary font-medium">
                        Home
                    </a>

                    <a href="/forum" class="text-gray-700 hover:text-primary font-medium">
                        Forum
                    </a>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="font-semibold text-sm">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm text-red-500 hover:underline">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="/login" class="text-primary font-semibold">
                        Login
                    </a>
                @endauth
            </div>

            <!-- HAMBURGER -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="sm:hidden px-4 pb-4 space-y-2">

        <a href="/" class="block text-gray-700">Home</a>
        <a href="/forum" class="block text-gray-700">Forum</a>

        <hr>

        @auth
            <div>
                <p class="font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500 mt-2">Logout</button>
            </form>
        @else
            <a href="/login" class="text-primary font-semibold">Login</a>
        @endauth
    </div>
</nav>