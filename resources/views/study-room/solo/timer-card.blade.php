<div
    id="timerCard"
    onclick="handleAreaClick(event)"
    class="

    rounded-[32px]

    bg-gradient-to-br
    from-blue-600
    via-blue-500
    to-indigo-500

    min-h-[560px]
    sm:min-h-[680px]
    md:min-h-[760px]

    flex
    flex-col

    p-5
    sm:p-8
    md:p-10

    text-white

    shadow-lg

    transition-all

    duration-300

    cursor-pointer

    active:scale-[0.99]

    relative

    overflow-hidden

">

    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 sm:gap-4 mb-6">

        <div>
            <p id="sessionTypeLabel"
                class="text-blue-100 text-sm font-semibold uppercase tracking-wide">
                Sesi Fokus
            </p>

            <h2 id="sessionTitle"
                class="mt-2 text-xl sm:text-2xl md:text-3xl font-extrabold">
                Belajar 25 Menit
            </h2>
        </div>

        <div class="sm:text-right">
            <p class="text-blue-100 text-xs font-medium uppercase tracking-widest">
                Progres
            </p>

            <p id="stepCounter"
                class="text-xl sm:text-2xl font-extrabold">
                Sesi 1 / 4
            </p>
        </div>

    </div>

    <div class="flex justify-center py-6">

        <div class="relative w-[280px] h-[280px] md:w-[340px] md:h-[340px]">

            <svg class="w-full h-full -rotate-90" viewBox="0 0 160 160">

                <circle
                    cx="80"
                    cy="80"
                    r="68"
                    stroke="rgba(255,255,255,0.18)"
                    stroke-width="10"
                    fill="none"/>

                <circle
                    id="progressCircle"
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

                <div id="timerDisplay"
                    class="text-6xl md:text-7xl font-extrabold leading-none tracking-tight">
                    25:00
                </div>

                <p id="statusText"
                    class="mt-4 text-sm text-blue-100">
                    Pilih mode lalu tekan Mulai.
                </p>

            </div>

        </div>

    </div>

    <div class="mt-6 flex flex-wrap justify-center gap-3">

        <button id="startBtn"
            class="px-6 py-3 rounded-2xl bg-yellow-300 text-gray-900 font-extrabold hover:bg-yellow-200 transition shadow-sm active:scale-[0.98]">
            Mulai
        </button>

        <button id="pauseBtn"
            class="px-6 py-3 rounded-2xl bg-white/15 text-white font-semibold hover:bg-white/20 transition active:scale-[0.98]">
            Jeda
        </button>

        <button id="resetBtn"
            class="px-6 py-3 rounded-2xl bg-white/15 text-white font-semibold hover:bg-white/20 transition active:scale-[0.98]">
            Ulang
        </button>

    </div>

</div>