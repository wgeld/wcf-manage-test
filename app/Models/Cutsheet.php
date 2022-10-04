<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutsheet extends Model
{


    protected $connection = 'sqlsrv';

    protected $table = 'fiber_cutsheet_imports';

    //protected $primaryKey = 'id';

    protected $guarded = [];

}
