<?php

namespace App\Http\Livewire\Tables;

use App\Models\ComplexQuery;
use App\Models\Connection;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Account extends LivewireDatatable
{
    public $model = Location::class;
    public $complex = true;
    public $persistComplexQuery = true;
    public $name = 'Account';

    public function builder()
    {
        return Location::query();
    }

    public function columns()
    {
        return [
            Column::name('umLocationID')
                ->label('Location ID')
                ->hideable()
                ->filterable(),

            Column::name('umBillToCust')
                ->label('Customer ID')
                ->searchable()
                ->hideable()
                ->filterable(),

            Column::name('umZoneID')
                ->label('Zone')
                ->searchable()
                ->hideable()
                ->filterable($this->zoneNames),


            Column::name('serviceAddress.umStreetNumber')
                ->label('Number')
                ->hideable(),

            Column::name('serviceAddress.umStreetName')
                ->label('Name')
                ->hideable(),

            Column::name('serviceAddress.umStreetType')
                ->label('Type')
                ->hideable(),

            Column::name('serviceAddress.umCityName')
                ->label('City')
                ->hideable(),
        ];
    }

    public function getZoneNamesProperty()
    {
        return Location::distinct()->pluck(trim('umZoneID'));
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
