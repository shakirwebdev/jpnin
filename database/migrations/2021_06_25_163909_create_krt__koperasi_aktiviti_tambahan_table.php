<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKoperasiAktivitiTambahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__koperasi_aktiviti_tambahan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_koperasi_id')->unsigned();
            $table->bigInteger('ref_fungsi_koperasi_id')->unsigned();
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
        Schema::dropIfExists('krt__koperasi_aktiviti_tambahan');
    }
}
