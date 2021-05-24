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
        '\App\Console\Commands\SyncFavoriteArtists',
        '\App\Console\Commands\SyncFollowedArtists',
        '\App\Console\Commands\SyncFavoriteTracks',
        '\App\Console\Commands\SyncHistory',
        '\App\Console\Commands\SyncRecommendations',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sync:favorite-artists')->everyFiveMinutes();
        $schedule->command('sync:followed-artists')->everyFiveMinutes();
        $schedule->command('sync:favorite-tracks')->everyFiveMinutes();
        $schedule->command('sync:history')->everyFiveMinutes();
        $schedule->command('sync:recommendations')->everyFiveMinutes();
    }
}
