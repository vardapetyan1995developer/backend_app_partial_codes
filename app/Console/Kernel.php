<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * @codeCoverageIgnore
 */
final class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule
            ->command('app:order:notify-tomorrow-arrival-time')
            ->dailyAt('20:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
