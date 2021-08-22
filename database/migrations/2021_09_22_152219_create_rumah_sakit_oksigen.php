<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRumahSakitOksigen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oksigen_rumah_sakit', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rumah_sakit_id')->unsigned()->nullable();
            $table->bigInteger('oksigen_id')->unsigned()->nullable();

            $table->foreign('rumah_sakit_id')->references('id')->on('rumah_sakits')->cascadeOnDelete();
            $table->foreign('oksigen_id')->references('id')->on('oksigens')->cascadeOnDelete();
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
        Schema::dropIfExists('oksigen_rumah_sakit');
    }
}
