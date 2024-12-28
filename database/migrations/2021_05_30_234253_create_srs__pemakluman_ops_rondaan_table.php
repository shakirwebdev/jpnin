<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsPemaklumanOpsRondaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__pemakluman_ops_rondaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->bigInteger('srs_profile_id')->unsigned()->nullable();
            $table->date('ops_tarikh_mula_ronda')->nullable();
            $table->date('ops_tarikh_surat')->nullable();
            $table->bigInteger('direkod_by')->nullable()->unsigned();
            $table->dateTime('direkod_date')->nullable();
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
        Schema::dropIfExists('srs__pemakluman_ops_rondaan');
    }
}
