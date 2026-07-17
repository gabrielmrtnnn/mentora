<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Mentora</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background flex items-center justify-center h-screen">

    <div class="fixed top-4 right-4">
        <div class="flex items-center gap-1.5 text-sm font-semibold">
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

    <div class="bg-white p-10 rounded-2xl shadow-xl text-center">
        <h1 class="text-4xl font-bold text-primary mb-4">
            Mentora 🚀
        </h1>

        <p class="text-textgray mb-6">
            {{ __('Platform belajar bareng untuk lolos SNBT') }}
        </p>

        <button class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-xl">
            {{ __('Mulai Belajar') }}
        </button>
    </div>

</body>
</html>