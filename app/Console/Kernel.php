<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\JobQueue::class,
        \App\Console\Commands\ProcRestart::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('job:queue test --pnum=0')->everyMinute()->runInBackground();
        $schedule->command('job:queue test --pnum=1')->everyMinute()->runInBackground();
        $schedule->command('job:queue test --pnum=2')->everyMinute()->runInBackground();
        $schedule->command('job:queue test --pnum=3')->everyMinute()->runInBackground();
        $schedule->command('job:queue test --pnum=4')->everyMinute()->runInBackground();
    }
}
