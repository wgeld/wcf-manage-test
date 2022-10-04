<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;

class CustomerPhoneType extends Pivot
{
    protected $connection = 'sqlcisprod';

    protected $table = 'UMRM0108';

    protected $primaryKey = 'umPhoneType';

    protected $casts  = [
        'umPhoneType' => 'string'
    ];

    protected $maps = [
        'umPhoneType'           => 'id',
        'umPhoneDescription'    => 'name'

    ];

    protected $appends = [
        'name'
    ];

    protected $visible  = [
        'id',
        'name'
    ];

    protected $hidden  = [
        'umPhoneType',
        'umPhoneDescription',
        'NOTEINDX',
        'umCBUseInSearch',
        'DEX_ROW_ID',
    ];

    public function customerPhone1Type()
    {
        return $this->hasOne(CustomerPhoneType::class, 'umPhone1Type','umPhoneType');
    }

    public function customerPhone2Type()
    {
        return $this->hasOne(CustomerPhoneType::class, 'umPhone2Type','umPhoneType');
    }

    public function customerPhone3Type()
    {
        return $this->hasOne(CustomerPhoneType::class, 'umPhone3Type','umPhoneType');
    }

    public function getIdAttribute()
    {
        return trim($this->attributes['umPhoneType']);
    }

    public function getNameAttribute()
    {
        return trim($this->attributes['umPhoneDescription']);
    }

    public function scopeNoLock($query)
    {
        return $query->from(DB::raw(self::getTable() . ' with (nolock)'));
    }

}
