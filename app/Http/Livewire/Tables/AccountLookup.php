<?php

namespace App\Http\Livewire\Tables;

use App\Models\ComplexQuery;
use App\Models\LocationMaster;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class AccountLookup extends LivewireDatatable
{
    public $hideable = 'select';
    public $model = LocationMaster::class;
    public $complex = true;
    public $persistComplexQuery = true;
    public $name = 'LocationMaster';


    public function columns()
    {
        return [
            Column::name('fsa')
                ->label('FSA')
                ->hideable()
                ->filterable(),

            Column::name('locationID')
                ->label('Location ID')
                ->hideable()
                ->searchable()
                ->filterable(),

            Column::name('address')
                ->label('Service Address')
                ->hideable()
                ->searchable()
                ->filterable(),

            Column::name('city')
                ->label('City')
                ->hideable()
                ->filterable($this->cityNames),

            Column::name('customerID')
                ->label('Customer ID')
                ->hideable()
                //->filterable(['','VACWGE','VACANT','CDROPS']),
                ->filterable(),

            Column::name('customerName')
                ->label('Customer')
                ->hideable()
                ->searchable(),

            Column::name('email')
                ->label('Email')
                ->hideable(),

            Column::name('phone1')
                ->label('Phone1')
                ->hideable(),

            Column::name('phone2')
                ->label('Phone2')
                ->hideable(),

            Column::name('phone3')
                ->label('Phone3')
                ->hideable(),

            BooleanColumn::name('hasInternet')
                ->label('Internet')
                ->hideable()
                ->filterable(),

            BooleanColumn::name('hasPhone')
                ->label('Phone')
                ->hideable()
                ->filterable(),
        ];
    }

    public function getZoneNamesProperty()
    {
        return LocationMaster::distinct()->pluck(trim('zoneID'));
    }

    public function getCityNamesProperty()
    {
        return LocationMaster::distinct()->pluck(trim('city'));
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
