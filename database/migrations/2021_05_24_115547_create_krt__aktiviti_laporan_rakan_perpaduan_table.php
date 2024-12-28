<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAktivitiLaporanRakanPerpaduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__aktiviti_laporan_rakan_perpaduan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('aktiviti_laporan_id')->unsigned();
            $table->bigInteger('rakan_id')->unsigned();
            $table->bigInteger('sumbangan_id')->unsigned();
            $table->string('rakan_perpaduan_jumlah')->nullable();
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
        Schema::dropIfExists('krt__aktiviti_laporan_rakan_perpaduan');
    }
}
