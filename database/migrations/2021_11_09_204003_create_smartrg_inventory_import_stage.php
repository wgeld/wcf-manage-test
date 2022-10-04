<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmartrgInventoryImportStage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smartrg_inventory_import_stage', function (Blueprint $table) {
            $table->id();
            $table->string('mac');
            $table->string('serial_number');
            $table->string('ssid');
            $table->string('ssid_24');
            $table->string('ssid_5g');
            $table->string('ssid_password');
            $table->dateTime('date_shipped');
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
        Schema::dropIfExists('smartrg_inventory_import_stage');
    }
}
