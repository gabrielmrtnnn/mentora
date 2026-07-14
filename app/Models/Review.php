<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'booking_session_id',
        'student_id',
        'tutor_id',
        'rating',
        'review'
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class,'student_id');
    }

    public function booking()
    {
        return $this->belongsTo(BookingSession::class,'booking_session_id');
    }
}