<div class="mb-8">

    <div class="flex items-center justify-between">

        <div>
            <p class="text-sm font-semibold text-blue-600">
                Mentora • Tutor
            </p>

            <h1 class="text-5xl font-extrabold text-gray-900 mt-2">
                Tutor
            </h1>

            <p class="text-gray-500 mt-2">
                Belajar bersama tutor terbaik Mentora.
            </p>
        </div>

    </div>

    <div class="flex gap-3 mt-4">

        <a href="{{ route('tutor') }}"
            class="px-5 py-3 rounded-xl font-semibold transition
            {{ request()->routeIs('tutor') || request()->routeIs('tutor.show') || request()->routeIs('booking.create')
                ? 'bg-primary text-white'
                : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">

            🔍 Find Tutor

        </a>

        <a href="{{ route('booking.index') }}"
            class="px-5 py-3 rounded-xl font-semibold transition
            {{ request()->routeIs('booking.index')
                ? 'bg-primary text-white'
                : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">

            📅 My Booking

        </a>

    </div>

</div>