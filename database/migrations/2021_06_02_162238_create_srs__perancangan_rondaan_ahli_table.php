<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsPerancanganRondaanAhliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__perancangan_rondaan_ahli', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('srs_perancangan_rondaan_id')->unsigned();
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
        Schema::dropIfExists('srs__perancangan_rondaan_ahli');
    }
}
