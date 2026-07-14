<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyStreak extends Model
{
    protected $fillable = [
        'user_id',
        'activity_date',
    ];

    protected $casts = [
        'activity_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}