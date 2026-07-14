@extends('layouts.app')

@section('content')
<div class="h-full bg-white rounded-2xl shadow overflow-hidden flex">

    <div class="w-96 border-r flex flex-col flex-shrink-0">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold">Messages</h1>
            <p class="text-gray-500 text-sm mt-1">Chat dengan tutor Mentora</p>
        </div>

        <div class="p-4 border-b">
            <input type="text" placeholder="Cari percakapan..." class="w-full border rounded-xl px-4 py-2 focus:ring-primary focus:border-primary">
        </div>

        <div class="flex-1 overflow-y-auto">
            @forelse($conversations as $chat)
                @php
                    $partner = auth()->id() == $chat->student_id ? $chat->tutor->user : $chat->student;
                    $lastMessage = $chat->messages->sortByDesc('created_at')->first();
                @endphp

                <a href="{{ route('chat.show', $chat) }}" class="flex items-center gap-4 p-4 border-b transition hover:bg-gray-50">
                    <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold flex-shrink-0">
                        {{ strtoupper(substr($partner->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="font-semibold truncate">
                            {{ $partner->name }}
                        </h2>
                        <p class="text-sm text-gray-500 truncate">
                            {{ $lastMessage?->message ?? 'Belum ada pesan' }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="h-full flex items-center justify-center text-gray-400">
                    Belum ada percakapan
                </div>
            @endforelse
        </div>
    </div>

    <div class="flex-1 flex flex-col items-center justify-center bg-gray-50">
        <div class="text-7xl mb-6">💬</div>
        <h2 class="text-2xl font-bold mb-2">Selamat Datang di Messages</h2>
        <p class="text-gray-500 text-center max-w-md">
            Pilih salah satu percakapan di sebelah kiri<br>untuk mulai chatting dengan tutor.
        </p>
    </div>

</div>
@endsection