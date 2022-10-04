<?php

namespace App\Models;

use App\Models\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class EquipmentHistory extends Model

{
    use HasCompositePrimaryKey;

    protected $connection = 'sqlcisprod';
    //protected $connection = 'sql_dev1901';

    protected $table = 'UM00400H';

    protected $primaryKey = ['umEquipmentID', 'umVersionNumber'];
    //TODO
    protected $casts  = [
        'umLocationID' => 'string'
    ];

    protected $maps = [
        'umEquipmentID' =>            'id',
        'umVersionNumber' =>          'version_number',
        'UMEQUCLSS' =>                'equipment_class',
        'umServiceCategory' =>        'service_category',
        'UMEQUMULT' =>                'equipment_multiplier',
        'umConsecutiveEstimates' =>   'consecutive_estimates',
        'UMINSTALLSTAT' =>            'install_status',
        'umInstallationDate' =>       'install_date',
        'umEquipLot' =>               'equipment_lot',
        'umSerialNumber' =>           'serial_number',
        'umAcquisitionDate' =>        'acquisition_date',
        'umAcquistionCost' =>         'acquisition_cost',
        'umRemovalDate' =>            'removal_date',
        'umSealedDate' =>             'sealed_date',
        'umTestDueDate' =>            'test_due_date',
        'umDateCreated' =>            'date_created',
        'umDateModified' =>           'date_modified',
        'umKh' =>                     'kh',
        'umElem' =>                   'elem',
        'umAccuracyClass' =>          'accuracy_class',
        'umPrimaryThru' =>            'primary_through',
        'umSecondaryAmps' =>          'secondary_amps',
        'umSecondaryVolts' =>         'secondary_volts',
        'umEquipStatusID' =>          'equipment_status_id',
        'umEquipInstallableStatus' => 'equipment_installable_status',
        'NOTEINDX' =>                 'note_index',
        'umEquipType' =>              'equipment_type',
        'ummanufacturer' =>           'manufacturer',
        'umAcceptConsumptions' =>     'accept_consumptions',
        'umDiameterd' =>              'diameter_d',
        'umNumWires' =>               'number_of_wires',
        'umPhase' =>                  'phase',
        'umVoltage' =>                'voltage',
        'umAmps' =>                   'amps',
        'umStatisticalNum' =>         'statistical_number',
        'UMTOTCONSUMP' =>             'total_consumption',
        'UMTOTKW' =>                  'total_kw',
        'UMTOTKVA' =>                 'total_kva',
        'umRegisterCodeID' =>         'register_code_id',
        'umRegisterType' =>           'register_type',
        'umPhysicalLocation' =>       'physical_location',
        'umLocator' =>                'locator',
        'umGISIdentifier' =>          'gis_identifier',
        'umModel' =>                  'model',
        'umProtection' =>             'protection',
        'umEqDescription' =>          'equipment_description',
        'umExcludeFromEMRExport' =>   'exclude_from_emr_export',
        'umDeviceSize' =>             'device_size',
        'umEquipmentStatusClass' =>   'equipment_status_class',
        'umSelfReadandTrip' =>        'self_read_and_trip',
        'umSelfReadDay' =>            'self_read_day',
        'umCumulativeDemand' =>       'cumulative_demand',
        'UMTOTPF' =>                  'total_pf',
        'UMTOTLF' =>                  'total_lf',
        'umAutoDisconnect' =>         'auto_disconnect',
        'umSmartMeter' =>             'smart_meter',
        'umMeterModelCode' =>         'meter_model_code',
        'umProgramId' =>              'program_id',
        'umNetMeterType' =>           'net_meter_type',
        'umTotalReceived' =>          'total_received',
        'umRecorderID' =>             'recorder_id',
        'umDevicePassword' =>         'device_password',
        'umReadLoadProfile' =>        'read_load_profile',
        'umDaylightSavingTime' =>     'daylight_saving_time',
        'umResetDemandIndicator' =>   'reset_demand_indicator',
        'umCustWebSelfRead' =>        'customer_web_self_read',
        'umElecKvaType' =>            'electric_kva_type',
        'umRemoteType' =>             'remote_type',
        //'DEX_ROW_ID' =>               '',
    ];

    protected $hidden = [
        'umEquipmentID',
        'umVersionNumber',
        'UMEQUCLSS',
        'umServiceCategory',
        'UMEQUMULT',
        'umConsecutiveEstimates',
        'UMINSTALLSTAT',
        'umInstallationDate',
        'umEquipLot',
        'umSerialNumber',
        'umAcquisitionDate',
        'umAcquistionCost',
        'umRemovalDate',
        'umSealedDate',
        'umTestDueDate',
        'umDateCreated',
        'umDateModified',
        'umKh',
        'umElem',
        'umAccuracyClass',
        'umPrimaryThru',
        'umSecondaryAmps',
        'umSecondaryVolts',
        'umEquipStatusID',
        'umEquipInstallableStatus',
        'NOTEINDX',
        'umEquipType',
        'ummanufacturer',
        'umAcceptConsumptions',
        'umDiameterd',
        'umNumWires',
        'umPhase',
        'umVoltage',
        'umAmps',
        'umStatisticalNum',
        'UMTOTCONSUMP',
        'UMTOTKW',
        'UMTOTKVA',
        'umRegisterCodeID',
        'umRegisterType',
        'umPhysicalLocation',
        'umLocator',
        'umGISIdentifier',
        'umModel',
        'umProtection',
        'umEqDescription',
        'umExcludeFromEMRExport',
        'umDeviceSize',
        'umEquipmentStatusClass',
        'umSelfReadandTrip',
        'umSelfReadDay',
        'umCumulativeDemand',
        'UMTOTPF',
        'UMTOTLF',
        'umAutoDisconnect',
        'umSmartMeter',
        'umMeterModelCode',
        'umProgramId',
        'umNetMeterType',
        'umTotalReceived',
        'umRecorderID',
        'umDevicePassword',
        'umReadLoadProfile',
        'umDaylightSavingTime',
        'umResetDemandIndicator',
        'umCustWebSelfRead',
        'umElecKvaType',
        'umRemoteType',
        'DEX_ROW_ID'
    ];
    //TODO
    protected $appends = [
        'id',
        'customer_id',
        'account_number',
        //'location_class',
        'zone_id',
        //'address_id'
    ];

    //TODO
    public function location()
    {
        return $this->belongsTo(Location::class, 'umLocationID','locationID');
    }

    public function getEquipmentStatusIdAttribute()
    {
        return match (trim($this->attributes['umEquipStatusID'])) {
            '1' => $this->attributes['umEquipStatusID'] = 'Installed/Installable',
            '2' => $this->attributes['umEquipStatusID'] = 'Condemned',
            '3' => $this->attributes['umEquipStatusID'] = 'Missing',
            '4' => $this->attributes['umEquipStatusID'] = 'Function Change',
            default => trim($this->attributes['umEquipStatusID']),
        };

    }

    public function scopeEQUClass($query, $equClass)
    {
        return $query->where('equClass', $equClass);
    }

    public function scopeFDH($query)
    {
        return $query->where('equClass','F-FDH');
    }

    public function scopeOLT($query)
    {
        return $query->where('equClass','F-OLT');
    }

    public function scopeONT($query)
    {
        return $query->where('equClass','F-ONT');
    }

    public function scopeRouter($query)
    {
        return $query->where('equClass','F-ROUTER');
    }

    public function scopeTelo($query)
    {
        return $query->where('equClass','F-TELO');
    }


}
