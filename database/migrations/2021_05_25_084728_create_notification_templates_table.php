<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('device_id')->unsigned()->default(1);
            $table->bigInteger('notification_topic_id')->unsigned();
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->timestamps();

            // relation
            $table->foreign('device_id')->references('id')->on('devices')->cascadeOnDelete();
            $table->foreign('notification_topic_id')->references('id')->on('notification_topics')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_templates');
    }
}
