<div class="space-y-6">

    <div class="bg-white rounded-[28px] border border-gray-100 shadow-sm p-6">

        <p class="text-sm text-gray-500 font-medium">
            {{ __('Menit Hari Ini') }}
        </p>

        <h3 class="mt-3 text-4xl font-extrabold text-gray-900">
            <span id="todayMinutes">
                {{ $todayMinutes ?? 0 }}
            </span>
        </h3>

        <p class="mt-2 text-sm text-gray-500">
            {{ __('Total menit fokus hari ini.') }}
        </p>

    </div>

    <div class="bg-white rounded-[28px] border border-gray-100 shadow-sm p-6">

        <p class="text-sm text-gray-500 font-medium">
            {{ __('Sesi Hari Ini') }}
        </p>

        <h3 class="mt-3 text-4xl font-extrabold text-gray-900">
            <span id="todaySessions">
                {{ $todaySessions ?? 0 }}
            </span>
        </h3>

        <p class="mt-2 text-sm text-gray-500">
            {{ __('Sesi fokus yang diselesaikan.') }}
        </p>

    </div>

    @include('study-room.components.learning-statistics', ['scope' => 'solo'])

</div>
