<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSession extends Model
{
    protected $fillable = [

        'student_id',
        'tutor_id',
        'session_date',
        'session_time',
        'duration',
        'note',
        'meeting_room',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(User::class,'student_id');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}