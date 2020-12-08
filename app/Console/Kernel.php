<?php

namespace App\Console;

use App\Console\Commands\CacheDiscordInfo;
use App\Console\Commands\CreateAdmin;
use App\Console\Commands\ImportRecords;
use App\Console\Commands\ParseLog;
use App\Console\Commands\SyncDiscordRolesWithMembers;
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
        CreateAdmin::class,
        ParseLog::class,
        ImportRecords::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(SyncDiscordRolesWithMembers::class)->everyFiveMinutes();
        $schedule->command(CacheDiscordInfo::class)->everyThreeHours();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
