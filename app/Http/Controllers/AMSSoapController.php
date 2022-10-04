<?php

namespace App\Http\Controllers;

use App\API\AMSSoapConnector;
use App\Models\AmsObjects;
use App\Models\ApcTemplates;
use App\Models\Equipment;
use App\Models\SdcParameters;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AMSSoapController extends Controller
{
    public function sdcForm()
    {
		$sdcParameters = SdcParameters::select('counter_name')
            ->distinct()
            ->where('enabled_for_connector',1)
            ->get();
		//dd($sdcParameters);
		$amsServers = AmsObjects::select('amsServerName')
            ->distinct()
            ->get();

        $neNames = AmsObjects::select('neName')
            ->distinct()
            ->get();

        return view('sdc.form', compact('sdcParameters','amsServers','neNames'));
    }

    public function sdcFormChange($counterName)
    {
        $propertyNames = SdcParameters::select('path')
            ->where('enabled_for_connector',1)
            ->where('counter_name',$counterName)
            ->distinct()
            ->get();

        $parameterNames = SdcParameters::select('sdc_parameter_name')
            ->where('enabled_for_connector',1)
            ->where('counter_name',$counterName)
            ->distinct()
            ->get();

        $propertyNames = collect($propertyNames->toArray());

        //dd($propertyNames);
        foreach($propertyNames as $propertyName){
            //dd($propertyName);
            if(str_contains($propertyName['path'],';')){
                $newPropertyNames = explode(';',$propertyName['path']);
                foreach($newPropertyNames as $newPropertyName){
                    $trimmedPropertyNames[] = [
                        'path' => trim($newPropertyName)
                    ];
                }

            }
        }
        //dd($trimmedPropertyNames);
        $propertyNames = isset($trimmedPropertyNames) ? collect($trimmedPropertyNames) : $propertyNames;
        $parameterNames = collect($parameterNames->toArray());
        $counterNameParameters = $propertyNames->merge($parameterNames);
        //dd($counterNameParameters);
        return $counterNameParameters->toJson(JSON_UNESCAPED_SLASHES);
    }

    public function sdcServerFormChange($amsServer)
    {
        //dd($amsServer);
        $neNames = AmsObjects::select('neName')
            ->where('amsServerName',$amsServer)
            ->distinct()
            ->get();

        $neNames = collect($neNames->toArray());

        return $neNames->toJson(JSON_UNESCAPED_SLASHES);
    }

    public function sdcRequest(Request $request)
    {
        $values = $request->all();
        //dd($values);
        $objectName = str_replace_first('[rackNr]',$request->rack,$request->propertyName);
        //dd($objectName);
        $objectName = str_replace_first('[subrackNr]',$request->subrack,$objectName);
        $objectName = str_replace_first('[slotNr]',$request->lt,$objectName);
        $objectName = str_replace_first('[portNr]',$request->pon,$objectName);
        $objectName = str_replace_first('[ontNr]',$request->ont,$objectName);


        $parameters = [
            'amsServer' => $request->amsServer,
            'neName' => $request->neName,
            'type' => $request->type,
            'propertyName' => $objectName,
            'pmParameters' => $request->pmParameters
        ];

        //dd($parameters);

        $amsSoapConnector = new AMSSoapConnector;

        $response = $amsSoapConnector->getPerformanceMonitoringData($parameters);
        dd($response);
        return $response;
    }

    public function apcGetConfiguredTemplate(Request $request)
    {

    }

    public function getConfiguredServicesByEquipmentID($id)
    {
        $equipment = Equipment::find($id);
        $object = AmsObjects::select('amsServerName','neName','apcONTObjectName')->where('equipmentId',$equipment->equID)->first();
        //dd($object);

        $parameters = [
            'amsServer' => $object->amsServerName,
            'objectName' => $object->apcONTObjectName,
            'templateName' => 'O.HSI_010'//$object->templateName,
            //'templateVersion' => $object->templateVersion
        ];
        //dd($parameters);
        $amsSoapConnector = new AMSSoapConnector;

        $response = $amsSoapConnector->getConfiguredServices($parameters);
        //dd($response);
        $response['amsServerName'] = $object->amsServerName;
        return json_encode($response);
    }
    public function resumeByOntObjectName($ontObjectName)
    {
        $object = AmsObjects::select('amsServerName','neName','apcONTObjectName')->where('apcONTObjectName',$ontObjectName)->first();
        //dd($object);

        $parameters = [
            'amsServer' => $object->amsServerName,
            'objectName' => $object->apcONTObjectName,
            'templateName' => 'O.HSI_010',//$object->templateName,
            //'templateVersion' => $object->templateVersion
            'operationInitiator' => 'wcfManage/'. Auth::user()->email
        ];
        //dd($parameters);
        $amsSoapConnector = new AMSSoapConnector;

        $response = $amsSoapConnector->resume($parameters);
        //dd($response);
        return json_encode($response);
    }
    public function resumeByEquipmentID($id)
    {
        $equipment = Equipment::find($id);
        $object = AmsObjects::select('amsServerName','neName','apcONTObjectName')->where('equipmentId',$equipment->equID)->first();
        //dd($object);

        $parameters = [
            'amsServer' => $object->amsServerName,
            'objectName' => $object->apcONTObjectName,
            'templateName' => 'O.HSI_010',//$object->templateName,
            //'templateVersion' => $object->templateVersion
            'operationInitiator' => 'wcfManage/'. Auth::user()->email
        ];
        //dd($parameters);
        $amsSoapConnector = new AMSSoapConnector;

        $response = $amsSoapConnector->resume($parameters);
        //dd($response);
        return json_encode($response);
    }

    public function suspendByOntObjectName($ontObjectName)
    {

        $object = AmsObjects::select('amsServerName','neName','apcONTObjectName')->where('apcONTObjectName',$ontObjectName)->first();
        //dd($object);

        $parameters = [
            'amsServer' => $object->amsServerName,
            'objectName' => $object->apcONTObjectName,
            'templateName' => 'O.HSI_010',//$object->templateName,
            //'templateVersion' => $object->templateVersion
            'operationInitiator' => 'wcfManage/'. Auth::user()->email
        ];
        return $parameters;

        $amsSoapConnector = new AMSSoapConnector;

        $response = $amsSoapConnector->suspend($parameters);
        //dd($response);
        return json_encode($response);
    }
    public function suspendByEquipmentID($id)
    {
        $equipment = Equipment::find($id);
        $object = AmsObjects::select('amsServerName','neName','apcONTObjectName')->where('equipmentId',$equipment->equID)->first();
        //dd($object);

        $parameters = [
            'amsServer' => $object->amsServerName,
            'objectName' => $object->apcONTObjectName,
            'templateName' => 'O.HSI_010',//$object->templateName,
            //'templateVersion' => $object->templateVersion
            'operationInitiator' => 'wcfManage/'. Auth::user()->email
        ];
        //dd($parameters);
        $amsSoapConnector = new AMSSoapConnector;

        $response = $amsSoapConnector->suspend($parameters);
        //dd($response);
        return json_encode($response);
    }

    public function modify(Request $request)
    {
        $parameters = $request->toArray();
        $parameters['operationInitiator'] = 'wcfManage/'. Auth::user()->email;
        //dd($requestArray);

        //dd($parameters);
        $amsSoapConnector = new AMSSoapConnector;

        $response = $amsSoapConnector->modify($parameters);
        //dd($response);
        return json_encode($response);
    }

    public function configure(Request $request)
    {

        $parameters = $request->toArray();


        $amsServer = AmsObjects::select('amsServerName')->where('neName',$parameters['neName'])->first();

        $parameters['amsServer'] = $amsServer->amsServerName;
        $parameters['operationInitiator'] = 'wcfManage/'. Auth::user()->username;
        //dd($parameters);
        $amsSoapConnector = new AMSSoapConnector();

        $response = $amsSoapConnector->configure($parameters);

        if(isset($response['message']))
        {
            $customError = $response['message'];
            return redirect()->route('manualprovision')->with('customError', $customError);
        }else{
            $success = 'Successfully Provisioned!';
            return redirect()->route('manualprovision')->with('success', $success);
        }


    }

    public function nextAvailableONTByPon(Request $request)
    {
        //dd($request);
        $requestArray = $request->toArray();
        $amsServer = AmsObjects::select('amsServerName')->where('neName',$requestArray['neName'])->first();

        //dd($amsServer);
        $checkPonPath = explode('-', $requestArray['ponPath']);
        if(count($checkPonPath) === 4)
        {
            $parameters = [
                'amsServer' => $amsServer->amsServerName,
                'objectName'=> $requestArray['neName'].':'.$requestArray['ponPath'],
                'arguments'=>[
                 'nextFreeOntId'
                ]
            ];
        }else{
            return 'Wrong Format For Pon Path!';
        }

        $amsSoapConnector = new AMSSoapConnector;
        $response = $amsSoapConnector->nextAvailableONTByPon($parameters);

        $apcONTObjectName = $requestArray['neName'].':'.$requestArray['ponPath'].'-'.$response['ontId'];

        $vlans = AmsObjects::select('cvlan', 'svlan')->where('apcONTObjectName',$apcONTObjectName)->first();

        //dd($response);
        $response['cvlan'] = $vlans->cvlan;
        $response['svlan'] = $vlans->svlan;
        $response['objectName'] = $apcONTObjectName;
        return json_encode($response);


    }


    public function modifyTemplate(Request $request)
    {
        dd($request);
        $requestArray = $request->toArray();
        dd($requestArray);

    }

    public function templateConfigurableAttributes()
    {
        $template = ApcTemplates::select('VA_usBwProfile_Options','VA_dsSchedulerProfile_Options','VA_customerID_Options')->first();
        $attributes = [
            'VA_usBwProfile_Options' => $template->VA_usBwProfile_Options,
            'VA_dsSchedulerProfile_Options' => $template->VA_dsSchedulerProfile_Options,
            'VA_customerID_Options' => $template->VA_customerID_Options
        ];

        return json_encode($attributes, JSON_UNESCAPED_SLASHES);
    }

    public function templateNENames()
    {
        $neNames = ApcTemplates::select('neName')->get();

        return $neNames->toJSON();
    }

    public function templateAttributesByNE($neName)
    {
        $template = ApcTemplates::select(
            'id',
            'templateName',
            'templateVersion',
            'VA_cvlanId',
            'VA_dsSchedulerProfile',
            'VA_dsSchedulerProfile_Options',
            'VA_svlanId',
            'VA_usBwProfile',
            'VA_usBwProfile_Options',
            'VA_customerID',
            'VA_customerID_Options',
            'config_BatteryPowerShedding_PowerShedProfile',
            'identification_Version_DownloadedSoftware',
            'ontBatteryBackup',
            'ontSerialNumber',
            'ontSoftwarePlannedVersion',
            'ontSubscriberId1',
            'ontSubscriberId2',
            'oper_NumberOfDataPorts',
            'maxNumberOfMacAddresses')
            ->where('neName',$neName)
            ->first();


        $attributes = [
            'id'                                          => $template->id,
            'templateName'                                => $template->templateName,
            'templateVersion'                             => $template->templateVersion,
            'VA_cvlanId'                                  => $template->VA_cvlanId,
            'VA_dsSchedulerProfile'                       => $template->VA_dsSchedulerProfile,
            'VA_dsSchedulerProfile_Options'               => $template->VA_dsSchedulerProfile_Options,
            'VA_svlanId'                                  => $template->VA_svlanId,
            'VA_usBwProfile'                              => $template->VA_usBwProfile,
            'VA_usBwProfile_Options'                      => $template->VA_usBwProfile_Options,
            'VA_customerID'                               => $template->VA_customerID,
            'VA_customerID_Options'                       => $template->VA_customerID_Options,
            'config_BatteryPowerShedding_PowerShedProfile' => $template->config_BatteryPowerShedding_PowerShedProfile,
            'identification_Version_DownloadedSoftware'  => $template->identification_Version_DownloadedSoftware,
            'ontBatteryBackup'                            => $template->ontBatteryBackup,
            'ontSerialNumber'                             => $template->ontSerialNumber,
            'ontSoftwarePlannedVersion'                   => $template->ontSoftwarePlannedVersion,
            'ontSubscriberId1'                            => $template->ontSubscriberId1,
            'ontSubscriberId2'                            => $template->ontSubscriberId2,
            'oper_NumberOfDataPorts'                      => $template->oper_NumberOfDataPorts,
            'maxNumberOfMacAddresses'                     => $template->maxNumberOfMacAddresses
        ];

        return json_encode($attributes, JSON_UNESCAPED_SLASHES);
    }

    public function updateTemplateDefaults(Request $request,$id)
    {
        //dd($request);
        $template = ApcTemplates::find($id);

        //$template->templateName = $request->templateName;
        //$template->templateVersion = $request->templateVersion;
        $template->VA_dsSchedulerProfile = $request->VA_dsSchedulerProfile;
        //$template->VA_dsSchedulerProfile_Options = $request->VA_dsSchedulerProfile_Options;
        $template->VA_usBwProfile = $request->VA_usBwProfile;
        //$template->VA_usBwProfile_Options = $request->VA_usBwProfile_Options;
        $template->VA_customerID = $request->VA_customerID;
        //$template->VA_customerID_Options = $request->VA_customerID_Options;
        $template->ontSoftwarePlannedVersion = $request->ontSoftwarePlannedVersion;
        $template->oper_NumberOfDataPorts = $request->oper_NumberOfDataPorts;
        $template->maxNumberOfMacAddresses = $request->maxNumberOfMacAddresses;
        //dd($template);
        $template->updated_by=Auth::user()->username;
        $template->save();

        $success = 'Successfully Updated Default Template!';

        return redirect()->route('changedefaulttemplate')->with('success', $success);
    }
    public function correctTemplateAttributes()
    {
        $templates = ApcTemplates::all();
        //$template = ApcTemplates::select('*')->first();

        //dd($template);
        //dd($template->VA_usBwProfile_Options);
        //dd($template->VA_dsSchedulerProfile_Options);
        //dd($template->VA_customerID_Options);

        foreach($templates as $template) {
            $upstreamOptionsArray = [
                'Int_1000_Mb_up',
                'Int_25_Mb_up',
                'Phone_only_128_up'
            ];
            $upstreamOptions = $upstreamOptionsArray;
            //$upstreamOptions = explode(',',$upstreamOptions);
            $upstreamOptions = json_encode($upstreamOptions);
            $template->VA_usBwProfile = 'Int_1000_Mb_up';
            $template->VA_usBwProfile_Options = $upstreamOptions;

            $downstreamOptionsArray = [
                'Int_1000_Mb_Down',
                'Int_25_Mb_Down',
                'Phone_only_128_Down'
            ];
            $downstreamOptions = $downstreamOptionsArray;
            //$downstreamOptions = explode(',',$downstreamOptions);
            $downstreamOptions = json_encode($downstreamOptions);
            $template->VA_dsSchedulerProfile = 'Int_1000_Mb_Down';
            $template->VA_dsSchedulerProfile_Options = $downstreamOptions;

            $customerIDOptionsArray = [
                'Dynamic1000',
                'Dynamic1000-2',
                'Dynamic1000-3',
                'Dynamic25',
                'Static1000'
            ];
            $customerIDOptions = $customerIDOptionsArray;
            $customerIDOptions = json_encode($customerIDOptions);
            $template->VA_customerID_Options = $customerIDOptions;

            $template->save();

        }
        dd($template);
        dd($upstreamOptions);
    }

}
