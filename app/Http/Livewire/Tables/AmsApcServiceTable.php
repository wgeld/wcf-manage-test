<?php

namespace App\Http\Livewire\Tables;

use App\Models\AmsApcService;
use App\Models\ComplexQuery;
use Faker\Core\Number;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AmsApcServiceTable extends LivewireDatatable
{
    public $hideable = 'select';
    public $model = AmsApcService::class;
    public $name = 'ConfiguredServices';
    public $complex = true;
    public $persistComplexQuery = true;

    public function columns()
    {
        return [
            Column::name('ne_name')
            ->label('NE')
            ->filterable($this->elements),

            Column::name('target_object_name')
                ->label('Object Name')
                ->filterable(),

            Column::name('admin_state')
                ->label('State')
                ->filterable($this->adminStates),

            Column::name('ontSerialNumber')
                ->label('ONT Serial')
                ->filterable(),

            Column::name('VA_usBwProfile')
                ->label('Upstream Profile')
                ->filterable($this->upstreamProfiles),

            Column::name('VA_dsSchedulerProfile')
                ->label('Downstream Profile')
                ->filterable($this->downstreamProfiles),

            Column::name('VA_customerID')
                ->label('Circuit ID')
                ->filterable($this->circuitIds),

            Column::name('ontSubscriberId1')
                ->label('Description 1')
                ->searchable()
                ->filterable(),

            Column::name('ontSubscriberId2')
                ->label('Description 2')
                ->searchable()
                ->filterable(),

            NumberColumn::name('VA_cvlanId')
                ->hide()
                ->label('Customer VLAN')
                ->filterable(),

            NumberColumn::name('VA_svlanId')
                ->label('Service VLAN')
                ->filterable()
                ->hide(),

            Column::name('template_name')
                ->label('Template Name')
                ->filterable()
                ->hide(),

            NumberColumn::name('template_version')
                ->label('Template Version')
                ->filterable()
                ->hide(),

            NumberColumn::name('maxNumberOfMacAddresses')
                ->label('# of MACs')
                ->filterable()
                ->hide(),

            DateColumn::name('created_at')
                ->label('Imported Date')
                ->filterable()
                ->hide(),

        ];

    }
    public function getElementsProperty()
    {
        return AmsApcService::whereNotNull('ne_name')->distinct()->pluck('ne_name');
    }

    public function getUpstreamProfilesProperty()
    {
        return AmsApcService::whereNotNull('VA_usBwProfile')->distinct()->pluck('VA_usBwProfile');
    }

    public function getDownstreamProfilesProperty()
    {
        return AmsApcService::whereNotNull('VA_dsSchedulerProfile')->distinct()->pluck('VA_dsSchedulerProfile');
    }

    public function getAdminStatesProperty()
    {
        return AmsApcService::whereNotNull('admin_state')->distinct()->pluck('admin_state')->unique();
    }

    public function getCircuitIdsProperty()
    {
        return AmsApcService::whereNotNull('VA_customerID')->distinct()->pluck('VA_customerID')->unique();
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
}
