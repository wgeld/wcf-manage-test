<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApcTemplates extends Model
{
    protected $connection = 'sql_dev1901';

    protected $table = 'APC_Templates';

    protected $guarded = [];


    public function getVaUsbwprofileOptionsAttribute()
    {
        return json_decode($this->attributes['VA_usBwProfile_Options']);
    }

    public function getVaDsschedulerprofileOptionsAttribute()
    {
        return json_decode($this->attributes['VA_dsSchedulerProfile_Options']);
    }

    public function getVaCustomeridOptionsAttribute()
    {
        return json_decode($this->attributes['VA_customerID_Options']);
    }
}
