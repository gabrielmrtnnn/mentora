<div class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-5 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center sm:justify-between gap-3">

        <div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-3">
            <button id="modePomodoro"
                class="mode-btn px-4 sm:px-5 py-3 rounded-2xl text-sm font-bold transition-all duration-200 border border-transparent">
                Pomodoro 25/5
            </button>

            <button id="modeDeep50"
                class="mode-btn px-4 sm:px-5 py-3 rounded-2xl text-sm font-bold transition-all duration-200 border border-transparent">
                Deep 50/10
            </button>
        </div>

        <button id="focusModeBtn"
            class="w-full sm:w-auto px-4 py-3 rounded-2xl bg-gray-100 text-gray-700 text-sm font-bold hover:bg-gray-200 transition-all duration-200">
            {{ __('Mode Fokus') }}
        </button>

    </div>
</div>