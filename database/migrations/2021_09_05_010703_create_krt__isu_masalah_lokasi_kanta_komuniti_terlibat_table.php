<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtIsuMasalahLokasiKantaKomunitiTerlibatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__isu_masalah_lokasi_kanta_komuniti_terlibat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('isu_lokasi_kk_id')->unsigned();
            $table->string('bilangan');
            $table->bigInteger('kaum_id')->unsigned();
            $table->bigInteger('jantina_id')->unsigned();
            $table->string('umur');
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
        Schema::dropIfExists('krt__isu_masalah_lokasi_kanta_komuniti_terlibat');
    }
}
