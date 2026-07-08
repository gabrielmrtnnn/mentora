<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">

    <div>
        <p class="text-sm font-semibold text-blue-600 mb-2">
            Mentora • Study Room
        </p>

        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900">
            Study Room
        </h1>
    </div>

    <div class="w-full sm:w-auto flex bg-gray-100 p-1 rounded-2xl shadow-inner">

        <button
            @click="activeTab = 'solo'"
            :class="activeTab === 'solo'
                ? 'bg-white text-blue-600 shadow-sm'
                : 'text-gray-500 hover:text-gray-700'"
            class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-200">

            Solo Mode

        </button>

        <button
            @click="activeTab = 'group'"
            :class="activeTab === 'group'
                ? 'bg-white text-blue-600 shadow-sm'
                : 'text-gray-500 hover:text-gray-700'"
            class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-200">

            Group Study

        </button>

    </div>

</div>