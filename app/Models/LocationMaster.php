<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LocationMaster extends Model
{

    protected $connection = 'sqlsrv_dev';

    protected $table = 'ZAP_Location_Master';

}
