<?php

namespace App\Imports;

use App\Models\AmsApcService;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithUpserts;

class AmsApcServicesImport implements ToModel, WithHeadingRow, WithUpserts, WithProgressBar, WithBatchInserts, WithChunkReading
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new AmsApcService([
            'ne_name'                                       => $row['ne_name'],
            'target_object_name'                            => $row['target_object_name'],
            'template_name'                                 => $row['template_name'],
            'template_version'                              => $row['template_version'],
            'instance_label'                                => $row['instance_label'],
            'apc_service_type'                              => $row['apc_service_type'],
            'admin_state'                                   => $row['admin_state'],
            'config_BatteryPowerShedding_PowerShedProfile'  => $row['config_batterypowershedding_powershedprofile'],
            'ontSubscriberLocationId'                       => $row['ontsubscriberlocationid'],
            'identification_Version_DownloadedSoftware'     => $row['identification_version_downloadedsoftware'],
            'ontSerialNumber'                               => $row['ontserialnumber'],
            'configFiles_Config1_Downloaded'                => $row['configfiles_config1_downloaded'],
            'VA_cvlanId'                                    => $row['va_cvlanid'],
            'oper_NumberOfDataPorts'                        => $row['oper_numberofdataports'],
            'VA_usBwProfile'                                => $row['va_usbwprofile'],
            'configFiles_Config1_Planned'                   => $row['configfiles_config1_planned'],
            'maxNumberOfMacAddresses'                       => $row['maxnumberofmacaddresses'],
            'ontSoftwarePlannedVersion'                     => $row['ontsoftwareplannedversion'],
            'VA_dsSchedulerProfile'                         => $row['va_dsschedulerprofile'],
            'VA_customerID'                                 => $row['va_customerid'],
            'ontBatteryBackup'                              => $row['ontbatterybackup'],
            'ontSubscriberId2'                              => $row['ontsubscriberid2'],
            'VA_svlanId'                                    => $row['va_svlanid'],
            'ontSubscriberId1'                              => $row['ontsubscriberid1']
        ]);
    }

    public function uniqueBy()
    {
        return ['ne_name','target_object_name','ontSerialNumber'];
    }

    public function batchSize(): int
    {
        return 200;
    }

    public function chunkSize(): int
    {
        return 200;
    }
}
