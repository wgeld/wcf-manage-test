<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OntInventory extends Model
{
    use HasFactory;

    protected $connection = 'sql_dev1901';
    protected $table = 'ONT_Inventory_Import_Stage';
    protected $guarded = [];
}
