<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('schedule_groups')) return;       //add this line to your database file
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 100)->nullable();
            $table->string('nickname', 50)->nullable();
            $table->bigInteger('user_id')->default(0);
            $table->string('start', 150)->nullable();
            $table->string('end', 150)->nullable();
            $table->string('start_lat', 50)->nullable();
            $table->string('start_lng', 50)->nullable();
            $table->string('end_lat', 50)->nullable();
            $table->string('end_lng', 50)->nullable();
            $table->boolean('is_active')->default(1)->nullable();
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
        Schema::dropIfExists('schedule_groups');
    }
}
