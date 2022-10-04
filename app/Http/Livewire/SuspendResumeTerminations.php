<?php

namespace App\Http\Livewire;

use App\API\AMSSoapConnector;
use App\Models\AmsObjects;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SuspendResumeTerminations extends Component
{
    public string $equipmentId;
    public string $equID;


    public function suspend()
    {
        $object = AmsObjects::select('amsServerName','neName','apcONTObjectName')->where('equipmentId',$this->equID)->first();

        $parameters = [
            'amsServer' => $object->amsServerName,
            'objectName' => $object->apcONTObjectName,
            'templateName' => 'O.HSI_010',//$object->templateName,
            //'templateVersion' => $object->templateVersion
            'operationInitiator' => 'wcfManage/'. Auth::user()->email
        ];
        dd($parameters);
        //$amsSoapConnector = new AMSSoapConnector;

        //$response = $amsSoapConnector->suspend($parameters);


    }

    public function render()
    {
        return view('livewire.suspend-resume-terminations');
    }
}
