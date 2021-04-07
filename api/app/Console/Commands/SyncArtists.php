<?php

namespace App\Console\Commands;

use Helpers;
use Illuminate\Console\Command;
use App\Classes\Artists;
use App\Models\Artist;

class SyncArtists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synchronize:artists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron to sync all artists';

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

        $this->artists->getArtists();

        $artists = $this->artistModel->with('genres')->get();

    }
}