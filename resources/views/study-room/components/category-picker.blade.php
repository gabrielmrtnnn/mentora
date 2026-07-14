@php($scope = $scope ?? 'solo')

<div id="{{ $scope }}CategoryPicker"
    data-scope="{{ $scope }}"
    class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-5 sm:p-6">

    <p class="text-xl font-bold text-gray-800 mb-4">
        Hari ini mau fokus apa?
    </p>

    <div class="grid grid-cols-3 gap-2 sm:gap-3">

        <button type="button"
            data-category="TPS"
            class="category-btn flex flex-col items-center gap-1 sm:gap-2 rounded-2xl border-2 border-gray-100 bg-gray-50 px-2 py-3 sm:px-4 sm:py-4 transition-all duration-200">
            <span class="text-xl sm:text-2xl">📘</span>
            <span class="text-xs sm:text-sm font-bold text-gray-800">TPS</span>
            <span class="hidden sm:block text-xs text-gray-400 text-center">Tes Potensi Skolastik</span>
        </button>

        <button type="button"
            data-category="Numerasi"
            class="category-btn flex flex-col items-center gap-1 sm:gap-2 rounded-2xl border-2 border-gray-100 bg-gray-50 px-2 py-3 sm:px-4 sm:py-4 transition-all duration-200">
            <span class="text-xl sm:text-2xl">📊</span>
            <span class="text-xs sm:text-sm font-bold text-gray-800">Numerasi</span>
            <span class="hidden sm:block text-xs text-gray-400 text-center">Matematika</span>
        </button>

        <button type="button"
            data-category="Literasi"
            class="category-btn flex flex-col items-center gap-1 sm:gap-2 rounded-2xl border-2 border-gray-100 bg-gray-50 px-2 py-3 sm:px-4 sm:py-4 transition-all duration-200">
            <span class="text-xl sm:text-2xl">📖</span>
            <span class="text-xs sm:text-sm font-bold text-gray-800">Literasi</span>
            <span class="hidden sm:block text-xs text-gray-400 text-center">Bahasa Indonesia</span>
        </button>

    </div>

</div>