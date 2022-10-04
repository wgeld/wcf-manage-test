<?php

namespace App\Http\Livewire\Tables;

use App\API\AMSSoapConnector;
use App\Models\AmsObjects;
use App\Models\ComplexQuery;
use App\Models\Termination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Exports\DatatableExport;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class TerminationsTable extends LivewireDatatable
{
    public $hideable = 'select';
    public $model = Termination::class;
    public $name = 'Terminations';
    public $beforeTableSlot = 'components.flash-messages';
    public $complex = true;
    public $persistComplexQuery = true;
    public $exportable = true;

    //public AMSSoapConnector $amsSoapConnector;

    public function columns()
    {
        return [
            Column::name('location_id')
                ->label('Location ID')
                ->link('https://wcfmanage.wge.org/locations/show/{{location_id}}')
                ->searchable()
                ->hideable(),

            Column::name('customer_id')
                ->label('Customer ID')
                ->searchable()
                ->hideable(),

            Column::name('customer_name')
                ->label('Customer Name')
                ->hideable(),

            Column::name('service_address')
                ->label('Service Address')
                ->hideable(),

            BooleanColumn::name('has_phone_service')
                ->label('Phone')
                ->filterable()
                ->hideable(),

            BooleanColumn::name('is_suspended')
                ->label('Suspended')
                ->filterable()
                ->hideable(),

            Column::name('suspend_state')
                ->label('Suspend State')
                ->filterable()
                ->hideable(),

            Column::name('ont_object_name')
                ->label('AMS Object')
                ->hideable(),

            Column::callback(['ont_object_name'], function ($ontObjectName) {
                return view('livewire.suspend-resume-terminations', ['ontObjectName' => $ontObjectName]);
            })->label('Modify Configured Service')
                ->unsortable()
                ->excludeFromExport(),

            Column::callback(['id'], function ($id) {
                return view('livewire.datatables.delete', ['value' => $id]);
            })->label('Delete')
                ->unsortable()
                ->excludeFromExport(),

        ];
    }

    public function saveQuery($name, $rules)
    {
        Auth::user()->complexQueries()->create([
            'table' => $this->name,
            'name' => $name,
            'rules' => $rules
        ]);

        $this->emit('updateSavedQueries', $this->getSavedQueries());
    }

    public function deleteQuery($id)
    {
        ComplexQuery::destroy($id);

        $this->emit('updateSavedQueries', $this->getSavedQueries());
    }

    public function getSavedQueries()
    {
        return Auth::user()->complexQueries()->where('table', $this->name)->get();
    }

    /**
     * We are overriding the export function in Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable, so we can create our own File Name.
     * At least until the package includes an option to set the filename.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $this->forgetComputed();

        $results = $this->mapCallbacks(
            $this->getQuery()->when(count($this->selected), function ($query) {
                return $query->havingRaw('checkbox_attribute IN (' . implode(',', $this->selected) . ')');
            })->get(),
            true
        )->map(function ($item) {
            return collect($this->columns)->reject(function ($value, $key) {
                return $value['preventExport'] == true || $value['hidden'] == true;
            })->mapWithKeys(function ($value, $key) use ($item) {
                return [$value['label'] ?? $value['name'] => $item->{$value['name']}];
            })->all();
        });

        return Excel::download(new DatatableExport($results), $this->name . 'Export_' . Carbon::now()->toDateString() . '.xlsx');
    }

    public function suspend($ontObjectName)
    {
        $amsObject = AmsObjects::select('amsServerName', 'neName', 'apcONTObjectName')->where('apcONTObjectName', $ontObjectName)->first();

        $parameters = [
            'amsServer' => $amsObject->amsServerName,
            'objectName' => $amsObject->apcONTObjectName,
            'templateName' => 'O.HSI_010',
            'operationInitiator' => 'wcfManage/' . Auth::user()->email
        ];

        $amsSoapConnector = new AMSSoapConnector;
        $response = $amsSoapConnector->suspend($parameters);

        $this->model::where('ont_object_name', $ontObjectName)->update(['is_suspended' => true]);
        $this->refreshLivewireDatatable();

        session()->flash('successMessage', 'Successful Suspending on ' . $ontObjectName);
    }

    public function resume($ontObjectName)
    {
        $amsObject = AmsObjects::select('amsServerName', 'neName', 'apcONTObjectName')->where('apcONTObjectName', $ontObjectName)->first();

        $parameters = [
            'amsServer' => $amsObject->amsServerName,
            'objectName' => $amsObject->apcONTObjectName,
            'templateName' => 'O.HSI_010',
            'operationInitiator' => 'wcfManage/' . Auth::user()->email
        ];

        $amsSoapConnector = new AMSSoapConnector;
        $response = $amsSoapConnector->resume($parameters);

        $this->model::where('ont_object_name', $ontObjectName)->update(['is_suspended' => false]);
        $this->refreshLivewireDatatable();

        session()->flash('successMessage', 'Successful Resuming on ' . $ontObjectName);

    }

    public function downgradeServicePhoneOnly($ontObjectName)
    {
        $amsObject = AmsObjects::select('amsServerName', 'neName', 'apcONTObjectName')->where('apcONTObjectName', $ontObjectName)->first();

        $parameters = [
            'amsServer' => $amsObject->amsServerName,
            'objectName' => $amsObject->apcONTObjectName,
            'templateName' => 'O.HSI_010',
            'operationInitiator' => 'wcfManage/' . Auth::user()->email,
            'arguments' => [
                'VA_dsSchedulerProfile' => $amsObject->amsServerName === 'WGE_5520' ? 'Int_200_Mb_Down' : 'Phone_only_128_Down', //for testing purposes
                'VA_usBwProfile' => $amsObject->amsServerName === 'WGE_5520' ? 'Int_200_Mb_up' : 'Phone_only_128_up' //for testing purposes
            ]
        ];

        $amsSoapConnector = new AMSSoapConnector;
        $response = $amsSoapConnector->modify($parameters);

        if (isset($response['RemoteApcException'])) {
            //dd((string)$response['RemoteApcException']['message']);
            $errorMessage = (string)$response['RemoteApcException']['message'];
            session()->flash('errorMessage', $errorMessage);
        } else {
            $this->model::where('ont_object_name', $ontObjectName)->update(['is_suspended' => true]);
            $this->refreshLivewireDatatable();

            session()->flash('successMessage', 'Successful Service Downgrade on ' . $ontObjectName);
        }
    }

    public function upgradeServiceGigabit($ontObjectName)
    {
        $amsObject = AmsObjects::select('amsServerName', 'neName', 'apcONTObjectName')->where('apcONTObjectName', $ontObjectName)->first();

        $parameters = [
            'amsServer' => $amsObject->amsServerName,
            'objectName' => $amsObject->apcONTObjectName,
            'templateName' => 'O.HSI_010',
            'operationInitiator' => 'wcfManage/' . Auth::user()->email,
            'arguments' => [
                'VA_dsSchedulerProfile' => 'Int_1000_Mb_Down',
                'VA_usBwProfile' => 'Int_1000_Mb_up'
            ]
        ];

        $amsSoapConnector = new AMSSoapConnector;
        $response = $amsSoapConnector->modify($parameters);

        if (isset($response['RemoteApcException'])) {
            //dd((string)$response['RemoteApcException']['message']);
            $errorMessage = (string)$response['RemoteApcException']['message'];
            session()->flash('errorMessage', $errorMessage);
        } else {
            $this->model::where('ont_object_name', $ontObjectName)->update(['is_suspended' => false]);
            //$this->emit('refreshLivewireDatatable');
            $this->refreshLivewireDatatable();
            session()->flash('successMessage', 'Successful Service Upgrade on ' . $ontObjectName);
        }

    }

    public function upgradeService25mb($ontObjectName)
    {
        $amsObject = AmsObjects::select('amsServerName', 'neName', 'apcONTObjectName')->where('apcONTObjectName', $ontObjectName)->first();

        $parameters = [
            'amsServer' => $amsObject->amsServerName,
            'objectName' => $amsObject->apcONTObjectName,
            'templateName' => 'O.HSI_010',
            'operationInitiator' => 'wcfManage/' . Auth::user()->email,
            'arguments' => [
                'VA_dsSchedulerProfile' => 'Int_25_Mb_Down',
                'VA_usBwProfile' => 'Int_25_Mb_up'
            ]
        ];

        $amsSoapConnector = new AMSSoapConnector;
        $response = $amsSoapConnector->modify($parameters);

        if (isset($response['RemoteApcException'])) {
            //dd((string)$response['RemoteApcException']['message']);
            $errorMessage = (string)$response['RemoteApcException']['message'];
            session()->flash('errorMessage', $errorMessage);
        } else {
            $this->model::where('ont_object_name', $ontObjectName)->update(['is_suspended' => false]);
            //$this->emit('refreshLivewireDatatable');
            $this->refreshLivewireDatatable();
            session()->flash('successMessage', 'Successful Service Upgrade on ' . $ontObjectName);
        }

    }

}
