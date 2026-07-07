<?php

namespace App\Http\Controllers;

use App\Models\ForumReply;
use App\Models\ForumThread;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ForumController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');

        $threads = ForumThread::with(['user', 'images'])
            ->withCount(['replies', 'likes'])
            ->latest()
            ->get();

        return view('forum.index', compact('threads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(array_keys(ForumThread::CREATABLE_CATEGORIES))],
            'body' => ['required', 'string', 'max:5000'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $thread = ForumThread::create([
            'user_id' => Auth::id(),
            'category' => $validated['category'],
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $thread->images()->create([
                    'path' => $imageFile->store('forum', 'public'),
                ]);
            }
        }

        return redirect()->route('forum')->with('success', 'Diskusi kamu berhasil diposting!');
    }

    public function show($id)
    {
        Carbon::setLocale('id');

        $thread = ForumThread::with(['user', 'likes', 'images', 'replies.user', 'replies.likes'])
            ->findOrFail($id);

        return view('forum.show', compact('thread'));
    }

    public function storeReply(Request $request, $id)
    {
        $thread = ForumThread::findOrFail($id);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        ForumReply::create([
            'forum_thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        return redirect()->route('forum.show', $thread->id)->with('success', 'Balasan kamu berhasil dikirim!');
    }

    /**
     * Toggle like/unlike buat thread ATAU balasan (satu endpoint, dibedain lewat 'type').
     * Dipanggil via AJAX dari forum/show.blade.php.
     */
    public function toggleLike(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['thread', 'reply'])],
            'id' => ['required', 'integer'],
        ]);

        $model = $validated['type'] === 'thread'
            ? ForumThread::findOrFail($validated['id'])
            : ForumReply::findOrFail($validated['id']);

        $userId = Auth::id();

        $existingLike = $model->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            $model->likes()->create(['user_id' => $userId]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $model->likes()->count(),
        ]);
    }
}
