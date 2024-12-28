<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProfileSkuadUnitiJaringanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__profile_skuad_uniti_jaringan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('skuad_uniti_id')->unsigned();
            $table->string('jaringan_agensi_nama');
            $table->string('jaringan_nama_pegawai');
            $table->string('jaringan_no_telefon');
            $table->string('jaringan_kerjasama');
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
        Schema::dropIfExists('krt__profile_skuad_uniti_jaringan');
    }
}
