<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Termination extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlsrv_dev';
    protected $table = 'terminations';

    protected $guarded = [];

    public function connections()
    {
        return $this->hasManyThrough(Connection::class, Location::class,'umLocationID','umLocationID','location_id');
    }

    public function accounts()
    {
        return $this->belongsTo(LocationMaster::class,'locationID','location_id');
    }

    public function amsObjects()
    {
        return $this->hasOne(AmsObjects::class,'locationId','location_id');
    }

    public function scopeHasPhone($query,$alias)
    {
        $query->addSelect([
           $alias => LocationMaster::select('hasPhone')
            ->join('terminations','terminations.location_id','ZAP_Location_Master.locationID')
            ->whereColumn('terminations.location_id','ZAP_Location_Master.locationID')
        ]);
    }
}
