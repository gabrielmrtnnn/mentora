@php
    $layout = $layout ?? 'sidebar';
    $scope = $scope ?? 'solo';
    $focusCategories = [
        ['label' => 'TPS', 'minutes' => $tps],
        ['label' => 'Numerasi', 'minutes' => $numerasi],
        ['label' => 'Literasi', 'minutes' => $literasi],
    ];
@endphp

<section data-learning-statistics="{{ $scope }}"
    class="bg-white rounded-[28px] border border-gray-100 shadow-sm p-6"
    style="--statistics-color: #2563eb;">
    <div class="flex items-center gap-3 mb-6">
        <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center" aria-hidden="true">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M8 16v-3m4 3V8m4 8v-5" />
            </svg>
        </span>
        <div>
            <h2 class="font-bold text-gray-900">{{ __('Statistik Belajar') }}</h2>
            <p class="text-xs text-gray-500">{{ __('Total waktu belajar per kategori') }}</p>
        </div>
    </div>

    <div class="{{ $layout === 'horizontal' ? 'grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-6' : 'space-y-5' }}">
        @foreach($focusCategories as $category)
            <div data-learning-statistics-category="{{ $category['label'] }}"
                class="{{ $layout === 'horizontal' ? 'md:border-l md:border-gray-100 md:pl-6 first:md:border-l-0 first:md:pl-0' : '' }}">
                <div class="flex items-center justify-between gap-3 text-sm mb-2">
                    <span class="font-medium text-gray-700">{{ $category['label'] }}</span>
                    <span class="font-semibold text-gray-900 whitespace-nowrap">
                        {{ number_format($category['minutes'] / 60, 2) }} {{ __('jam') }}
                    </span>
                </div>
                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div data-learning-statistics-bar class="h-full rounded-full transition-all duration-500"
                        style="width: {{ ($category['minutes'] / $maxFocusMinutes) * 100 }}%; background-color: #d1d5db;"
                        ></div>
                </div>
            </div>
        @endforeach
    </div>
</section>
