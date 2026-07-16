<div id="sectionGroup" x-show="activeTab === 'group'">

    <div class="mb-6">
        @include('study-room.components.category-picker', ['scope' => 'group'])
    </div>

    <div id="groupTimerCard"
        class="mb-8 bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-[32px] shadow-lg p-6 flex items-center justify-between">

        <div>
            <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide">
                {{ __('Sesi Kelompok Berjalan') }}
            </p>
            <p id="groupTimerDisplay" class="text-4xl font-extrabold mt-1">
                00:00
            </p>
            <p id="groupTimerCategoryLabel" class="text-sm text-blue-100 mt-1">
                {{ __('Kategori') }}: TPS
            </p>
        </div>

        <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>

    </div>

    <div class="mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">

        <div>
            <h3 class="text-2xl font-bold text-gray-900">
                {{ __('Daftar Kelompok Belajar') }}
            </h3>

            <p class="text-gray-500 text-sm">
                {{ __('Pilih ruangan belajar bareng mentee lain.') }}
            </p>
        </div>

        <button
            @click="openCreateModal = true"
            class="w-full sm:w-auto px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 active:scale-95 transition">

            + {{ __('Buat Ruangan Baru') }}

        </button>

    </div>

    @include('study-room.group.cards')

    @include('study-room.group.create-modal')

</div>