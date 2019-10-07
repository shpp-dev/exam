<?php

namespace App\Console;

use App\Console\Commands\ClearExamRegistration;
use App\Console\Commands\FinishExam;
use App\Console\Commands\FinishExamSession;
use App\Console\Commands\RetryExamNotification;
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
        FinishExam::class,
        FinishExamSession::class,
        ClearExamRegistration::class,
        RetryExamNotification::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('exam:finish')->everyMinute();
         $schedule->command('exam:finish-session')->dailyAt('01:00');
         $schedule->command('exam:registration-clear')->dailyAt('01:00');
         $schedule->command('exam:retry-notification')->dailyAt('09:00');
         $schedule->command('backup:clean')->dailyAt('01:00');
         $schedule->command('backup:run')->dailyAt('02:00');
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
