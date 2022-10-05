<?php

namespace App\Imports;

use App\Models\AmsObjects;
use App\Models\LocationMaster;
use App\Models\Termination;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class  TerminationsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['location_id'])) {
            return null;
        }

        $location = LocationMaster::where('locationID',(string)$row['location_id'])->first();

        $amsObject = AmsObjects::where('locationId',(string)$row['location_id'])->first();

        return new Termination([
            'service_order_number' => $row['service_order_number'],
            'location_id' => $row['location_id'],
            'customer_id' => $row['customer_number'],
            'customer_name' => $row['customer_name'],
            'service_address' => $row['service_address'],
            'request_id' => $row['request_id'] ?? '',
            'requested_date' => now(),//$row['requested_date'], //requested date not working for xlsx for some reason?
            'status' => $row['status'] ?? '',
            'cycle_id' => $row['cycleid'],
            'is_suspended' => false,
            'has_phone_service' => isset($location->hasPhone) ? (boolean)$location->hasPhone : false,
            'ont_object_name' => (string)$amsObject->apcONTObjectName ?? ''
        ]);
    }
}
