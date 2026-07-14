<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\BookingSession;
use Carbon\Carbon;

#[Signature('meeting:complete')]
#[Description('Command description')]
class CompleteExpiredMeetings extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        BookingSession::where('status','approved')->get()->each(function($booking){
            $end = Carbon::parse(
                $booking->session_date.' '.
                $booking->session_time
            )->addMinutes($booking->duration);

            if(now()->greaterThan($end)){
                $booking->update([
                    'status'=>'completed'
                ]);
            }
        });
    }
}
