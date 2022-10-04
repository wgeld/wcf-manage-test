<?php

namespace App\Console\Commands;

use App\Imports\AmsApcServicesImport;
use App\Imports\OntInventoryImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportApcServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import AMS APC Configured Services';

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

        $directory = 'ams-apc-inventory-exports';
        $files = Storage::files($directory);

        foreach($files as $file) {
            if (!Str::contains($file, '~')) {
                $fileName = Str::of($file)->after('/')->before('.xlsx');

                $this->output->title('Starting: ' . $fileName);

                $importClass = (new AmsApcServicesImport());
                ($importClass)->withOutput($this->output)->import($file);

                $this->output->success('Imported AMS APC Services: ' . $fileName);

            }
        }


        return Command::SUCCESS;
    }
}
