<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GISFTTX extends Model
{
    protected $connection = 'sqlcisprod';

    protected $table = 'GIS_FTTX_Intake';

    protected $primaryKey = 'FTTXLocaID';

    protected $casts  = [
        'FTTXLocaID' => 'string'
    ];



    public function scopeNoLock($query)
    {
        return $query->from(DB::raw(self::getTable() . ' with (nolock)'));
    }

}
