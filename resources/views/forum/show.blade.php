@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto w-full pb-16">

    <!-- BACK -->
    <div class="mb-6">
        <a href="{{ route('forum') }}"
           class="text-primary font-medium hover:underline">
            ← Kembali ke Forum
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl font-bold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- THREAD -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">

        <div class="flex items-center justify-between gap-3 mb-4">

            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">
                    {{ strtoupper(substr($thread->user->name, 0, 1)) }}
                </div>

                <div>
                    <p class="font-semibold text-gray-800">
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

        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
            {{ $thread->title }}
        </h1>

        <p class="text-gray-700 leading-relaxed whitespace-pre-line mb-5">
            {{ $thread->body }}
        </p>

        <!-- LIKE THREAD -->
        <div class="pt-4 border-t border-gray-100">
            <button
                type="button"
                class="like-btn inline-flex items-center gap-1.5 text-sm font-semibold px-3 py-1.5 rounded-full transition {{ $thread->isLikedBy(auth()->id()) ? 'bg-red-50 text-red-500' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}"
                data-type="thread"
                data-id="{{ $thread->id }}">
                <span class="like-icon">{{ $thread->isLikedBy(auth()->id()) ? '❤️' : '🤍' }}</span>
                <span class="like-count">{{ $thread->likes_count }}</span>
                <span>Suka</span>
            </button>
        </div>

    </div>

    <!-- REPLIES -->
    <div class="mt-8">

        <h2 class="text-xl font-bold text-gray-900 mb-4">
            {{ $thread->replies->count() }} Balasan
        </h2>

        <div class="flex flex-col gap-3">

            @forelse($thread->replies as $reply)

                <div class="bg-gray-50 rounded-2xl p-4 flex gap-3">

                    <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold shrink-0">
                        {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $reply->user->name }}
                            </p>
                            <p class="text-xs text-gray-400">
                                • {{ $reply->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed mb-3">
                            {{ $reply->body }}
                        </p>

                        <!-- LIKE REPLY -->
                        <button
                            type="button"
                            class="like-btn inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full transition {{ $reply->isLikedBy(auth()->id()) ? 'bg-red-50 text-red-500' : 'bg-white text-gray-500 hover:bg-gray-100 border border-gray-200' }}"
                            data-type="reply"
                            data-id="{{ $reply->id }}">
                            <span class="like-icon">{{ $reply->isLikedBy(auth()->id()) ? '❤️' : '🤍' }}</span>
                            <span class="like-count">{{ $reply->likes_count }}</span>
                            <span>Suka</span>
                        </button>
                    </div>

                </div>

            @empty

                <div class="bg-gray-50 rounded-2xl p-6 text-center text-gray-500">
                    Belum ada balasan. Jadi yang pertama jawab! 🙌
                </div>

            @endforelse

        </div>

    </div>

    <!-- REPLY BOX -->
    <div class="mt-6 bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

        <h3 class="font-bold text-gray-900 mb-3">
            Tulis Balasan
        </h3>

        <form method="POST" action="{{ route('forum.reply', $thread->id) }}">
            @csrf
            <textarea
                name="body"
                rows="3"
                placeholder="Tulis balasan kamu di sini..."
                required
                class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 py-3 px-4">{{ old('body') }}</textarea>

            <div class="mt-4 flex justify-end">
                <button type="submit"
                    class="bg-primary text-white font-semibold px-6 py-3 rounded-xl hover:opacity-90 transition">
                    Kirim Balasan
                </button>
            </div>
        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const metaTag = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = metaTag ? metaTag.getAttribute('content') : '';

    // LIKE (thread & reply, satu endpoint dibedain lewat data-type)
    document.querySelectorAll('.like-btn').forEach(function (btn) {
        btn.addEventListener('click', async function () {

            if (btn.disabled) return;
            btn.disabled = true;

            const type = btn.dataset.type;
            const id = btn.dataset.id;

            try {
                const response = await fetch("{{ route('forum.like') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ type: type, id: id }),
                });

                if (!response.ok) {
                    throw new Error('Gagal memproses like');
                }

                const data = await response.json();

                const icon = btn.querySelector('.like-icon');
                const count = btn.querySelector('.like-count');

                icon.textContent = data.liked ? '❤️' : '🤍';
                count.textContent = data.count;

                if (data.liked) {
                    btn.classList.add('bg-red-50', 'text-red-500');
                    btn.classList.remove('bg-gray-100', 'text-gray-500', 'bg-white', 'border', 'border-gray-200');
                } else {
                    if (type === 'thread') {
                        btn.classList.add('bg-gray-100', 'text-gray-500');
                    } else {
                        btn.classList.add('bg-white', 'text-gray-500', 'border', 'border-gray-200');
                    }
                    btn.classList.remove('bg-red-50', 'text-red-500');
                }

            } catch (err) {
                alert('Gagal memproses like, coba lagi ya.');
            } finally {
                btn.disabled = false;
            }
        });
    });

});
</script>
@endpush
