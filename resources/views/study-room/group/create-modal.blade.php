<div
    x-show="openCreateModal"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-cloak>

    <div
        @click.away="openCreateModal = false"
        class="bg-white w-full max-w-md rounded-[32px] p-8 shadow-2xl">

        <h3 class="text-2xl font-bold text-gray-900 mb-2">
            Buat Study Room Baru
        </h3>

        <p class="text-sm text-gray-500 mb-6">
            Ruangan ini akan muncul di daftar publik.
        </p>

        <form action="{{ route('study.group.store') }}" method="POST">

            @csrf

            <div class="space-y-4">

                <div>

                    <label class="block text-sm font-bold text-gray-700 mb-1">
                        Nama Room
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Misal: Ambis UTBK Malam"
                        required
                        class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 py-3 px-4">

                </div>

                <div>

                    <label class="block text-sm font-bold text-gray-700 mb-1">
                        Mata Pelajaran
                    </label>

                    <input
                        type="text"
                        name="subject"
                        placeholder="Misal: Pengetahuan Kuantitatif"
                        required
                        class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 py-3 px-4">

                </div>

            </div>

            <div class="mt-8 flex gap-3">

                <button
                    type="button"
                    @click="openCreateModal = false"
                    class="flex-1 py-3 font-bold text-gray-500 hover:bg-gray-50 rounded-2xl transition">

                    Batal

                </button>

                <button
                    type="submit"
                    class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition">

                    Buat Sekarang

                </button>

            </div>

        </form>

    </div>

</div>