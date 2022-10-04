<?php

namespace App\Imports;

use App\Models\OntInventory;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class OntInventoryImport implements ToModel, WithStartRow, WithUpserts, WithProgressBar
{
    use Importable;

    /**
    * @param array $row
    *
    * @return OntInventory
     */
    public function model(array $row)
    {
        $descriptionString = Str::of($row[2]);
        $modelString = (string)$descriptionString;
        if($descriptionString->contains('KIT-')){
            $modelString = (string)$descriptionString->after('KIT-')->trim();
        }
        if($descriptionString->contains('EMA-')){
            $modelString = (string)$descriptionString->after('EMA-')->trim();
        }

        return new OntInventory([
            'kit_serial_number' => $row[0],
            'serial_number' => $row[1],
            'description' => $row[2],
            'model' => $modelString,
            'part_number' => $row[3],
            'revision' => $row[4],
            'mac' => Str::of($row[5])->contains(':') ? (string)Str::of($row[5])->before(':')->trim() : $row[5],
            'mac_values' => $row[5],
            'order_number' => $row[6],
            'purchase_order_number' => $row[7],
            'ship_date' => $row[8],
            'po_number_end_customer' => $row[9],
            'delivery_name_end_customer' => $row[10],
            //'ssid' => $row[11],
            //'ssid_password' => $row[12],
            //'first_mac' => $row[13],
            //'second_mac' => $row[14]
        ]);
    }

    public function uniqueBy()
    {
        return 'serial_number';
    }


    public function startRow(): int
    {
        return 2;
    }
}
