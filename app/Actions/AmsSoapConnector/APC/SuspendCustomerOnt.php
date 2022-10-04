<?php

namespace App\Actions\AmsSoapConnector\APC;



use App\API\AMSSoapConnector;
use App\Models\AmsObjects;
use App\Models\Equipment;
use App\Models\LocationMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SuspendCustomerOnt
{

    public function suspend($equipmentId)
    {
        $equipment = Equipment::find($equipmentId);
        $object = AmsObjects::select('amsServerName','neName','apcONTObjectName')->where('equipmentId',$equipment->equID)->first();
        $hasPhone = LocationMaster::where('locationID','=',$equipment->locationID)->first();
        //dd($object);

        if($hasPhone){
            DowngradeServiceToPhoneOnly::downgrade($object);
        }

        $parameters = [
            'amsServer' => $object->amsServerName,
            'objectName' => $object->apcONTObjectName,
            'templateName' => 'O.HSI_010',//$object->templateName,
            //'templateVersion' => $object->templateVersion
            'operationInitiator' => 'wcfManage/'. (string)Str::of(Auth::user()->email)->before('@')
        ];
        //dd($parameters);
        $amsSoapConnector = new AMSSoapConnector;

        $response = $amsSoapConnector->suspend($parameters);
        //dd($response);
        return json_encode($response);
    }

}
