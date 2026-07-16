<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\Tutor;
use App\Events\MessageSent;

class ChatController extends Controller
{
    private function getTutorId()
    {
        return Tutor::where('user_id', auth()->id())->value('id');
    }

    private function getConversationQuery()
    {
        $query = Conversation::with([
            'student',
            'tutor',
            'messages' => function ($q) {
                $q->latest();
            }
        ])->withCount([
            'messages as unread_count' => function ($q) {
                $q->whereNull('read_at')
                ->where('sender_id', '!=', auth()->id());
            }
        ]);

        if (auth()->user()->role == 'tutor') {

            $query->where('tutor_id', $this->getTutorId());

        } else {

            $query->where('student_id', auth()->id());

        }

        return $query;
    }

   public function index()
    {
        $conversations = $this->getConversationQuery()
            ->orderByDesc('updated_at')
            ->get();

        $totalUnread = $conversations->sum('unread_count');

        return view('chat.index', compact('conversations', 'totalUnread'));
    }

    public function start($tutorId)
    {
        $conversation = Conversation::firstOrCreate([
            'student_id' => auth()->id(),
            'tutor_id' => $tutorId
        ]);


        return redirect()->route('chat.show',$conversation);
    }

    public function show(Conversation $conversation)
    {
        $conversation->load([
            'messages.sender',
            'student',
            'tutor'
        ]);

        $conversations = $this->getConversationQuery()
            ->orderByDesc('updated_at')
            ->get();

        $totalUnread = $conversations->sum('unread_count');
        $query = Conversation::query();

        if(auth()->user()->role == 'tutor'){
            $query->where('tutor_id', $this->getTutorId());
        }else{
            $query->where('student_id', auth()->id());
        }
        $conversations = $query->orderByDesc('updated_at')->get();
        return view('chat.show', compact('conversation', 'conversations', 'totalUnread'));
    }

    public function send(Request $request, Conversation $conversation)
    {
        $request->validate([
            'message'=>'required'
        ]);

        $message = Message::create([
            'conversation_id'=>$conversation->id,
            'sender_id'=>auth()->id(),
            'message'=>$request->message
        ]);

        $conversation->touch();

        return response()->json($message);
    }

    public function messages(Request $request, Conversation $conversation)
    {
        Message::where('conversation_id', $conversation->id)
            ->whereNull('read_at')
            ->where('sender_id', '!=', auth()->id())
            ->update([
                'read_at' => now()
            ]);

        $lastId = $request->last_id ?? 0;

        $newMessages = $conversation->messages()
            ->where('id', '>', $lastId)
            ->orderBy('id')
            ->get();

        $conversations = $this->getConversationQuery()
            ->orderByDesc('updated_at')
            ->get();

        $sidebarData = $conversations->map(function ($chat) {
            $partner = auth()->id() == $chat->student_id
                ? $chat->tutor->user
                : $chat->student;

            return [
                'id' => $chat->id,
                'partner' => $partner->name,
                'initial' => strtoupper(substr($partner->name, 0, 1)),
                'last_message' => optional($chat->messages->first())->message ?? 'Belum ada pesan',
                'unread' => $chat->unread_count,
            ];
        });

        return response()->json([
            'messages' => $newMessages,
            'sidebar' => $sidebarData
        ]);
    }

    public function sidebar()
    {
        $conversations = $this->getConversationQuery()
            ->orderByDesc('updated_at')
            ->get();

        $result = $conversations->map(function ($chat) {

            $partner = auth()->id() == $chat->student_id
                ? $chat->tutor->user
                : $chat->student;

            return [
                'id' => $chat->id,
                'partner' => $partner->name,
                'initial' => strtoupper(substr($partner->name, 0, 1)),
                'last_message' => optional($chat->messages->first())->message
                    ?? 'Belum ada pesan',
                'unread' => $chat->unread_count,
            ];
        });

        return response()->json($result);
    }
}
