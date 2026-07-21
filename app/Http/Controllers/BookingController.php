<?php

namespace App\Http\Controllers;

use App\Models\BookingSession;
use App\Models\Tutor;
use App\Services\StudyStreakService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Menampilkan semua booking milik student
     */
    public function index()
    {
        $bookings = BookingSession::with('tutor.user')
            ->where('student_id', auth()->id())
            ->latest()
            ->get();

        return view('booking.index', compact('bookings'));
    }

    /**
     * Menampilkan form booking
     */
    public function create(Tutor $tutor)
    {
        return view('booking.create', compact('tutor'));
    }


    /**
     * Simpan booking
     */
    public function store(Request $request, Tutor $tutor)
    {
        $validated = $request->validate([
            'session_date' => 'required|date|after_or_equal:today',
            'session_time' => 'required',
            'duration'     => 'required|integer|in:60,90,120',
            'note'         => 'nullable|string|max:500',
        ]);

        BookingSession::create([
            'student_id'   => auth()->id(),
            'tutor_id'     => $tutor->id,
            'session_date' => $validated['session_date'],
            'session_time' => $validated['session_time'],
            'duration'     => $validated['duration'],
            'note'         => $validated['note'],
            'status'       => 'pending',
        ]);

        StudyStreakService::record(Auth::id());

        return redirect()
            ->route('booking.index')
            ->with('success_message', 'Booking berhasil dibuat. Menunggu persetujuan tutor.');
    }

    public function approve(BookingSession $booking)
    {
        $booking->update([
            'status'=>'approved',
            'meeting_room' => 'mentora-' . $booking->id . '-' . Str::random(8)
        ]);

        return back()->with('success', __('Booking berhasil di-approve.'));
    }

    public function reject(BookingSession $booking)
    {
        $booking->update([
            'status'=>'rejected'
        ]);

        return back()->with('success', __('Booking berhasil di-reject.'));
    }
}