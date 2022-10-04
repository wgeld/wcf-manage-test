<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;

class Connection extends Pivot
{
    protected $connection = 'sqlcisprod';

    protected $table = 'UM00300';

    protected $primaryKey = 'umLocationID';

    protected $casts  = [
        'umLocationID' => 'string'
    ];

    protected $maps = [
        'umLocationID'              => 'location_id',
        'umConnectSeq'              => 'connection_sequence',
        'umServiceType'             => 'service_type',
        'umServiceCategory'         => 'service_category',
        'umConnectStatus'           => 'connection_status',
        'umTariffID'                => 'tariff_id',
        'umConnectionDate'          => 'connection_date',
        'umDisconnectionDate'       => 'disconnection_date',
        'UMCONNNMULT'               => 'connection_multiplier',
        'UMMULTTYPE'                => 'multiplier_type',
        'umEquipmentID'             => 'equipment_id',
        'UMFIXEDMULT'               => 'fixed_multiplier',
        'umConsumptMult'            => 'consumption_multiplier',
        'UMLOSSMULT'                => 'loss_multiplier',
        'umAlternnateConnectStatus' => 'alternate_connection_status'
    ];

    protected $appends = [
        'location_id',
        'connection_sequence',
        'service_type',
        'service_category',
        'connection_status',
        'tariff_id',
        'connection_date',
        'disconnection_date',
        'connection_multiplier',
        'multiplier_type',
        'equipment_id',
        'fixed_multiplier',
        'consumption_multiplier',
        'loss_multiplier',
        'alternate_connection_status'
    ];

    protected $visible  = [
        'location_id',
        'connection_sequence',
        'service_type',
        'service_category',
        'connection_status',
        'tariff_id',
        'connection_date',
        'disconnection_date',
        'connection_multiplier',
        'multiplier_type',
        'equipment_id',
        'fixed_multiplier',
        'consumption_multiplier',
        'loss_multiplier',
        'alternate_connection_status'
    ];

    protected $hidden  = [
        'umLocationID',
        'umConnectSeq',
        'umServiceType',
        'umServiceCategory',
        'UMMETGRPID',
        'UMMETGRPTYPE',
        'UMMULTGRPID',
        'umRouteID',
        'umConnectStatus',
        'umTariffID',
        'umConnectionDate',
        'umDisconnectionDate',
        'UMCONNMULT',
        'UMMULTTYPE',
        'umEquipmentID',
        'umUseAltMeter',
        'UMSEQNUM',
        'UMFIXEDMULT',
        'umConsumptMult',
        'UMLOSSMULT',
        'UMRNGMINMULT',
        'UMBELONGTO',
        'umMeterHousing',
        'umTransponder',
        'umChannel',
        'umImported',
        'umTaxDiscount',
        'umAlternateConnectStatus',
        'umBilled',
        'umCreatedBy',
        'umCreatedDate',
        'umRateClassID',
        'umMasterChild',
        'umMasterEquipmentID',
        'umComplianceMonitoring',
        'umCMTestType',
        'umPressureCode',
        'umDeliveredEquipmentID',
        'umVersionNumber',
        'DEX_ROW_ID'
    ];

    public function connectionHistory()
    {
        return $this->hasMany(ConnectionHistory::class, 'umLocationID','umLocationID');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'umLocationID','umLocationID');
    }

    public function getLocationIdAttribute()
    {
        return trim($this->attributes['umLocationID']);
    }

    public function getConnectionSequenceAttribute()
    {
        return trim($this->attributes['umConnectSeq']);
    }

    public function getServiceTypeAttribute()
    {
        return trim($this->attributes['umServiceType']);
    }

    public function getServiceCategoryAttribute()
    {
        switch(trim($this->attributes['umServiceCategory'])) {
            case '1':
                return $this->attributes['umServiceCategory'] =  'Electric';
                break;
            case '2':
                return $this->attributes['umServiceCategory'] =  'Water';
                break;
            case '3':
                return $this->attributes['umServiceCategory'] =  'Sewer';
                break;
            case '4':
                return $this->attributes['umServiceCategory'] =  'Gas';
                break;
            case '5':
                return $this->attributes['umServiceCategory'] =  'Phone';
                break;
            case '6':
                return $this->attributes['umServiceCategory'] =  'Other';
                break;
            case '7':
                return $this->attributes['umServiceCategory'] =  'Property Tax';
                break;
            case '8':
                return $this->attributes['umServiceCategory'] =  'Cable';
                break;
            case '9':
                return $this->attributes['umServiceCategory'] =  'Internet';
                break;
            case '10':
                return $this->attributes['umServiceCategory'] =  'Fire Protection';
                break;
            case '11':
                return $this->attributes['umServiceCategory'] =  'Sanitation';
                break;
            case '12':
                return $this->attributes['umServiceCategory'] =  'Propane';
                break;
            default:
                return trim($this->attributes['umServiceCategory']);
                break;
        }

        //return trim($this->attributes['umServiceCategory']);
    }

    public function getConnectionStatusAttribute()
    {
        // select * from UM40630
        switch(trim($this->attributes['umConnectStatus'])) {
            case '1':
                return $this->attributes['umConnectStatus'] =  'Not Yet Connected';
                break;
            case '2':
                return $this->attributes['umConnectStatus'] =  'Active';
                break;
            case '3':
                return $this->attributes['umConnectStatus'] =  'Seasonal Disconnect';
                break;
            case '4':
                return $this->attributes['umConnectStatus'] =  'Maintenance Disconnect';
                break;
            case '5':
                return $this->attributes['umConnectStatus'] =  'Collection Disconnect';
                break;
            case '6':
                return $this->attributes['umConnectStatus'] =  'Inactive';
                break;
            default:
                return trim($this->attributes['umConnectStatus']);
                break;
        }
        //return trim($this->attributes['umConnectStatus']);
    }
    public function getTariffIdAttribute()
    {
        return trim($this->attributes['umTariffID']);
    }
    public function getConnectionDateAttribute()
    {
        return trim($this->attributes['umConnectionDate']);
    }
    public function getDisconnectionDateAttribute()
    {
        return trim($this->attributes['umDisconnectionDate']);
    }
    public function getConnectionMultiplierAttribute()
    {
        return trim($this->attributes['UMCONNMULT']);
    }
    public function getMultiplierTypeAttribute()
    {
        switch(trim($this->attributes['UMMULTTYPE'])) {
            case '1':
                return $this->attributes['UMMULTTYPE'] =  'Standard';
                break;
            case '2':
                return $this->attributes['UMMULTTYPE'] =  'Fixed';
                break;
            case '3':
                return $this->attributes['UMMULTTYPE'] =  'Consumption';
                break;
            case '4':
                return $this->attributes['UMMULTTYPE'] =  'Stepped Range';
                break;
            case '5':
                return $this->attributes['UMMULTTYPE'] =  'Total Consumption';
                break;
            default:
                return trim($this->attributes['UMMULTTYPE']);
                break;
        }
        //return trim($this->attributes['UMMULTTYPE']);
    }
    public function getEquipmentIdAttribute()
    {
        return trim($this->attributes['umEquipmentID']);
    }
    public function getFixedMultiplierAttribute()
    {
        return trim($this->attributes['UMFIXEDMULT']);
    }
    public function getConsumptionMultiplierAttribute()
    {
        return trim($this->attributes['umConsumptMult']);
    }
    public function getLossMultiplierAttribute()
    {
        return trim($this->attributes['UMLOSSMULT']);
    }
    public function getAlternateConnectionStatusAttribute()
    {
        // select * from UM40630
        switch(trim($this->attributes['umAlternateConnectStatus'])) {
            case '1':
                return $this->attributes['umAlternateConnectStatus'] =  'Not Yet Connected';
                break;
            case '2':
                return $this->attributes['umAlternateConnectStatus'] =  'Active';
                break;
            case '3':
                return $this->attributes['umAlternateConnectStatus'] =  'Seasonal Disconnect';
                break;
            case '4':
                return $this->attributes['umAlternateConnectStatus'] =  'Maintenance Disconnect';
                break;
            case '5':
                return $this->attributes['umAlternateConnectStatus'] =  'Collection Disconnect';
                break;
            case '6':
                return $this->attributes['umAlternateConnectStatus'] =  'Inactive';
                break;
            default:
                return trim($this->attributes['umAlternateConnectStatus']);
                break;
        }
        //return trim($this->attributes['umAlternateConnecStatus']);
    }

    public function scopeNoLock($query)
    {
        return $query->from(DB::raw(self::getTable() . ' with (nolock)'));
    }

    public function scopeHasPhone($query)
    {
        return $query->where('umServiceCategory','5');
    }

}
