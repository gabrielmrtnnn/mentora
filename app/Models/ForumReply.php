<?php

namespace App\Models;

use App\Models\Concerns\Likeable;
use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    use Likeable;

    protected $fillable = [
        'forum_thread_id',
        'user_id',
        'body',
    ];

    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'forum_thread_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
