<?php

namespace App\Imports;

use App\Models\SmartrgInventory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SmartrgInventoryImport implements ToModel, WithStartRow, WithUpserts, WithProgressBar
{
    use Importable;

    /**
    * @param array $row
    *
    * @return SmartrgInventory
     */
    public function model(array $row)
    {
        return new SmartrgInventory([
            'mac' => $row[0],
            'serial_number' => $row[1],
            'date_shipped' => $row[2],//Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]))->toDateString(),
            'ssid' => $row[3],
            'ssid_24' => $row[3],
            'ssid_5g' => $row[4],
            'ssid_password' => $row[5],
        ]);
    }

    public function uniqueBy()
    {
        return 'mac';
    }


    public function startRow(): int
    {
        return 2;
    }
}
