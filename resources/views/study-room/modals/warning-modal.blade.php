<div id="warningModal"
    class="hidden fixed inset-0 z-[10050] items-center justify-center p-4 bg-black/60 backdrop-blur-sm">

    <div class="bg-white w-full max-w-sm rounded-[32px] p-8 shadow-2xl text-center">

        <div class="mx-auto w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mb-5">
            <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>

        <h3 id="warningModalTitle" class="text-xl font-bold text-gray-900 mb-2">
            {{ __('Sesi Belajar Masih Berjalan') }}
        </h3>

        <p id="warningModalDescription" class="text-sm text-gray-500 mb-8">
            {{ __('Kalau kamu pindah halaman sekarang, timer akan berhenti dan progres sesi ini bisa hilang. Yakin mau lanjut?') }}
        </p>

        <div class="flex gap-3">

            <button id="cancelWarningBtn"
                type="button"
                class="flex-1 py-3 font-bold text-gray-500 hover:bg-gray-50 rounded-2xl transition">
                {{ __('Tetap di Sini') }}
            </button>

            <button id="confirmWarningBtn"
                type="button"
                class="flex-1 py-3 bg-red-500 text-white font-bold rounded-2xl hover:bg-red-600 shadow-lg shadow-red-200 transition">
                {{ __('Akhiri Sesi') }}
            </button>

        </div>

    </div>

</div>