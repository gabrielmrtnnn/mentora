<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Daftar') }} - Mentora</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans p-4 antialiased text-gray-800">

    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col lg:flex-row border border-gray-100">

        <!-- SISI KIRI: Branding -->
        <div class="lg:w-5/12 bg-gradient-to-br from-blue-50 to-indigo-50/50 flex items-center justify-center hidden lg:flex p-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-blue-100/40 via-transparent to-transparent"></div>
            
            <img src="{{ asset('images/logo.png') }}" alt="Mentora Logo" class="w-full max-w-[180px] h-auto drop-shadow-md hover:scale-105 transition-transform duration-500 ease-out relative z-10">
        </div>

        <!-- SISI KANAN: Form Pendaftaran (Padding vertikal disusutkan jadi p-6 sm:p-8) -->
        <div class="lg:w-7/12 p-6 sm:p-8 relative flex flex-col justify-center bg-white">
            
            <!-- Language Switcher -->
            <div class="absolute top-4 right-4 lg:top-5 lg:right-5">
                <div class="flex items-center gap-1.5 text-[11px] font-bold bg-gray-50/80 px-2.5 py-1.5 rounded-full border border-gray-200 shadow-sm backdrop-blur-sm">
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

            <div class="max-w-md w-full mx-auto mt-4 lg:mt-0">
                <!-- Logo Mobile -->
                <div class="lg:hidden flex justify-center mb-4">
                    <img src="{{ asset('images/image_737ace.png') }}" alt="Mentora Logo" class="h-10 w-auto drop-shadow-sm">
                </div>

                <h1 class="text-2xl font-extrabold mb-1 text-gray-900 tracking-tight">
                    {{ __('Daftar') }} 🚀
                </h1>
                <!-- Margin bottom dikurangi dari mb-5 ke mb-4 -->
                <p class="text-sm text-gray-500 mb-4 font-medium">
                    {{ __('Buat akun untuk mulai belajar SNBT') }}
                </p>

                <!-- Jarak antar elemen input diperketat (space-y-2.5) -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Input Nama Lengkap -->
                    <div>
                        <!-- Margin bottom label dikurangi (mb-1) -->
                        <label for="name" class="block text-[13px] font-bold text-gray-700 mb-1">{{ __('Nama Lengkap') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <!-- Padding vertikal input dikurangi jadi py-2 -->
                            <input type="text" name="name" id="name" autocomplete="name"
                                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all bg-gray-50 focus:bg-white shadow-sm text-sm"
                                value="{{ old('name') }}" required autofocus placeholder="John Doe">
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-[13px] font-bold text-gray-700 mb-1">{{ __('Email') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 4a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H3zm0 2h14v.511l-7 4.2-7-4.2V6zm14 8H3V8.309l6.573 3.943a1 1 0 001.034 0L17 8.309V14z" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" autocomplete="email"
                                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all bg-gray-50 focus:bg-white shadow-sm text-sm"
                                value="{{ old('email') }}" required placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-[13px] font-bold text-gray-700 mb-1">{{ __('Password') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all bg-gray-50 focus:bg-white shadow-sm text-sm"
                                required placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-[13px] font-bold text-gray-700 mb-1">{{ __('Konfirmasi Password') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all bg-gray-50 focus:bg-white shadow-sm text-sm"
                                required placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Tombol Submit (padding disusutkan ke py-2.5) -->
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-bold hover:bg-blue-700 focus:ring-4 focus:ring-blue-600/30 transition-all duration-200 shadow-md shadow-blue-600/20 active:scale-[0.98] mt-2">
                        {{ __('Daftar Sekarang') }}
                    </button>
                </form>

                <!-- Divider (margin dikurangi ke my-4) -->
                <div class="my-4 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 bg-white text-gray-400 font-semibold">{{ __('atau') }}</span>
                    </div>
                </div>

                <!-- Google Button (padding disusutkan ke py-2) -->
                <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-2.5 px-4 py-2 border border-gray-200 rounded-xl font-bold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:ring-2 focus:ring-gray-100 transition-all active:scale-[0.98] shadow-sm text-sm">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" alt="Google" class="w-4 h-4">
                    {{ __('Daftar dengan Google') }}
                </a>

                <!-- Jarak link login dikurangi ke mt-4 -->
                <p class="text-center text-xs text-gray-500 mt-4 font-medium">
                    {{ __('Sudah punya akun?') }} 
                    <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:text-blue-700 hover:underline underline-offset-2 ml-1 transition-all">
                        {{ __('Masuk di sini') }}
                    </a>
                </p>

            </div>
        </div>
    </div>

</body>
</html>