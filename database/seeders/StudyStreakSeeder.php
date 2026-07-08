<?php

namespace Database\Seeders;

use App\Models\StudyStreak;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyStreakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = User::where('email','student@mentora.com')->first();

        foreach([
            today()->subDay(),
            today()->subDays(2),
            today()->subDays(3),
        ] as $date){

            StudyStreak::create([
                'user_id'=>$student->id,
                'activity_date'=>$date,
            ]);

        }
    }
}
