<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $connection = 'sql_dev1901';
    //protected $connection = 'sql_dev1901';

    protected $table = 'wcfMgmtEquipments';

    protected $primaryKey = 'equID';

    protected $casts  = [
        'locationID' => 'string',
        'equID' => 'string'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'umLocationID','locationID');
    }

    public function scopeEQUClass($query, $equClass)
    {
        return $query->where('equClass', $equClass);
    }

    public function scopeFDH($query)
    {
        return $query->where('equClass','F-FDH');
    }

    public function scopeOLT($query)
    {
        return $query->where('equClass','F-OLT');
    }

    public function scopeONT($query)
    {
        return $query->where('equClass','F-ONT');
    }

    public function scopeRouter($query)
    {
        return $query->where('equClass','F-ROUTER');
    }

    public function scopeTelo($query)
    {
        return $query->where('equClass','F-TELO');
    }


}
