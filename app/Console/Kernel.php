<?php

namespace App\Console;

use App\Statistic;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Http\Controllers\EventExpireAutoMailController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filePath = storage_path('logs/schedule.log');
        // $schedule->command('inspire')
        //          ->hourly();

        // Update Calendar statistics
        $schedule->call(function () {
            Statistic::updateStatistics();
        })->daily()
            ->appendOutputTo($filePath)
            ->emailOutputTo(env('WEBMASTER_MAIL'));

        // Take a daily backup
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');
        
        /*  Send an email to the organizers of the repetitive 
        events that are expiring in one week */
        $schedule->call(function () {
            EventExpireAutoMailController::check();
        })->daily()
            ->appendOutputTo($filePath)
            ->emailOutputTo(env('WEBMASTER_MAIL'));
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
