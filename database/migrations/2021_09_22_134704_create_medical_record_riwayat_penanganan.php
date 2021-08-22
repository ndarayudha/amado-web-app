<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalRecordRiwayatPenanganan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_record_riwayat_penanganan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('medical_record_id')->unsigned()->nullable();
            $table->bigInteger('riwayat_penanganan_id')->unsigned()->nullable();

            $table->foreign('medical_record_id')->references('id')->on('medical_records')->cascadeOnDelete();
            $table->foreign('riwayat_penanganan_id')->references('id')->on('riwayat_penanganans')->cascadeOnDelete();
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
        Schema::dropIfExists('medical_record_riwayat_penanganan');
    }
}
