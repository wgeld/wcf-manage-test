<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EquipmentLocations extends Pivot
{
    protected $connection = 'sqlcisprod';
    //protected $connection = 'sql_dev1901';

    protected $table = 'UM00440';

    protected $primaryKey = 'umEquipmentID';

    protected $casts  = [
        'umEquipmentID' => 'string',
        'umLocationID' => 'string'
    ];

    protected $maps = [
        'umEquipmentID' =>            'equipment_id',
        'umLocationID' =>             'location_id',
        'umMeterID' =>                'meter_id',
        //'DEX_ROW_ID' =>               '',
    ];

    protected $hidden = [
        'umEquipmentID',
        'umLocationID',
        'umMeterID',
        'DEX_ROW_ID'
    ];

    protected $appends = [
        'id',
        'equipment_id',
        'location_id',
        'meter_id',
    ];

//TODO
    public function location()
    {
        return $this->belongsTo(Location::class, 'umLocationID','locationID');
    }

}
