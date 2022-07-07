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
        Schema::table('genuses', function (Blueprint $table) {
            $table->bigInteger('familyId')->unsigned();
            $table->foreign('familyId')
                ->references('id')
                ->on('families');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('genuses', function (Blueprint $table) {
            //
        });
    }
};
