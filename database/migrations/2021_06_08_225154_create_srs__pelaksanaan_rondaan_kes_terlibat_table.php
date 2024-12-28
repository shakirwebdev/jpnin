<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsPelaksanaanRondaanKesTerlibatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__pelaksanaan_rondaan_kes_terlibat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('srs_pelaksanaan_rondaan_id')->unsigned();
            $table->bigInteger('kaum_id')->unsigned();
            $table->bigInteger('jantina_id')->unsigned();
            $table->string('terlibat_bilangan');
            $table->string('terlibat_umur');
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
        Schema::dropIfExists('srs__pelaksanaan_rondaan_kes_terlibat');
    }
}
