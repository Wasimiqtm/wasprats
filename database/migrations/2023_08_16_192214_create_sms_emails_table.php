<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_emails', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('subject');
            $table->longText('description');
            $table->text('sms_text')->nullable();
            $table->enum('type',['default','custom','broadcast','email_template']);
            $table->text('message_type')->nullable();
            $table->string('reminder_days')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('sms_emails');
    }
}
