<?php

namespace App\Console\Commands;

use Helpers;
use Illuminate\Console\Command;
use App\Classes\Artists;
use App\Models\User;

class SyncFavoriteArtists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:favorite-artists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron to sync all favorites artists';

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
        $artists = new Artists();
        $users = User::select(
            'id',
            'token',
            'refresh_token',
            'expiration_token'
        )->get();
        foreach ($users as $user) {
            $artists->syncFavoriteArtists($user);
        }
    }
}
