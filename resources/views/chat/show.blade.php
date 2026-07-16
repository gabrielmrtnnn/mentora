@extends('layouts.app')

@section('content')
<div class="h-full bg-white rounded-2xl shadow overflow-hidden flex">

    <div class="w-96 border-r flex flex-col flex-shrink-0">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold">Messages</h1>
            <p class="text-gray-500 text-sm mt-1">{{ __('Chat dengan tutor Mentora') }}</p>
        </div>

        <div class="p-4 border-b">
            <input type="text" placeholder="{{ __('Cari percakapan...') }}" class="w-full border rounded-xl px-4 py-2 focus:ring-primary focus:border-primary">
        </div>

        <div class="flex-1 overflow-y-auto">
            @forelse($conversations as $chat)
                @php
                    $partner = auth()->id() == $chat->student_id ? $chat->tutor->user : $chat->student;
                    $lastMessage = $chat->messages->sortByDesc('created_at')->first();
                @endphp

                <a href="{{ route('chat.show', $chat) }}" class="flex items-center gap-4 p-4 border-b transition {{ $chat->id == $conversation->id ? 'bg-primary/10' : 'hover:bg-gray-50' }}">
                    <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold flex-shrink-0">
                        {{ strtoupper(substr($partner->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="font-semibold truncate">
                            {{ $partner->name }}
                        </h2>
                        <p class="text-sm text-gray-500 truncate">
                            {{ $lastMessage?->message ?? __('Belum ada pesan') }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="h-full flex items-center justify-center text-gray-400">
                    {{ __('Belum ada percakapan') }}
                </div>
            @endforelse
        </div>
    </div>

    <div class="flex-1 flex flex-col">
        @php
            $partner = auth()->id() == $conversation->student_id ? $conversation->tutor->user : $conversation->student;
        @endphp

        <div class="p-6 border-b flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold flex-shrink-0">
                {{ strtoupper(substr($partner->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="font-bold text-lg">{{ $partner->name }}</h2>
                <p class="text-green-500 text-sm">● {{ __('Online') }}</p>
            </div>
        </div>

        <div id="messages" class="flex-1 overflow-y-auto bg-gray-50 p-6 space-y-4">
            @forelse($conversation->messages as $message)
                <div class="{{ $message->sender_id == auth()->id() ? 'text-right' : '' }}">
                    <div class="inline-block max-w-xl px-4 py-3 rounded-2xl shadow-sm text-left {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-white' }}">
                        <p>{{ $message->message }}</p>
                        <p class="text-[10px] opacity-70 mt-2 {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                            {{ $message->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="h-full flex items-center justify-center text-gray-400">
                    {{ __('Belum ada pesan') }}
                </div>
            @endforelse
        </div>

        <form id="chatForm" action="{{ route('chat.send', $conversation) }}" method="POST" class="border-t p-4 flex gap-3">
            @csrf
            <input id="messageInput" type="text" name="message" placeholder="{{ __('Ketik pesan...') }}" autocomplete="off" required class="flex-1 border rounded-xl px-4 py-3 focus:ring-primary focus:border-primary">
            <button type="submit" class="bg-primary text-white px-6 rounded-xl hover:opacity-90 transition">
                {{ __('Kirim') }}
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const messages = document.getElementById('messages');
        const form = document.getElementById('chatForm');
        const input = document.getElementById('messageInput');
        let lastMessageId = {{ $conversation->messages->max('id') ?? 0 }};
        messages.scrollTop = messages.scrollHeight;

        function appendMessage(message) {
            if(document.getElementById('message-' + message.id)){
                return;
            }
            const mine = message.sender_id == {{ auth()->id() }};

            const time = new Date(message.created_at)
                .toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

            messages.insertAdjacentHTML('beforeend', `
                <div id="message-${message.id}" class="${mine ? 'text-right' : ''}">
                    <div class="inline-block max-w-xl px-4 py-3 rounded-2xl shadow-sm text-left
                        ${mine ? 'bg-primary text-white' : 'bg-white'}">
                        <p>${message.message}</p>
                        <p class="text-[10px] opacity-70 mt-2 ${mine ? 'text-right' : ''}">
                            ${time}
                        </p>
                    </div>
                </div>
            `);

            messages.scrollTop = messages.scrollHeight;
        }

        async function fetchNewMessages(){
            try{
                const response = await fetch(
                    "{{ route('chat.messages',$conversation) }}?last_id=" + lastMessageId,
                    {
                        headers:{
                            "Accept":"application/json"
                        }
                    }
                );

                if(!response.ok) return;

                const data = await response.json();

                data.forEach(msg => {
                    appendMessage(msg);
                    lastMessageId = msg.id;
                });

            }catch(error){
                console.error(error);
            }
        }

        if(form){
            form.addEventListener('submit', async function(e){
                e.preventDefault();
                const text = input.value.trim();
                if(text === '') return;
                const formData = new FormData(form);

                try{
                    const response = await fetch(form.action,{
                        method:'POST',
                        headers:{
                            'X-CSRF-TOKEN':
                                document.querySelector('meta[name="csrf-token"]').content,
                            'Accept':'application/json'
                        },
                        body:formData
                    });

                    if(!response.ok) return;

                    const message = await response.json();

                    appendMessage(message);
                    lastMessageId = message.id;
                    input.value='';
                    input.focus();

                }catch(error){
                    console.error(error);
                }
            });
        }

        input.addEventListener('keydown', function(e){
            if(e.key === 'Enter' && !e.shiftKey){
                e.preventDefault();
                form.requestSubmit();
            }

        });
        setInterval(fetchNewMessages,1000);
    });
</script>
@endsection