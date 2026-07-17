<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\BookingSession;

class TutorDashboardController extends Controller
{
    public function index()
    {
        $tutor = Tutor::where('user_id', auth()->id())->firstOrFail();

        $totalStudents = BookingSession::where('tutor_id', $tutor->id)
            ->distinct('student_id')
            ->count('student_id');

        $upcoming = BookingSession::where('tutor_id', $tutor->id)
            ->whereDate('session_date', '>=', today())
            ->count();
        
        $today = now()->toDateString();
        $currentTime = now()->toTimeString();

        $upcomingSessions = BookingSession::with('student')
        ->where('tutor_id', $tutor->id)
        ->where('status', 'approved')
        ->where(function ($query) use ($today, $currentTime) {
            // Tanggal di masa depan ATAU (tanggal hari ini tapi jam belum lewat)
            $query->where('session_date', '>', $today)
                ->orWhere(function ($q) use ($today, $currentTime) {
                    $q->where('session_date', '=', $today)
                        ->where('session_time', '>=', $currentTime);
                });
        })
        ->orderBy('session_date', 'asc')
        ->orderBy('session_time', 'asc')
        ->take(4) // Batasi jumlah yang tampil
        ->get();

        $completed = BookingSession::where('tutor_id', $tutor->id)
            ->where('status', 'completed')
            ->count();

        $todaySessions = BookingSession::with('student')
            ->where('tutor_id', $tutor->id)
            ->whereDate('session_date', today())
            ->orderBy('session_time')
            ->get();

        $recentBookings = BookingSession::with('student')
            ->where('tutor_id', $tutor->id)
            ->latest()
            ->take(5)
            ->get();

        $pendingRequests = BookingSession::with('student')
        ->where('tutor_id', $tutor->id)
        ->where('status', 'pending')
        ->orderBy('created_at')
        ->get();

        return view('tutor.dashboard', compact(
            'tutor',
            'totalStudents',
            'upcoming',
            'upcomingSessions',
            'completed',
            'todaySessions',
            'recentBookings',
            'pendingRequests'
        ));
    }
}