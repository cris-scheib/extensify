<?php

namespace App\Console\Commands;

use Helpers;
use Illuminate\Console\Command;
use App\Classes\History;
use App\Models\User;

class SyncHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron to sync playlist history';

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
        $history = new History();
        $users = User::select(
            'id',
            'token',
            'refresh_token',
            'expiration_token'
        )->get();
        foreach ($users as $user) {
            $history->syncHistory($user);
        }
    }
}
