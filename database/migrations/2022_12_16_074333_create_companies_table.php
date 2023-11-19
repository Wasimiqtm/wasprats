<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 150)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('license', 50)->nullable();
            
            $table->bigInteger('country_id')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip', 50)->nullable();
            $table->text('address')->nullable();

            $table->text('website', 100)->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();

            $table->bigInteger('industry_id')->nullable();
            $table->bigInteger('timezone_id')->nullable();
            $table->bigInteger('currency_id')->nullable();
            
            $table->string('date_format', 15)->nullable();
            $table->string('temperature', 30)->nullable();

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
        Schema::dropIfExists('companies');
    }
}
