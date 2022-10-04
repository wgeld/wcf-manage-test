<?php

namespace App\Console\Commands;

use App\Imports\OntInventoryImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OntInventoryImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:ontInventory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the recently shipped ONTs';

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

        $directory = 'ont-inventory-imports';
        $files = Storage::files($directory);

        foreach($files as $file) {
            if (!Str::contains($file, '~')) {
                $fileName = Str::of($file)->after('/')->before('.csv');

                $this->output->title('Starting: ' . $fileName);


                $importClass = (new OntInventoryImport());
                ($importClass)->withOutput($this->output)->import($file);

                $this->output->success('Imported ONT Inventory: ' . $fileName);

            }
        }
        return 0;
    }
}
