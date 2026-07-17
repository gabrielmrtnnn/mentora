<div id="sessionModal"
    class="hidden fixed inset-0 z-[10040] items-center justify-center p-4 bg-black/60 backdrop-blur-sm">

    <div class="bg-white w-full max-w-sm rounded-[32px] p-8 shadow-2xl text-center">

        <div class="mx-auto w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-5">
            <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>

        <h3 id="modalTitle" class="text-xl font-bold text-gray-900 mb-2">
            {{ __('Sesi selesai') }}
        </h3>

        <p id="modalDescription" class="text-sm text-gray-500 mb-8">
            {{ __('Sesi kamu sudah selesai.') }}
        </p>

        <div class="flex gap-3">

            <button id="modalSecondaryBtn"
                type="button"
                class="flex-1 py-3 font-bold text-gray-500 hover:bg-gray-50 rounded-2xl transition">
                {{ __('Nanti Aja') }}
            </button>

            <button id="modalPrimaryBtn"
                type="button"
                class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                {{ __('Lanjut') }}
            </button>

        </div>

    </div>

</div>