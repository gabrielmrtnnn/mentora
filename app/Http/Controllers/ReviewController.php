<?php

namespace App\Http\Controllers;

use App\Models\BookingSession;
use App\Models\Review;
use App\Models\Tutor;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking_sessions,id', 
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string'
        ]);

        $booking = BookingSession::findOrFail($request->booking_id);

        $existingReview = Review::where('booking_session_id', $booking->id)->first();
        if ($existingReview) {
            return back()->with('error', __('Kamu sudah memberikan review untuk sesi ini.'));
        }

        $review = Review::create([
            'booking_session_id' => $booking->id,
            'student_id'         => auth()->id(),
            'tutor_id'           => $booking->tutor_id,
            'rating'             => $request->rating,
            'review'             => $request->comment,
        ]);

        
        $tutor = Tutor::findOrFail($booking->tutor_id);
        
        $tutor->rating = round($tutor->reviews()->avg('rating'), 1);
        $tutor->total_reviews  = $tutor->reviews()->count();
        
        $tutor->save();

        return back()->with('success', __('Review berhasil dikirim!'));
    }
}