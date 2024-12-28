<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProjekEkonomiStPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__projek_ekonomi_st_peserta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('projek_ekonomi_st_id')->unsigned();
            $table->string('nama_peserta');
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
        Schema::dropIfExists('krt__projek_ekonomi_st_peserta');
    }
}
