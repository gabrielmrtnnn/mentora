<div
    id="groupCallBanner"
    class="hidden mb-6 p-5 sm:p-6 bg-blue-50 border border-blue-200 rounded-2xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-8">

    <p class="text-sm text-blue-700 font-semibold flex-1">
        {{ __('Video call kamu lagi kebuka di tab lain. Timer otomatis berhenti pas tab itu ditutup.') }}
    </p>

    <button
        id="groupCallEndBtn"
        type="button"
        class="px-5 py-2.5 rounded-xl bg-red-600 text-white text-sm font-bold hover:bg-red-700 transition shrink-0 whitespace-nowrap">
        {{ __('Sudah selesai, akhiri sesi') }}
    </button>

</div>