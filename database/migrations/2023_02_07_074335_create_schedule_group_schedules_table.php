<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleGroupSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('schedule_group_schedules')) return;       //add this line to your database file
        Schema::create('schedule_group_schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('schedule_group_id')->default(0);
            $table->bigInteger('schedule_id')->default(0);
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
        Schema::dropIfExists('schedule_group_schedules');
    }
}
