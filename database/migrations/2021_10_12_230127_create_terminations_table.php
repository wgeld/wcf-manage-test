<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminations', function (Blueprint $table) {
            $table->id();
            $table->string('service_order_number');
            $table->string('location_id');
            $table->string('customer_id');
            $table->string('customer_name')->nullable();
            $table->string('service_address')->nullable();
            $table->string('request_id')->nullable();
            $table->date('requested_date')->nullable();
            $table->string('status')->nullable();
            $table->string('cycle_id')->nullable();
            $table->boolean('is_suspended')->nullable();
            $table->boolean('has_phone_service')->nullable();
            $table->string('ont_object_name')->nullable();
            $table->string('suspend_state')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
