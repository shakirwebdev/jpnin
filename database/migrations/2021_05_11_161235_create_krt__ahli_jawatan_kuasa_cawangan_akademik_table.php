<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAhliJawatanKuasaCawanganAkademikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__ahli_jawatan_kuasa_cawangan_akademik', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_ajk_cawangan_id')->unsigned();
            $table->bigInteger('pendidikan_id')->unsigned();
            $table->string('akademik_tahun');
            $table->string('akademik_pencapaian');
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
        Schema::dropIfExists('krt__ahli_jawatan_kuasa_cawangan_akademik');
    }
}
