<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plant_country', function (Blueprint $table) {
            $table->id();
            $table->integer('plantId')->unsigned();
            $table->integer('countryId')->unsigned();
            $table->foreign('plantId')->references('id')->on('plants');
            $table->foreign('countryId')->references('id')->on('countries');
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
        Schema::dropIfExists('plant_country');
    }
};
