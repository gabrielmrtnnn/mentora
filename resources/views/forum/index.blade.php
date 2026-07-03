@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto w-full pb-16" x-data="{ openCreateModal: {{ $errors->any() ? 'true' : 'false' }}, imagePreview: null }">

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl font-bold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- HERO -->
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-6 mb-8">

        <div>
            <p class="text-sm font-semibold text-blue-600 mb-2">
                Mentora • Forum
            </p>

            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900">
                Forum Diskusi
            </h1>

            <p class="text-gray-500 mt-2">
                Ruang buat nanya, sharing, atau sekadar curhat bareng sesama pengguna Mentora.
            </p>
        </div>

        <button
            @click="openCreateModal = true"
            class="bg-primary text-white font-semibold px-5 py-3 rounded-xl hover:opacity-90 transition shrink-0">
            + Buat Diskusi
        </button>

    </div>

    <!-- SEARCH -->
    <div class="mb-5">
        <input
            type="text"
            id="searchInput"
            placeholder="Cari diskusi..."
            class="w-full px-4 py-2 bg-white border border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary">
    </div>

    <!-- FILTER -->
    <div class="flex flex-wrap gap-3 mb-8">

        <button class="filter-btn px-4 py-2 bg-primary text-white font-semibold rounded-full"
            data-filter="all">
            Semua
        </button>

        <button class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-full"
            data-filter="diskusi umum">
            Diskusi Umum
        </button>

        <button class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-full"
            data-filter="tanya jawab">
            Tanya Jawab
        </button>

        <button class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-full"
            data-filter="pengumuman">
            Pengumuman
        </button>

    </div>

    <!-- THREAD LIST -->
    <div class="flex flex-col gap-4" id="threadList">

        @forelse($threads as $thread)

            <a
                href="{{ route('forum.show', $thread->id) }}"
                class="thread-card block bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100"
                data-title="{{ strtolower($thread->title) }}"
                data-category="{{ $thread->category }}"
            >

                <!-- HEADER -->
                <div class="flex items-center justify-between gap-3 mb-3">

                    <div class="flex items-center gap-3">

                        <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold shrink-0">
                            {{ strtoupper(substr($thread->user->name, 0, 1)) }}
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $thread->user->name }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $thread->created_at->diffForHumans() }}
                            </p>
                        </div>

                    </div>

                    <span class="px-3 py-1 {{ $thread->category_color }} text-xs font-semibold rounded-full shrink-0">
                        {{ $thread->category_label }}
                    </span>

                </div>

                <!-- TITLE -->
                <h2 class="font-bold text-lg text-gray-900 mb-1">
                    {{ $thread->title }}
                </h2>

                <!-- SNIPPET -->
                <p class="text-sm text-gray-500 line-clamp-2">
                    {{ $thread->body }}
                </p>

                @if($thread->image_url)
                    <img src="{{ $thread->image_url }}" alt="" class="mt-3 rounded-xl max-h-56 w-full object-cover">
                @endif

                <!-- FOOTER -->
                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center gap-4 text-sm text-gray-400 font-medium">
                    <span>💬 {{ $thread->replies_count }} balasan</span>
                    <span>❤️ {{ $thread->likes_count }} suka</span>
                </div>

            </a>

        @empty

            <div class="bg-white rounded-2xl shadow p-10 text-center">

                <div class="text-5xl mb-4">
                    💬
                </div>

                <h3 class="font-bold text-xl mb-2">
                    Belum Ada Diskusi
                </h3>

                <p class="text-gray-500">
                    Jadi yang pertama mulai diskusi di forum ini.
                </p>

            </div>

        @endforelse

        <!-- NO SEARCH/FILTER RESULT -->
        <div id="noResult" class="hidden bg-white rounded-2xl shadow p-10 text-center">
            <div class="text-5xl mb-4">🔍</div>
            <h3 class="font-bold text-xl mb-2">Ga Ketemu, Nih</h3>
            <p class="text-gray-500">Coba kata kunci atau kategori lain.</p>
        </div>

    </div>

    <!-- CREATE MODAL -->
    <div x-show="openCreateModal"
         class="fixed inset-0 bg-black/60 flex items-center justify-center z-[70] px-4 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-cloak>
        <div @click.away="openCreateModal = false" class="bg-white w-full max-w-lg rounded-[32px] p-8 shadow-2xl">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Buat Diskusi Baru</h3>
            <p class="text-sm text-gray-500 mb-6">Diskusi kamu akan langsung muncul di forum.</p>

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="createThreadForm" method="POST" action="{{ route('forum.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Judul</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Tulis judul diskusi kamu..." required
                            class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 py-3 px-4">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                        <select name="category" required
                            class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 py-3 px-4">
                            <option value="diskusi umum" @selected(old('category') === 'diskusi umum')>Diskusi Umum</option>
                            <option value="tanya jawab" @selected(old('category') === 'tanya jawab')>Tanya Jawab</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Isi</label>
                        <textarea name="body" rows="4" placeholder="Ceritain lebih detail di sini..." required
                            class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 py-3 px-4">{{ old('body') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Foto (opsional)</label>
                        <input type="file" name="image" accept="image/png, image/jpeg, image/webp"
                            @change="imagePreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null"
                            class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-blue-50 file:text-primary file:font-semibold hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, atau WEBP, maks 2MB.</p>
                        <template x-if="imagePreview">
                            <img :src="imagePreview" alt="Preview" class="mt-3 rounded-xl max-h-40 w-full object-cover">
                        </template>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="button" @click="openCreateModal = false" class="flex-1 py-3 font-bold text-gray-500 hover:bg-gray-50 rounded-2xl transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                        Posting
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const threadCards = document.querySelectorAll('.thread-card');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const noResult = document.getElementById('noResult');

    let currentFilter = 'all';

    // SEARCH
    searchInput.addEventListener('input', applyFilter);

    // FILTER BUTTON
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            currentFilter = btn.dataset.filter;

            filterButtons.forEach(b => {
                b.classList.remove('bg-primary', 'text-white');
                b.classList.add('bg-gray-200', 'text-gray-700');
            });

            btn.classList.remove('bg-gray-200', 'text-gray-700');
            btn.classList.add('bg-primary', 'text-white');

            applyFilter();
        });
    });

    function applyFilter() {

        const search = searchInput.value.toLowerCase();
        let visibleCount = 0;

        threadCards.forEach(card => {

            const title = card.dataset.title;
            const category = card.dataset.category;

            const matchFilter = (currentFilter === 'all') || (category === currentFilter);
            const matchSearch = title.includes(search);

            const show = matchFilter && matchSearch;
            card.style.display = show ? 'block' : 'none';

            if (show) visibleCount++;
        });

        noResult.classList.toggle('hidden', visibleCount !== 0);
    }

});
</script>
@endpush
