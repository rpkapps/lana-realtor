<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MLS\GFBRConnector;
use Illuminate\Support\Facades\Log;


class SyncMls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mls:sync
                            {--swo : Sync MLS listings without overwriting existing listings}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all MLSs';

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
        $startTime = microtime(true);
        Log::info('======================= MLS sync started =======================');

        $gfbrMlsConnector = new GFBRConnector([
            'loginUrl' => env('MLS_GFBR_LOGIN_URL'),
            'username' => env('MLS_GFBR_USERNAME'),
            'password' => env('MLS_GFBR_PASSWORD')
        ], $this->options('syncWithoutOverride'));

        $gfbrMlsConnector->pullAndSync();

        Log::info('======================= MLS sync ended (' . (microtime(true) - $startTime) . 's) =======================' );
    }
}
