<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloseContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('close_contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned();
            $table->text('address')->nullable();
            $table->string('name')->nullable();
            $table->string('relationship')->nullable();
            $table->string('duration')->nullable();
            $table->string('time')->nullable();
            $table->date('date')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            // Relationship
            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();

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
        Schema::dropIfExists('close_contacts');
    }
}
