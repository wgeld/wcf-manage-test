<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    protected $connection = 'sqlcisprod';

    protected $table = 'UM00600';

    protected $primaryKey = 'umLocationID';

    protected $casts  = [
        'umLocationID' => 'string'
    ];

    protected $maps = [
        'umLocationID' => 'id',
        'umBillToCust' => 'customer_id',
        'umLocClass' => 'location_class',
        'umZoneID' => 'zone_id',
        'umServiceAddressCode' =>   'address_id'
    ];

    protected $hidden = [
        'umLocationID',
        'umBillToCust',
        'umLocationType',
        'umLocClass',
        'umServiceAddressCode',
        'umBudgetPlanEligibility',
        'umAddrType',
        'umZoneID',
        'umBillToCustType',
        'umOwner',
        'umTenantCustNum',
        'umAccumType',
        'AccumMasterID',
        'umMinBill',
        'umLastBill',
        'umLastStatementDate',
        'umLastStatementAmount',
        'umDateCreated',
        'umDateModified',
        'NOTEINDX',
        'ADRSCODE',
        'umMaxBill',
        'umLandlordCustomerNumber',
        'umBudgetType',
        'umNoExtension',
        'umServiceDate',
        'umAccumulateEnergy',
        'umMultiCompanyID',
        'DEX_ROW_ID'
    ];

    protected $appends = [
        'id',
        'customer_id',
        'account_number',
        //'location_class',
        'zone_id',
        //'address_id'
    ];

    public function getIdAttribute()
    {
        return trim($this->attributes['umLocationID']);
    }
    public function getCustomerIdAttribute()
    {
        return trim($this->attributes['umBillToCust']);
    }
    public function getLocationClassAttribute()
    {
        return trim($this->attributes['umLocClass']);
    }
    public function getZoneIdAttribute()
    {
        return trim($this->attributes['umZoneID']);
    }
    public function getAddressIdAttribute()
    {
        return trim($this->attributes['umServiceAddressCode']);
    }
    public function getAccountNumberAttribute()
    {
        return trim($this->attributes['umLocationID']) . '-' . trim($this->attributes['umBillToCust']);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'CUSTNMBR', 'umBillToCust');
    }

    public function customerContact()
    {
        return $this->hasOneThrough(CustomerContact::class, Customer::class,'CUSTNMBR', 'CUSTNMBR','umBillToCust','CUSTNMBR');
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'locationID','umLocationID');
    }

    public function serviceAddress()
    {
        return $this->hasOne(ServiceAddress::class, 'umAddressCode','umServiceAddressCode');
    }

    public function userDefines()
    {
        return $this->hasMany(UserDefinedLocation::class, 'umLocationID','umLocationID');
    }
    public function connections()
    {
        return $this->hasMany(Connection::class, 'umLocationID','umLocationID');
    }
    public function connectionsHistory()
    {
        return $this->hasMany(ConnectionHistory::class, 'umLocationID','umLocationID');
    }
    public function getLocationsAttribute()
    {
        $locations = $this->toArray();
        $customer = $this->customer->toArray();
        $customerContact = $this->customerContact->toArray();
        $equipments = $this->equipments->toArray();
        $serviceAddress = $this->serviceAddress->toArray();
        $userDefines = $this->userDefines->toArray();
        $connections = $this->connections->toArray();
        $connectionsHistory = $this->connectionsHistory->toArray();

        $locationMerged = array_merge($customer,$customerContact,$serviceAddress,$locations);

        foreach($userDefines as $userDefine)
        {
            $detailIndex = data_get($userDefine, 'detail_index', '');
            $userDefined = data_get($userDefine, 'user_defined', '');

            $locationMerged[$detailIndex] = $userDefined;
        }

        //$locationMerged['equipments'] = $equipments;
        //$locationMerged['connections'] = $connections;
        //$locationMerged['connections_history'] = $connectionsHistory;
        //$locationMerged['userDefines'] = $userDefines;

        return $locationMerged;
        //return array_merge($customer,$customerContact,$serviceAddress);
        //return  $customer->merge($customerContact)->merge($equipment)->merge($serviceAddress)->merge($userDefined);

        //return $this->serviceAddress()->union($this->customer()->toBase())->union($this->customerContact()->toBase())->union($this->userDefined()->toBase());
    }

    public function scopeNoLock($query)
    {
        return $query->from(DB::raw(self::getTable() . ' with (nolock)'));
    }

    public function scopeNoVacant($query)
    {
        return $query->where('umBillToCust', 'not like', "%VAC%");
    }
}
