<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mentora</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans p-4 sm:p-8 antialiased text-gray-800">

    <!-- Container Utama: Ukuran max-width-4xl (sedikit lebih lebar dari form register) agar proporsional -->
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col lg:flex-row border border-gray-100">

        <!-- SISI KIRI: Branding (Lebih lapang) -->
        <div class="lg:w-5/12 bg-gradient-to-br from-blue-50 to-indigo-50/50 flex items-center justify-center hidden lg:flex p-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-blue-100/40 via-transparent to-transparent"></div>
            
            <img src="{{ asset('images/logo.png') }}" alt="Mentora Logo" class="w-full max-w-[200px] h-auto drop-shadow-md hover:scale-105 transition-transform duration-500 ease-out relative z-10">
        </div>

        <!-- SISI KANAN: Form Login (Padding vertikal dan horizontal diperbesar jadi p-8 sm:p-12) -->
        <div class="lg:w-7/12 p-8 sm:p-12 relative flex flex-col justify-center bg-white">
            
            <!-- Language Switcher -->
            <div class="absolute top-6 right-6 lg:top-8 lg:right-8">
                <div class="flex items-center gap-2 text-xs font-bold bg-gray-50/80 px-3 py-1.5 rounded-full border border-gray-200 shadow-sm backdrop-blur-sm">
                    <a href="{{ route('language.switch', 'id') }}"
                       class="{{ app()->getLocale() === 'id' ? 'text-blue-600' : 'text-gray-400 hover:text-gray-700' }} transition-colors px-1">
                        ID
                    </a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('language.switch', 'en') }}"
                       class="{{ app()->getLocale() === 'en' ? 'text-blue-600' : 'text-gray-400 hover:text-gray-700' }} transition-colors px-1">
                        EN
                    </a>
                </div>
            </div>

            <div class="max-w-md w-full mx-auto mt- lg:mt-0">
                <!-- Logo Mobile -->
                <div class="lg:hidden flex justify-center mb-8">
                    <img src="{{ asset('images/image_737ace.png') }}" alt="Mentora Logo" class="h-14 w-auto drop-shadow-sm">
                </div>

                <!-- Teks Heading diperbesar jadi text-3xl -->
                <h1 class="text-3xl font-extrabold mb-2 text-gray-900 tracking-tight">
                    {{ __('Masuk') }} 👋
                </h1>
                <p class="text-sm text-gray-500 mb-2 font-medium">
                    {{ __('Selamat datang kembali! Masukkan detail akunmu.') }}
                </p>

                @if (session('status'))
                    <div class="mb-6 text-emerald-700 text-sm font-medium bg-emerald-50 border border-emerald-200 py-3 px-4 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Jarak antar elemen diperbesar (space-y-5) -->
                <form method="POST" action="{{ route('login') }}" class="space-y-3">
                    @csrf

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Email') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 4a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H3zm0 2h14v.511l-7 4.2-7-4.2V6zm14 8H3V8.309l6.573 3.943a1 1 0 001.034 0L17 8.309V14z" />
                                </svg>
                            </div>
                            <!-- Tinggi input dikembalikan ke py-3 -->
                            <input type="email" name="email" id="email" autocomplete="username"
                                class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all bg-gray-50 focus:bg-white shadow-sm text-sm"
                                value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2 font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Password') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <!-- Tinggi input dikembalikan ke py-3 -->
                            <input type="password" name="password" id="password" autocomplete="current-password"
                                class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all bg-gray-50 focus:bg-white shadow-sm text-sm"
                                required placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2 font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember & Lupa Password -->
                    <div class="flex items-center justify-between text-sm pt-2">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600/30 transition-colors">
                            <span class="font-medium text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Ingat saya') }}</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-blue-600 font-bold hover:text-blue-700 hover:underline underline-offset-4 transition-all">
                            {{ __('Lupa password?') }}
                        </a>
                    </div>

                    <!-- Tombol Submit dikembalikan ke ukuran py-3.5 dan margin top ditambah -->
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3.5 rounded-xl font-bold hover:bg-blue-700 focus:ring-4 focus:ring-blue-600/30 transition-all duration-200 shadow-lg shadow-blue-600/20 active:scale-[0.98] mt-4">
                        {{ __('Masuk') }}
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-7 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-400 font-semibold">{{ __('atau') }}</span>
                    </div>
                </div>

                <!-- Google Button dikembalikan ke ukuran py-3.5 -->
                <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3.5 border border-gray-200 rounded-xl font-bold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:ring-4 focus:ring-gray-100 transition-all active:scale-[0.98] shadow-sm text-sm">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" alt="Google" class="w-5 h-5">
                    {{ __('Masuk dengan Google') }}
                </a>

                <!-- Register Link margin ditambah ke mt-8 -->
                <p class="text-center text-sm text-gray-500 mt-8 font-medium">
                    {{ __('Belum punya akun?') }} 
                    <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:text-blue-700 hover:underline underline-offset-4 ml-1 transition-all">
                        {{ __('Daftar sekarang') }}
                    </a>
                </p>

            </div>
        </div>
    </div>

</body>
</html>