<?php

namespace App\Http\Livewire\Tables;

use App\Models\Connection;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ConnectionsTable extends LivewireDatatable
{
    public $hideable = 'select';
    public $model = Connection::class;
    public $complex = true;
    public $persistComplexQuery = true;
    public $name = 'Connections';

    public function columns()
    {
        return [
            Column::name('umLocationID')
                ->label('Location ID')
                ->hideable()
                ->filterable(),

            Column::name('location.umBillToCust')
                ->label('Customer ID')
                ->searchable()
                ->hideable()
                ->filterable(),

            Column::name('umServiceType')
                ->label('Service Type')
                ->hideable()
                ->filterable($this->serviceTypes),

            Column::name('umTariffID')
                ->label('Rate')
                ->hideable()
                ->filterable(),

            Column::name('umConnectStatus')
                ->label('Status')
                ->hideable()
                ->filterable(),

            DateColumn::name('umConnectionDate')
                ->label('Connected Date')
                ->hideable()
                ->filterable(),

            DateColumn::name('umDisconnectionDate')
                ->label('Disconnected Date')
                ->hideable()
                ->filterable(),

        ];
    }

    public function getServiceTypesProperty()
    {
        return Connection::distinct()->pluck(trim('umServiceType'));
    }
}
