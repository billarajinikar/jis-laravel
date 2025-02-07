<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
        //Commands\CustomCommand::class,
        Commands\Reflectionpush1::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('jobs:update-counts')->everyEightHours();

    }
}