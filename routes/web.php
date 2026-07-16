<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthRedirectController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\StudySessionController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\TutorDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ReviewController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication & Google OAuth
Route::get('/auth-redirect', [AuthRedirectController::class, 'handle'])->name('auth.redirect');
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// Tutor Public Profile
Route::get('/tutor', [TutorController::class, 'index'])->name('tutor');
Route::get('/tutor/{id}', [TutorController::class, 'show'])->whereNumber('id')->name('tutor.show');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Forum
    Route::get('/forum', [ForumController::class, 'index'])->name('forum');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/like', [ForumController::class, 'toggleLike'])->name('forum.like');
    Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');
    Route::post('/forum/{id}/reply', [ForumController::class, 'storeReply'])->name('forum.reply');
    Route::delete('/forum/thread/{id}', [ForumController::class, 'destroyThread'])->name('forum.thread.destroy');
    Route::delete('/forum/reply/{id}', [ForumController::class, 'destroyReply'])->name('forum.reply.destroy');
    Route::post('/forum/report', [ForumController::class, 'storeReport'])->name('forum.report');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/start/{tutor}', [ChatController::class, 'start'])->name('chat.start');
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{conversation}/messages', [ChatController::class, 'messages'])->name('chat.messages');

    // Meeting & Review
    Route::get('/meeting/{booking}', [MeetingController::class, 'index'])->name('meeting');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

    // Study Room
    Route::get('/study-room', [StudySessionController::class, 'index'])->name('study-room');
    Route::get('/study-room/stats', [StudySessionController::class, 'stats'])->name('study-room.stats');
    Route::post('/study-room/session', [StudySessionController::class, 'store'])->name('study-room.session');
    Route::post('/study-room/group', [StudySessionController::class, 'storeGroup'])->name('study.group.store');
    Route::delete('/study-room/group/{group}', [StudySessionController::class, 'destroyGroup'])->name('study.group.destroy');
    Route::get('/study-room/join/{slug}', [StudySessionController::class, 'joinGroup'])->name('study-room.join');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    // Booking
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create/{tutor}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store/{tutor}', [BookingController::class, 'store'])->name('booking.store');

    // Tutor Application (Dipindah ke sini agar user biasa bisa mendaftar)
    Route::get('/tutor/apply', [TutorController::class, 'applyPage'])->name('tutor.apply.page');
    Route::post('/tutor/apply', [TutorController::class, 'apply'])->name('tutor.apply');
});


Route::middleware(['auth', 'role:tutor'])->group(function () {
    Route::get('/tutor/dashboard', [TutorDashboardController::class, 'index'])->name('tutor.dashboard');
    
    // Booking Management
    Route::patch('/booking/{booking}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::patch('/booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');
    
    // Tutor Skills Update
    Route::patch('/profile/skills', [ProfileController::class, 'updateSkills'])->name('profile.update-skills');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Tutor Applications
    Route::get('/admin/tutor-applications', [AdminController::class, 'applications'])->name('admin.tutor');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [TutorController::class, 'reject'])->name('admin.reject'); // <-- Cek apakah ini harusnya AdminController
    
    // Reports Management
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::delete('/admin/reports/{report}', [AdminController::class, 'destroyReportedContent'])->name('admin.reports.destroy');
    Route::post('/admin/reports/{report}/dismiss', [AdminController::class, 'dismissReports'])->name('admin.reports.dismiss');
});

require __DIR__.'/auth.php';