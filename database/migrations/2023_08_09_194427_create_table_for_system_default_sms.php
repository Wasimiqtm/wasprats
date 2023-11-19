<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForSystemDefaultSms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('system_sms')) return;       //add this line to your database file
        Schema::create('system_sms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('subject')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('table_for_system_default_sms');
    }
}
