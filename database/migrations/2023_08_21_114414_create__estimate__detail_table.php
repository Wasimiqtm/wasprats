<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('estimate_id');
            $table->string('items', 100)->nullable();
            $table->float('cost')->default(0)->nullable();
            $table->tinyInteger('quantity')->default(0)->nullable();
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
        Schema::dropIfExists('estimate_detail');
    }
}
