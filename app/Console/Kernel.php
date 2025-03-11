<?php

namespace App\Console;

use App\Events\OrderPlaced;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\AutoDeleteUser::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('user:autodelete')->hourly();
    
        $schedule->command('queue:work database --queue=processing --once')
            ->when(function () {
                return \DB::table('jobs')->exists();
            })->withoutOverlapping();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
