<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Tambahkan role di sini
        'google_id', // Tambahkan google_id di sini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Fungsi cek role yang kamu buat sudah benar, tetap pertahankan di sini
    public function isAdmin() { 
        return $this->role === 'admin'; 
    }

    public function isTutor() { 
        return $this->role === 'tutor'; 
    }

    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class,'sender_id');
    }

    public function bookings()
    {
        return $this->hasMany(BookingSession::class,'student_id');
    }

    public function studyRoomVisits()
    {
        return $this->hasMany(StudyRoomVisit::class);
    }
}