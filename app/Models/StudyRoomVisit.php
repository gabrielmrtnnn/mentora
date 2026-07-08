<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyRoomVisit extends Model
{
    protected $fillable = [
        'user_id',
        'study_group_id',
        'joined_at',
        'left_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studyGroup()
    {
        return $this->belongsTo(StudyGroup::class);
    }
}