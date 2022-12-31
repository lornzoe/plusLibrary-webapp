<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SteamLibraryPullMultiple_Basic;
use App\Jobs\SteamLibraryCreateMonthlySnapshot;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('queue:work')->withoutOverlapping();
        $schedule->job(new SteamLibraryPullMultiple_Basic())->hourlyAt(55);
        $schedule->job(new SteamLibraryPullMultiple_Basic())->hourlyAt(25);
        
        // hourly check on the snapshot
        $schedule->job(new SteamLibraryCreateMonthlySnapshot())->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
