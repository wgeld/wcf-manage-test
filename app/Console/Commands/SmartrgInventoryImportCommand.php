<?php

namespace App\Console\Commands;

use App\Imports\SmartrgInventoryImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SmartrgInventoryImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:smartrgInventory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the recently shipped SmartRG Routers';

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

        $directory = 'smartrg-inventory-imports';
        $files = Storage::files($directory);

        foreach($files as $file) {
            if (!Str::contains($file, '~')) {
                $fileName = Str::of($file)->after('/')->before('.csv');

                $this->output->title('Starting: ' . $fileName);


                $importClass = (new SmartrgInventoryImport());
                ($importClass)->withOutput($this->output)->import($file);

                $this->output->success('Imported SmartRG Inventory: ' . $fileName);

            }
        }
        return 0;
    }
}
