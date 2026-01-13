<?php

namespace App\Console;

use App\Console\Commands\SwapiResetCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SynchronizeStarWars::class,
        SwapiResetCommand::class,
    ];

    protected function schedule(Schedule $schedule):void
    {
        $schedule->job(new \App\Jobs\SynchronizePlanetsJob())
            ->everyOddHour()
            ->withoutOverlapping()
            ->onOneServer();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        parent::commands();

        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
