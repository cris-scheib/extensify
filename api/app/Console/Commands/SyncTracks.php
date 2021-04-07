<?php

namespace App\Console\Commands;

use Helpers;
use Illuminate\Console\Command;

class SyncTracks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synchronize:tracks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron to sync all tracks';

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
    public function handle(){
        

    }
}