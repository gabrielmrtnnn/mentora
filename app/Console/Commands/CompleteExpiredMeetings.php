<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingSession;
use Carbon\Carbon;

class CompleteExpiredMeetings extends Command
{
    protected $signature = 'meeting:complete';

    protected $description = 'Automatically complete expired meetings';

    public function handle()
    {
        BookingSession::where('status', 'approved')
            ->get()
            ->each(function ($booking) {
                $end = Carbon::parse(
                    $booking->session_date . ' ' . $booking->session_time
                )->addMinutes($booking->duration);

                if (now()->greaterThan($end)) {
                    $booking->update([
                        'status' => 'completed',
                    ]);
                }
            });

        return Command::SUCCESS;
    }
}