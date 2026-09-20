<?php

namespace App\Console;

use App\Models\GuestbookGrant;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function (): void {
            GuestbookGrant::query()
                ->where('expires_at', '<', now()->subDay())
                ->delete();
        })->daily()->name('guestbook-grants:cleanup');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
