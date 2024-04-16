<?php

declare(strict_types=1);

namespace Console;

use App\Imports\SyncAllDomains;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SyncAllDomains)->everySixHours();
    }

    /**
     * Register the commands for the application.
     */
    /** @var array<mixed> */
    protected $commands = [
        \App\Console\Commands\GenerateApiToken::class,
    ];

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
