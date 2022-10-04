<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    protected $connection = 'sqlcisprod';

    protected $table = 'UMRM0101';

    protected $primaryKey = 'CUSTNMBR';

    protected $casts  = [
        'CUSTNMBR' => 'string'
    ];

    protected $maps = [
        'CUSTNMBR'          => 'id',
        'umCustClassID'     => 'customer_class',
        'umFirstName'       => 'first_name',
        'umMiddleName'      => 'middle_name',
        'umLastName'        => 'last_name',
        'umCWEmailAddress'  => 'email'
    ];

    protected $appends = [
        //'id',
        //'customer_class',
        'full_name',
        //'first_name',
        //'middle_name',
        //'last_name',
        'email'
    ];

    protected $visible  = [
        'id',
        'customer_class',
        'full_name',
        'first_name',
        'middle_name',
        'last_name',
        'email'
    ];

    protected $hidden  = [
        'CUSTNMBR',
        'umNameTitle',
        'umFirstName',
        'umMiddleName',
        'umLastName',
        'umDateOfBirth',
        'umPlaceOfWork',
        'umSIN',
        'umCustClassID',
        'umAlternateID',
        'umInternetPassword',
        'umDepositReq',
        'umPenaltyCharged',
        'umRCollectionProc',
        'umBudgetBE',
        'umPreauthPP',
        'CUSTDISC',
        'umDelinquencyCode',
        'umPaymentTermID',
        'umTaxSched',
        'umIndividual',
        'umCBCashOnly',
        'umCBBilledCustomer',
        'umUserID',
        'umDateCreated',
        'umDateModified',
        'NOTEINDX',
        'PRBTADCD',
        'PRSTADCD',
        'STADDRCD',
        'ADRSCODE',
        'umElectBill',
        'umCWEmailAddress',
        'umCWUserEnabled',
        'umOverrideAddress',
        'umFromDate',
        'umToDate',
        'REPTING',
        'umBusinessAs',
        'umThirdPartyResp',
        'FILEXPNM',
        'umWriteOffExempt',
        'umRestrictPymtMthd',
        'EXPNDATE',
        'AddInfo',
        'umNameSuffix',
        'umMaidenName',
        'umTaxExemptNumber',
        'umTaxExemptExpiryDate',
        'umCustomerLanguageID',
        'umDepositAdjExempt',
        'umState',
        'DEX_ROW_ID'
    ];

    public function customerContact()
    {
        return $this->hasOne(CustomerContact::class, 'CUSTNMBR','CUSTNMBR');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'umBillToCust','CUSTNMBR');
    }

    public function getIdAttribute()
    {
        return trim($this->attributes['CUSTNMBR']);
    }

    public function getCustomerClassAttribute()
    {
        return trim($this->attributes['umCustClassID']);
    }

    public function getFirstNameAttribute()
    {
        return trim($this->attributes['umFirstName']);
    }

    public function getMiddleNameAttribute()
    {
        return trim($this->attributes['umMiddleName']);
    }

    public function getLastNameAttribute()
    {
        return trim($this->attributes['umLastName']);
    }
    public function getEmailAttribute()
    {
        return trim($this->attributes['umCWEmailAddress']);
    }

    public function getFullNameAttribute() {
        //return trim($this->umFirstName) . ' ' .  (trim($this->umMiddleName) !== '' ?: trim($this->umLastName));
        return trim($this->umFirstName) . ' ' .  trim($this->umMiddleName) . ' ' . trim($this->umLastName);
    }

    public function scopeNoLock($query)
    {
        return $query->from(DB::raw(self::getTable() . ' with (nolock)'));
    }

}
