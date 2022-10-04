<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SdcParameters extends Model
{
    //protected $table = 'ams_alarms';

    protected $connection = 'sql_dev1901';

    public $timestamps = false;

    protected $guarded = [];


    public function getValidValuesAttribute()
    {
        return json_decode($this->attributes['valid_values']);
    }

}
