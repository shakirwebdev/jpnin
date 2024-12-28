<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtPembinaanPrt1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__pembinaan_prt1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->string('prt_jenis_premis');
            $table->string('prt_status_tanah_terkini');
            $table->string('prt_keluasan');
            $table->string('prt_status_kelulusan_tanah_kabin');
            $table->string('prt_cadangan_tahun');
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
        Schema::dropIfExists('krt__pembinaan_prt1');
    }
}
