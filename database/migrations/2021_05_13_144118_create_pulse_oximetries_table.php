<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePulseOximetriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pulse_oximetries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_device_id')->unsigned();
            $table->string('spo2');
            $table->string('bpm');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreign('user_device_id')
                ->references('id')
                ->on('user_devices')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('pulse_oximetries');
    }
}
