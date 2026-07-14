@extends('layouts.app')

@section('content')

<div class="max-w-6xl ml-2">

    <!-- HEADER -->
    <div class="mb-8">
        <p class="text-sm font-semibold text-blue-600 mb-2">
            Mentora • Admin Panel
        </p>

        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900">
            Report Forum
        </h1>

        <p class="text-gray-500 mt-2">
            Diskusi dan balasan yang dilaporkan oleh pengguna.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl font-bold">
            {{ session('success') }}
        </div>
    @endif

    @forelse($reports as $group)

        @php
            // Semua report dalam satu grup nunjuk ke reportable yang sama,
            // jadi cukup ambil dari report pertama.
            $first = $group->first();
            $content = $first->reportable;
            $isThread = $content instanceof \App\Models\ForumThread;
        @endphp

        <div class="bg-white rounded-2xl shadow p-6 mb-5 border border-gray-100">

            <div class="flex justify-between items-start gap-4 mb-4">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">
                        {{ strtoupper(substr($content->user->name, 0, 1)) }}
                    </div>

                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 {{ $isThread ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }} text-xs font-semibold rounded-full">
                                {{ $isThread ? 'Diskusi' : 'Balasan' }}
                            </span>
                            <span class="text-xs text-gray-400">
                                oleh {{ $content->user->name }} • {{ $content->created_at->diffForHumans() }}
                            </span>
                        </div>

                        @if($isThread)
                            <h2 class="font-bold text-lg text-gray-900">
                                {{ $content->title }}
                            </h2>
                        @endif

                        <p class="text-gray-600 text-sm mt-1 line-clamp-3">
                            {{ $content->body }}
                        </p>
                    </div>

                </div>

                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium shrink-0">
                    {{ $group->count() }} laporan
                </span>

            </div>

            <!-- DAFTAR REPORT -->
            <div class="bg-gray-50 rounded-xl p-4 mb-4 space-y-3">
                @foreach($group as $report)
                    <div class="text-sm">
                        <span class="font-semibold text-gray-800">{{ $report->user->name }}</span>
                        <span class="text-gray-400">• {{ $report->created_at->diffForHumans() }}</span>
                        <span class="ml-1 px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">
                            {{ $report->reason_label }}
                        </span>
                        @if($report->description)
                            <p class="text-gray-600 mt-1">
                                "{{ $report->description }}"
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-between">

                @if($isThread)
                    <a href="{{ route('forum.show', $content->id) }}" target="_blank"
                        class="text-primary font-semibold hover:underline text-sm">
                        🔗 Lihat Diskusi
                    </a>
                @else
                    <a href="{{ route('forum.show', $content->forum_thread_id) }}" target="_blank"
                        class="text-primary font-semibold hover:underline text-sm">
                        🔗 Lihat di Thread
                    </a>
                @endif

                <div class="flex items-center gap-3">

                    <form action="{{ route('admin.reports.dismiss', $first->id) }}" method="POST"
                          class="js-confirm-dismiss">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-gray-100 text-gray-600 px-5 py-2 rounded-xl font-semibold hover:bg-gray-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            Abaikan
                        </button>
                    </form>

                    <form action="{{ route('admin.reports.destroy', $first->id) }}" method="POST"
                          class="js-confirm-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 bg-red-500 text-white px-5 py-2 rounded-xl font-semibold hover:opacity-90 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18" />
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                <path d="M10 11v6" />
                                <path d="M14 11v6" />
                            </svg>
                            Hapus Konten
                        </button>
                    </form>

                </div>

            </div>

        </div>

    @empty

        <div class="bg-white rounded-2xl p-10 text-center shadow">
            <div class="text-5xl mb-3">✅</div>

            <h3 class="font-bold text-lg mb-2">
                Tidak Ada Report
            </h3>

            <p class="text-gray-500">
                Belum ada diskusi atau balasan yang dilaporkan.
            </p>
        </div>

    @endforelse

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    function confirmSubmit(selector, options) {
        document.querySelectorAll(selector).forEach((form) => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                Swal.fire({
                    ...options,
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: options.confirmButtonText,
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    }

    confirmSubmit('.js-confirm-delete', {
        icon: 'warning',
        title: 'Hapus konten ini?',
        text: 'Aksi ini tidak bisa dibatalkan.',
        confirmButtonText: 'Ya, hapus',
        confirmButtonColor: '#ef4444',
    });

    confirmSubmit('.js-confirm-dismiss', {
        icon: 'question',
        title: 'Abaikan laporan ini?',
        text: 'Konten TIDAK akan dihapus.',
        confirmButtonText: 'Ya, abaikan',
        confirmButtonColor: '#3b82f6',
    });

});
</script>
@endpush
