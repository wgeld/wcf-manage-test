<?php

namespace App\Console\Commands;

use App\Jobs\SyncTerminationAmsObjects;
use Illuminate\Console\Command;

class ExecuteJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute created jobs';

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
     * @return int
     */
    public function handle()
    {
        SyncTerminationAmsObjects::dispatch();


        return Command::SUCCESS;
    }
}
