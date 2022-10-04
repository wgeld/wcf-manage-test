<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomerContact extends Model
{
    protected $connection = 'sqlcisprod';

    protected $table = 'UMRM0111';

    protected $primaryKey = 'CUSTNMBR';

    protected $casts  = [
        'CUSTNMBR' => 'string'
    ];

    protected $maps = [
        'CUSTNMBR'          => 'customer_id',
        'umAddressCode'     => 'address_id',
        'umContactPersone'  => 'contact_person',
        'PHONE1'            => 'phone_1',
        'PHONE2'            => 'phone_2',
        'PHONE3'            => 'phone_3',
        'umPhone1Type'      => 'phone_1_type',
        'umPhone2Type'      => 'phone_2_type',
        'umPhone3Type'      => 'phone_3_type'
    ];

    protected $appends = [
        'customer_id',
        //'address_id',
        //'contact_person',
        'phone_1',
        'phone_2',
        'phone_3',
        'phone_1_type',
        'phone_2_type',
        'phone_3_type'
    ];

    protected $visible  = [
        'customer_id',
        'address_id',
        'contact_person',
        'phone_1',
        'phone_2',
        'phone_3',
        'phone_1_type',
        'phone_2_type',
        'phone_3_type'
    ];

    protected $hidden  = [
        'CUSTNMBR',
        'umAddressCode',
        'ADRSCODE',
        'umContactPersone',
        'PHONE1',
        'PHONE2',
        'PHONE3',
        'FAX',
        'umEmail',
        'umBillToAddress',
        'umPrintContactPerson',
        'umPhone1Type',
        'umPhone2Type',
        'umPhone3Type',
        'DEX_ROW_ID'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CUSTNMBR');
    }

    public function phone1Type()
    {
        return $this->hasOne(CustomerPhoneType::class, 'umPhoneType','umPhone1Type');
    }

    public function phone2Type()
    {
        return $this->hasOne(CustomerPhoneType::class, 'umPhoneType','umPhone2Type');
    }

    public function phone3Type()
    {
        return $this->hasOne(CustomerPhoneType::class, 'umPhoneType','umPhone3Type');
    }

    public function getCustomerIdAttribute()
    {
        return trim($this->attributes['CUSTNMBR']);
    }

    public function getAddressIdAttribute()
    {
        return trim($this->attributes['umAddressCode']);
    }

    public function getContactPersonAttribute()
    {
        return trim($this->attributes['umContactPersone']);
    }

    public function getPhone1Attribute()
    {
        if(trim($this->attributes['PHONE1']) === '00000000000000' || empty(trim($this->attributes['PHONE1']))){
            return $this->attributes['PHONE1'] = '';
        }

        $cleaned = preg_replace('/[^[:digit:]]/', '', trim($this->attributes['PHONE1']));
        preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);
        return "({$matches[1]}) {$matches[2]}-{$matches[3]}";

        //return trim($this->attributes['PHONE1']);
    }

    public function getPhone2Attribute()
    {
        if(trim($this->attributes['PHONE2']) === '00000000000000' || empty(trim($this->attributes['PHONE2']))){
            return $this->attributes['PHONE2'] = '';
        }

        $cleaned = preg_replace('/[^[:digit:]]/', '', trim($this->attributes['PHONE2']));
        preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);
        return "({$matches[1]}) {$matches[2]}-{$matches[3]}";

        //return trim($this->attributes['PHONE2']);
    }

    public function getPhone3Attribute()
    {
        if(trim($this->attributes['PHONE3']) === '00000000000000' || empty(trim($this->attributes['PHONE3']))){
            return $this->attributes['PHONE3'] = '';
        }
        $cleaned = preg_replace('/[^[:digit:]]/', '', trim($this->attributes['PHONE3']));
        preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);
        return "({$matches[1]}) {$matches[2]}-{$matches[3]}";

        //return trim($this->attributes['PHONE3']);
    }

    public function getPhone1TypeAttribute()
    {
        $phone1Type = CustomerPhoneType::where('umPhoneType',trim($this->attributes['umPhone1Type']))->first();
        return trim($phone1Type->umPhoneDescription);
    }

    public function getPhone2TypeAttribute()
    {
        //$phone2Type = $this->phone2Type();
        //dd($phone2Type);

        //return trim($phone2Type['name']);
        $phone2Type = CustomerPhoneType::where('umPhoneType',trim($this->attributes['umPhone1Type']))->first();
        return trim($phone2Type->umPhoneDescription);
    }

    public function getPhone3TypeAttribute()
    {
        //$phone3Type = $this->phone3Type->toArray();
        //return trim($phone3Type['name']);

        $phone3Type = CustomerPhoneType::where('umPhoneType',trim($this->attributes['umPhone1Type']))->first();
        return trim($phone3Type->umPhoneDescription);
    }

    public function scopeNoLock($query)
    {
        return $query->from(DB::raw(self::getTable() . ' with (nolock)'));
    }


}
