<?php

namespace App\Console\Commands;

use App\Imports\CutsheetImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CutsheetImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    // command to import cutsheets

    protected $signature = 'import:cutsheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse and import cutsheets in directory';

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
        $directory = 'cutsheets';
        $files = Storage::files($directory);




        foreach($files as $file) {


            // checking if open
            if(!Str::contains($file,'~')) {

                    // filename is in this format cutsheets/FSA29_Cut Sheet_20220726.xlsx, need to strip off "cutsheets/" and ".xslx"
                    $fileName = Str::of($file)->after('/')->before('.xlsx');
//

////                /// Instantiate new CutSheetHelpers Objects which calls the getFileNameData method -> to return fileNameData
                    $fileNameData = (new \App\Helpers\CutsheetImportHelpers)->getFileNameData($fileName);



                     $this->output->title('Starting: ' . $fileName);

                     echo("File is now open!:\n\n");

                     // Create new CutsheetImport class and call fromFile method (not the actual constructor) //
                     //****************************************************************************************//
                     // EXAMPLE OF TRAIT VERSUS INTERFACE  An interface is like a promise that states, “this object can do this action,” while a trait is the capacity to accomplish the thing. //
//                   interface Person
//                   {
//                     public function greet();
//                     public function eat($food);
//                   }
//                   Trait EatingTrait
//                   {
//                     public function eat($food)
//                     {
//                        $this->putInMouth($food);
//                     }
//                     private function putInMouth($food)
//                     {
////                      digest delicious food
//                     }
//                    }

                     /// End Example ///
                     ///
                     ///
                     $importClass = (new CutsheetImport())->fromFile($fileNameData);

                     echo("Sucessfully created a Cutsheet Import Class Object\n\n");


                     var_dump($importClass);


                     ($importClass)->withOutput($this->output)->import($file);


                    $this->output->success('Imported Cutsheet: ' . $fileName);
//
                    $this->output->title('Executing Stored Procedure: uspFiber_Cutsheet_Imports_Update_LocationID_By_OrgDistributionPanelFSA');
//////////***** TESTING DB CONN ******** /////////////////////
//                $serverName = "sql_dev1901"; //serverName\instanceName
//
//                echo $serverName;
//
//                $connectionInfo = array( "Database"=>"wcfMgmt", "UID"=>"wcf_app", "PWD"=>"wcfapp");
//
//                var_dump($connectionInfo);
//
//                $conn = sqlsrv_connect( $serverName, $connectionInfo);
//
//                var_dump($conn);
//
//                if( $conn ) {
//                    echo "Connection established.\n";
//                }else{
//                    echo "Connection could not be established.\n";
//                    die( print_r( sqlsrv_errors(), true));
//                }
//////////***** TESTING DB CONN ******** /////////////////////

                /// *** EXECUTE SP *** ///
                    //DB::connection('sqlsrv')->statement('exec uspFiber_Cutsheet_Imports_Update_LocationID_By_OrgDistributionPanelFSA ?,?,?',[$fileNameData['organization'],$fileNameData['fsa'],$fileNameData['distributionPanel']]);
//
                    //DB::flushQueryLog();
                /// *** EXECUTE SP *** ///

                    $this->output->success('Stored Procedure Completed: ' . $fileName);
//
                    $this->output->success('Finished: ' . $fileName);

            }
        }

        echo("Should be finished here!\n\n");

        return Command::SUCCESS;
    }
}
