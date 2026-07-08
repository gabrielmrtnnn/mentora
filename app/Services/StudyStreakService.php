<?php

namespace App\Services;

use App\Models\StudyStreak;
use Carbon\Carbon;

class StudyStreakService
{
    /**
     * Mencatat bahwa user melakukan aktivitas belajar hari ini.
     */
    public static function record(int $userId): void
    {
        StudyStreak::firstOrCreate([
            'user_id' => $userId,
            'activity_date' => Carbon::today(),
        ]);
    }

    /**
     * Menghitung streak user.
     */
    public static function getCurrentStreak(int $userId): int
    {
        $dates = StudyStreak::where('user_id', $userId)
            ->orderByDesc('activity_date')
            ->pluck('activity_date')
            ->map(fn ($date) => Carbon::parse($date)->toDateString())
            ->toArray();

        if (empty($dates)) {
            return 0;
        }

        $streak = 0;

        // kalau hari ini belum ada aktivitas,
        // mulai hitung dari kemarin
        $current = in_array(Carbon::today()->toDateString(), $dates)
            ? Carbon::today()
            : Carbon::yesterday();

        while (in_array($current->toDateString(), $dates)) {
            $streak++;
            $current->subDay();
        }

        return $streak;
    }
}