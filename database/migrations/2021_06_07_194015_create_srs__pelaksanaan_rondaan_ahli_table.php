<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsPelaksanaanRondaanAhliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__pelaksanaan_rondaan_ahli', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('srs_pelaksanaan_rondaan_id')->unsigned();
            $table->bigInteger('srs_ahli_peronda_id')->unsigned();
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
        Schema::dropIfExists('srs__pelaksanaan_rondaan_ahli');
    }
}
