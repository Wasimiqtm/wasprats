<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('services')) return;       //add this line to your database file
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 100)->nullable();
            $table->tinyInteger('hours')->nullable();
            $table->tinyInteger('minutes')->nullable();
            $table->enum('repeat', ['Not', 'Daily', 'Weekly', 'Monthly', 'Yearly'])->default('Not')->nullable();
            $table->tinyInteger('repeat_every')->nullable();
            $table->boolean('repeat_on_1')->default(0)->nullable();
            $table->boolean('repeat_on_2')->default(0)->nullable();
            $table->boolean('repeat_on_3')->default(0)->nullable();
            $table->boolean('repeat_on_4')->default(0)->nullable();
            $table->boolean('repeat_on_5')->default(0)->nullable();
            $table->boolean('repeat_on_6')->default(0)->nullable();
            $table->boolean('repeat_on_7')->default(0)->nullable();
            $table->enum('repeat_by', ['day_of_week', 'day_of_month', 'day_of_year'])->nullable();
            $table->enum('ends', ['Never', 'After'])->default('Never')->nullable();
            $table->smallInteger('ends_after_jobs')->nullable();
            $table->date('ends_on')->nullable();
            $table->tinyInteger('except_1')->nullable();
            $table->tinyInteger('except_2')->nullable();
            $table->tinyInteger('except_3')->nullable();
            $table->enum('job_status', ['Unconfirmed', 'Confirmed'])->default('Unconfirmed')->nullable();
            $table->string('color_code', 20)->nullable();

            $table->float('invoice_sub_total')->default(0)->nullable();
            $table->float('invoice_tax')->default(0)->nullable();
            $table->enum('invoice_discount_type', ['$', '%'])->nullable();
            $table->float('invoice_discount')->default(0)->nullable();
            $table->float('invoice_total_discount')->default(0)->nullable();
            $table->float('invoice_total')->default(0)->nullable();
            $table->string('invoice_terms', 150)->nullable();
            $table->string('invoice_note', 150)->nullable();

            $table->float('estimate_sub_total')->default(0)->nullable();
            $table->float('estimate_tax')->default(0)->nullable();
            $table->enum('estimate_discount_type', ['$', '%'])->nullable();
            $table->float('estimate_discount')->default(0)->nullable();
            $table->float('estimate_total_discount')->default(0)->nullable();
            $table->float('estimate_total')->default(0)->nullable();
            $table->string('estimate_terms', 150)->nullable();
            $table->string('estimate_note', 150)->nullable();

            $table->boolean('is_active')->default(1)->nullable();
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
        Schema::dropIfExists('services');
    }
}
