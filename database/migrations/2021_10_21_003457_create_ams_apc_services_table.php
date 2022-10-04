<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmsApcServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ams_apc_services', function (Blueprint $table) {
            $table->id();
            $table->string('ne_name');
            $table->string('target_object_name');
            $table->string('template_name');
            $table->integer('template_version');
            $table->string('instance_label')->nullable();
            $table->string('apc_service_type')->nullable();
            $table->string('admin_state')->nullable();
            $table->string('config_BatteryPowerShedding_PowerShedProfile')->nullable();
            $table->string('ontSubscriberLocationId')->nullable();
            $table->string('identification_Version_DownloadedSoftware')->nullable();
            $table->string('ontSerialNumber')->nullable();
            $table->string('configFiles_Config1_Downloaded')->nullable();
            $table->integer('VA_cvlanId')->nullable();
            $table->integer('oper_NumberOfDataPorts')->nullable();
            $table->string('VA_usBwProfile')->nullable();
            $table->string('configFiles_Config1_Planned')->nullable();
            $table->integer('maxNumberOfMacAddresses')->nullable();
            $table->string('ontSoftwarePlannedVersion')->nullable();
            $table->string('VA_dsSchedulerProfile')->nullable();
            $table->string('VA_customerID')->nullable();
            $table->boolean('ontBatteryBackup')->nullable();
            $table->string('ontSubscriberId2')->nullable();
            $table->integer('VA_svlanId')->nullable();
            $table->string('ontSubscriberId1')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ams_apc_services');
    }
}
