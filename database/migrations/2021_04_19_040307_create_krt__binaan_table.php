<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtBinaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__binaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->bigInteger('binaan_jenis_premis_id')->unsigned();
            $table->string('binaan_alamat');
            $table->char('binaan_tanah_ptp', 1)->nullable();
            $table->char('binaan_tanah_negeri', 1)->nullable();
            $table->string('binaan_kos');
            $table->string('binaan_keluasan_tanah');
            $table->string('binaan_keluasan_bagunan');
            $table->datetime('binaan_tarikh_mula_bina');
            $table->char('binaan_pengguna_rt', 1)->nullable();
            $table->char('binaan_pengguna_srs', 1)->nullable();
            $table->char('binaan_pengguna_tabika', 1)->nullable();
            $table->char('binaan_pengguna_taska', 1)->nullable();
            $table->string('binaan_isu');
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
        Schema::dropIfExists('krt__binaan');
    }
}
