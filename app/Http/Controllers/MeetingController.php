<?php

namespace App\Http\Controllers;

use App\Models\BookingSession;

class MeetingController extends Controller
{
    public function index(BookingSession $booking)
    {
        abort_unless(
            auth()->id()==$booking->student_id ||
            auth()->id()==$booking->tutor->user_id,
            403
        );

        return view('meeting.index', compact('booking'));
    }
}