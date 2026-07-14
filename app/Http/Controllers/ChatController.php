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

    public function index()
    {
        $query = Conversation::with(['student','tutor']);

        if(auth()->user()->role == 'tutor'){

            $query->where('tutor_id', $this->getTutorId());

        }else{

            $query->where('student_id', auth()->id());

        }

        $conversations = $query->orderByDesc('updated_at')->get();

        return view('chat.index', compact('conversations'));
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

        $query = Conversation::with([
            'student',
            'tutor',
            'messages' => function($q){
                $q->latest();
            }
        ]);

        if(auth()->user()->role == 'tutor'){

            $query->where('tutor_id', $this->getTutorId());

        }else{

            $query->where('student_id', auth()->id());

        }

        $conversations = $query->orderByDesc('updated_at')->get();

        return view('chat.show', compact(
            'conversation',
            'conversations'
        ));
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
        $lastId = $request->last_id ?? 0;

        return response()->json(
            $conversation->messages()
                ->where('id', '>', $lastId)
                ->orderBy('id')
                ->get()
        );
    }
}
