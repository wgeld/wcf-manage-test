<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartrgInventory extends Model
{
    use HasFactory;

    protected $connection = 'sql_dev1901';
    protected $table = 'Smartrg_Inventory_Import_Stage';
    protected $guarded = [];
}
