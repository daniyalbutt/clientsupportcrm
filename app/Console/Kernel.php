<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\FetchBrandLeads::class,
        \App\Console\Commands\FetchTelnyxCallData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('fetch:telnyx-data')->cron('30 3 * * *')->withoutOverlapping();
        $schedule->command('fetch:invoice-data')->cron('15 5 * * *')->withoutOverlapping();
        $schedule->command('fetch:brand-leads')->twiceDaily(3, 5)->withoutOverlapping();
        $schedule->command('fetch:transactions')->twiceDaily(2, 4)->withoutOverlapping();
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
