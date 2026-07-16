<div id="focusOverlay"
    class="fixed top-0 left-0 w-screen h-screen z-[9999] hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 text-white overflow-hidden cursor-pointer"
    onclick="handleOverlayAreaClick(event)">

    <div class="w-full h-full flex flex-col">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 md:px-10 py-6">

            <div>
                <p id="focusOverlayType"
                    class="text-blue-100 text-sm font-semibold uppercase tracking-wide">
                    {{ __('Sesi Fokus') }}
                </p>

                <h2 id="focusOverlayTitle"
                    class="mt-2 text-2xl md:text-3xl font-extrabold">
                    {{ __('Belajar 25 Menit') }}
                </h2>

                <p id="focusOverlayStepCounter"
                    class="mt-1 text-blue-200 text-sm font-medium">
                    {{ __('Sesi') }} 1 / 4
                </p>
            </div>

            <button id="exitFocusModeBtn"
                class="self-start sm:self-auto px-4 py-3 rounded-2xl bg-white/15 text-white text-sm font-bold hover:bg-white/20 transition">
                {{ __('Keluar Mode Fokus') }}
            </button>

        </div>

        <div class="flex-1 flex flex-col items-center justify-center px-6">

            <div class="relative w-[280px] h-[280px] md:w-[380px] md:h-[380px]">

                <svg class="w-full h-full -rotate-90" viewBox="0 0 160 160">

                    <circle
                        cx="80"
                        cy="80"
                        r="68"
                        stroke="rgba(255,255,255,0.18)"
                        stroke-width="10"
                        fill="none"/>

                    <circle
                        id="focusOverlayProgressCircle"
                        cx="80"
                        cy="80"
                        r="68"
                        stroke="#FACC15"
                        stroke-width="10"
                        fill="none"
                        stroke-linecap="round"
                        stroke-dasharray="427"
                        stroke-dashoffset="427"/>

                </svg>

                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">

                    <div id="focusOverlayTimerDisplay"
                        class="text-7xl md:text-8xl font-extrabold leading-none tracking-tight">
                        25:00
                    </div>

                    <p id="focusOverlayStatusText"
                        class="mt-4 text-sm md:text-base text-blue-100">
                        {{ __('Siap') }}
                    </p>

                </div>

            </div>

            <div class="mt-10 flex flex-wrap justify-center gap-3">

                <button id="focusOverlayStartBtn"
                    class="px-6 py-3 rounded-2xl bg-yellow-300 text-gray-900 font-extrabold hover:bg-yellow-200 transition active:scale-[0.98]">
                    {{ __('Mulai') }}
                </button>

                <button id="focusOverlayPauseBtn"
                    class="px-6 py-3 rounded-2xl bg-white/15 text-white font-semibold hover:bg-white/20 transition active:scale-[0.98]">
                    {{ __('Jeda') }}
                </button>

                <button id="focusOverlayResetBtn"
                    class="px-6 py-3 rounded-2xl bg-white/15 text-white font-semibold hover:bg-white/20 transition active:scale-[0.98]">
                    {{ __('Ulang') }}
                </button>

            </div>

            <p class="mt-8 text-blue-200/60 text-xs uppercase tracking-widest font-bold">
                {{ __('Selanjutnya:') }}
                <span id="focusOverlayNextBreakText" class="text-white">
                    {{ __('Istirahat 5 Menit') }}
                </span>
            </p>

        </div>

    </div>

    <div id="jitsiFrame" class="flex-1 bg-gray-900"></div>

</div>