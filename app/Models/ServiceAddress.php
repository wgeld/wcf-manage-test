<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceAddress extends Model
{
    protected $connection = 'sqlcisprod';

    protected $table = 'UMRM0112';

    protected $primaryKey = 'umAddressCode';

    protected $casts  = [
        'umAddressCode' => 'string'
    ];

    protected $maps = [
        'umAddressCode'         => 'id',
        'umAddressCateg'        => 'address_category',
        'umStreetNumber'        => 'street_number',
        'umStreetName'          => 'street_name',
        'umStreetType'          => 'street_type',
        'umStreetDirectionP'    => 'street_direction_p',
        'umStreetDirection'     => 'street_direction',
        'umAptNumber'           => 'apartment_number',
        'umAptDescription'      => 'apartment_description',
        'umUnitDesignation'     => 'unit_designation',
        'umZipCode'             => 'zip_code',
        'umCityName'            => 'city',
        'STATE'                 => 'state',
        'COUNTRY'               => 'country'
    ];

    protected $hidden = [
        'umAddressCode',
        'ADRSCODE',
        'umAddressCateg',
        'umStreetNumber',
        'umStreetNumberLng',
        'umStrNumberSuffix',
        'umStreetName',
        'umStreetType',
        'umStreetDirectionP',
        'umStreetDirection',
        'umAptNumber',
        'umAptDescription',
        'umUnitDesignation',
        'umZipCode',
        'umCityName',
        'STATE',
        'COUNTRY',
        'Postal_Walk',
        'umPostalWalkVer',
        'umCreatedDate',
        'umModifiedDate',
        'umAptNumberPlus',
        'ADDRESS1',
        'ADDRESS2',
        'ADDRESS3',
        'umOverrideAddress',
        'umFromDate',
        'umToDate',
        'REPTING',
        'umUSAPostalCode',
        'DEX_ROW_ID'
    ];

    protected $appends = [
        //'id',
        //'address_category',
        //'street_number',
        //'street_name',
        //'street_type',
        //'street_direction_p',
        //'street_direction',
        //'apartment_number',
        //'apartment_description',
        //'unit_designation',
        //'zip_code',
        //'city',
        //'state',
        //'country',
        'address',
        //'full_address'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'umServiceAddressCode', 'umAddressCode');
    }

    public function getIdAttribute()
    {
        return trim($this->attributes['umAddressCode']);
    }
    public function getAddressCategoryAttribute()
    {
        return trim($this->attributes['umAddressCateg']);
    }
    public function getStreetNumberAttribute()
    {
        return trim($this->attributes['umStreetNumber']);
    }
    public function getStreetNameAttribute()
    {
        return trim($this->attributes['umStreetName']);
    }
    public function getStreetTypeAttribute()
    {
        return trim($this->attributes['umStreetType']);
    }
    public function getStreetDirectionPAttribute()
    {
        return trim($this->attributes['umStreetDirectionP']);
    }
    public function getStreetDirectionAttribute()
    {
        return trim($this->attributes['umStreetDirection']);
    }
    public function getApartmentNumberAttribute()
    {
        return trim($this->attributes['umAptNumber']);
    }
    public function getApartmentDescriptionAttribute()
    {
        return trim($this->attributes['umAptDescription']);
    }
    public function getUnitDesignationAttribute()
    {
        return trim($this->attributes['umUnitDesignation']);
    }
    public function getZipCodeAttribute()
    {
        return trim($this->attributes['umZipCode']);
    }
    public function getCityAttribute()
    {
        return trim($this->attributes['umCityName']);
    }
    public function getStateAttribute()
    {
        return trim($this->attributes['STATE']);
    }
    public function getCountryAttribute()
    {
        return trim($this->attributes['COUNTRY']);
    }
    public function getAddressAttribute()
    {
        return implode(' ',
            array_filter([
                trim($this->attributes['umStreetNumber']),
                trim($this->attributes['umStreetDirection']),
                trim($this->attributes['umStreetDirectionP']),
                trim($this->attributes['umStreetName']),
                trim($this->attributes['umStreetType']),
                trim($this->attributes['umAptNumber']),
                trim($this->attributes['umUnitDesignation']),
                trim($this->attributes['umAptDescription'])
            ])
        );
    }
    public function getFullAddressAttribute()
    {
        return implode(' ',
                array_filter([
                    trim($this->attributes['umStreetNumber']),
                    trim($this->attributes['umStreetDirection']),
                    trim($this->attributes['umStreetDirectionP']),
                    trim($this->attributes['umStreetName']),
                    trim($this->attributes['umStreetType']),
                    trim($this->attributes['umAptNumber']),
                    trim($this->attributes['umUnitDesignation']),
                    trim($this->attributes['umAptDescription']),
                    trim($this->attributes['umCityName']),
                    trim($this->attributes['STATE']),
                    trim($this->attributes['COUNTRY']),
                    trim($this->attributes['umZipCode'])
                ])
            );

    }



    public function scopeNoLock($query)
    {
        return $query->from(DB::raw(self::getTable() . ' with (nolock)'));
    }


}
