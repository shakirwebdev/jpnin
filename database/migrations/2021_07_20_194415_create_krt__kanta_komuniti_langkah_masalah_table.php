<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKantaKomunitiLangkahMasalahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__kanta_komuniti_langkah_masalah', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kanta_komuniti_id')->unsigned();
            $table->bigInteger('masalah_id')->unsigned();
            $table->string('langkah_diambil');
            $table->string('langkah_pelaksanaan');
            $table->string('langkah_status');
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
        Schema::dropIfExists('krt__kanta_komuniti_langkah_masalah');
    }
}
