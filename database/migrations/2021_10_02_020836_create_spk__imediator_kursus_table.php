<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkImediatorKursusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__imediator_kursus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_imediator_id')->unsigned();
            $table->string('kursus_nama');
            $table->bigInteger('mkp_kategori_kursus_id')->unsigned();
            $table->bigInteger('mkp_peringkat_kursus_id')->unsigned();
            $table->string('kursus_penganjur');
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
        Schema::dropIfExists('spk__imediator_kursus');
    }
}
