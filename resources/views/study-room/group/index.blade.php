<div id="sectionGroup" x-show="activeTab === 'group'">

    <div class="mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">

        <div>
            <h3 class="text-2xl font-bold text-gray-900">
                Daftar Group Study
            </h3>

            <p class="text-gray-500 text-sm">
                Pilih ruangan belajar bareng mentee lain.
            </p>
        </div>

        <button
            @click="openCreateModal = true"
            class="w-full sm:w-auto px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 active:scale-95 transition">

            + Buat Room Baru

        </button>

    </div>

    @include('study-room.group.cards')

    @include('study-room.group.create-modal')

</div>