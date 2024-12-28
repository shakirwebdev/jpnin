<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAhliJawatanKuasaCawanganPengalamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__ahli_jawatan_kuasa_cawangan_pengalaman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_ajk_cawangan_id')->unsigned();
            $table->string('pengalaman_tahun');
            $table->string('pengalaman_program');
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
        Schema::dropIfExists('krt__ahli_jawatan_kuasa_cawangan_pengalaman');
    }
}
