<?php

namespace App\Jobs;

use App\API\AMSSoapConnector;
use App\Models\AmsObjects;
use App\Models\Termination;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncTerminationAmsObjects implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $amsSoapConnector = new AMSSoapConnector;
        $terminations = Termination::all();

        foreach($terminations as $termination) {
            $object = AmsObjects::select('amsServerName','neName','apcONTObjectName')->where('apcONTObjectName',$termination->ont_object_name)->first();
            $parameters = [
                'amsServer' => $object->amsServerName,
                'objectName' => $object->apcONTObjectName,
                'templateName' => 'O.HSI_010'
            ];

            $response = $amsSoapConnector->getConfiguredServices($parameters);

            $termination->suspend_state = $response['suspendstate'];
            $termination->saveOrFail();

        }

    }
}
