<?php

namespace App\Console\Commands;

use Helpers;
use Illuminate\Console\Command;
use App\Classes\Tracks;
use App\Models\User;

class SyncFavoriteTracks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:favorite-tracks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron to sync all favorite tracks';

    public static $process_busy = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tracks = new Tracks();
        $users = User::select(
            'id',
            'token',
            'refresh_token',
            'expiration_token'
        )->get();
        foreach ($users as $user) {
            $tracks->syncFavorite($user);
        }
    }
}
