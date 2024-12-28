<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKantaKomunitiMasalahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__kanta_komuniti_masalah', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kanta_komuniti_id')->unsigned();
            $table->string('masalah_tajuk');
            $table->string('masalah_perincian');
            $table->string('masalah_penjelasan');
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
        Schema::dropIfExists('krt__kanta_komuniti_masalah');
    }
}
