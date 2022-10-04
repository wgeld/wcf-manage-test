<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;

class UserDefinedLocation extends Pivot
{
    protected $connection = 'sqlcisprod';

    protected $table = 'UMUDFLOC';

    protected $primaryKey = 'umLocationID';

    protected $casts  = [
        'umLocationID' => 'string'
    ];

    protected $maps = [
        'umLocationID' => 'location_id',
        'umUserDefined1' => 'user_defined',
        'umDetailIndex' => 'detail_index',
        'umDateCreated' => 'created_at',
        'umDateModified' => 'updated_at'
    ];

    protected $hidden = [
        'umLocationID',
        'umUserDefined1',
        'umDetailIndex',
        'USERID',
        'umDateCreated',
        'umDateModified',
        'DEX_ROW_ID'
    ];

    protected $appends = [
        'location_id',
        'user_defined',
        'detail_index',
        'created_at',
        'updated_at'
    ];

    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'umLocationID', 'umLocationID');
    }

    public function getLocationIdAttribute()
    {
        return trim($this->attributes['umLocationID']);
    }
    public function getUserDefinedAttribute()
    {
        return trim($this->attributes['umUserDefined1']);
    }
    public function getDetailIndexAttribute()
    {
        switch(trim($this->attributes['umDetailIndex'])) {
            case '1':
                return $this->attributes['umDetailIndex'] =  'engineering_street_number';
                break;
            case '2':
                return $this->attributes['umDetailIndex'] =  'tax_exempt_type';
                break;
            case '3':
                return $this->attributes['umDetailIndex'] =  'tax_exempt_year';
                break;
            case '4':
                return $this->attributes['umDetailIndex'] =  'bill_sort_first';
                break;
            case '5':
                return $this->attributes['umDetailIndex'] =  'latitude'; //'Latitude';
                break;
            case '6':
                return $this->attributes['umDetailIndex'] =  'longitude'; //'Longitude';
                break;
            case '7':
                return $this->attributes['umDetailIndex'] =  'census_tract'; //'Census Tract';
                break;
            case '8':
                return $this->attributes['umDetailIndex'] =  'census_block'; //'Census Block';
                break;
            case '9':
                return $this->attributes['umDetailIndex'] =  'oh_ug'; //'OH UG';
                break;
            case '10':
                return $this->attributes['umDetailIndex'] =  'fsa'; //'FSA';
                break;
            case '11':
                return $this->attributes['umDetailIndex'] =  'fdh_port'; //'FDH Port';
                break;
            case '12':
                return $this->attributes['umDetailIndex'] =  'mst_id'; //'MST ID';
                break;
            case '13':
                return $this->attributes['umDetailIndex'] =  'mst_port'; //'MST Port';
                break;
            case '14':
                return $this->attributes['umDetailIndex'] =  'drop_tag'; //'Drop Tag';
                break;
            case '15':
                return $this->attributes['umDetailIndex'] =  'pole_number'; //'Pole Number';
                break;
            case '16':
                return $this->attributes['umDetailIndex'] =  'pole_address'; //'Pole Address';
                break;
            case '17':
                return $this->attributes['umDetailIndex'] =  'ped_number'; //'Ped Number';
                break;
            case '18':
                return $this->attributes['umDetailIndex'] =  'ped_address'; //'Ped Address';
                break;
            case '19':
                return $this->attributes['umDetailIndex'] =  'bill_insert_tag';
                break;
            case '20':
                return $this->attributes['umDetailIndex'] =  'gas_available';
                break;
            default:
                return trim($this->attributes['umDetailIndex']);
                break;
        }
        //return trim($this->attributes['umDetailIndex']);
    }
    public function getCreatedAtAttribute()
    {
        return trim($this->attributes['umDateCreated']);
    }

    public function getUpdatedAtAttribute()
    {
        return trim($this->attributes['umDateModified']);
    }



    public function scopeNoLock($query)
    {
        return $query->from(DB::raw(self::getTable() . ' with (nolock)'));
    }

}
