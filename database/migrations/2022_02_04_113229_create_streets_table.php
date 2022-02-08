<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streets', function (Blueprint $table) {
            $table->id();
            $table->string('street_name');
            $table->unsignedBigInteger('street_type_id');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('settlement_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('settlement_id')->references('id')->on('settlements');
            $table->foreign('street_type_id')->references('id')->on('street_types');
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('streets');
    }
}
