<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mentora</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow">

        <!-- TITLE -->
        <h1 class="text-2xl font-bold mb-2 text-center">
            Daftar Mentora 🚀
        </h1>
        <p class="text-sm text-gray-500 text-center mb-6">
            Buat akun untuk mulai belajar SNBT
        </p>

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- NAME -->
            <div>
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="name"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                    value="{{ old('name') }}" required autofocus>

                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                    value="{{ old('email') }}" required>

                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                    required>

                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                    required>

                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- REGISTER BUTTON -->
            <button type="submit"
                class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                Daftar
            </button>
        </form>

        <!-- DIVIDER -->
        <div class="my-6 text-center text-sm text-gray-400">
            sudah punya akun?
        </div>

        <!-- LOGIN BUTTON -->
        <a href="{{ route('login') }}"
           class="block w-full text-center border border-primary text-primary py-2 rounded-lg font-semibold hover:bg-primary hover:text-white transition">
            Login sekarang
        </a>

    </div>

</body>
</html>