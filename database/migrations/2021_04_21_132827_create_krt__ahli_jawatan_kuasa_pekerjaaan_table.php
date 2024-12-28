<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAhliJawatanKuasaPekerjaaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__ahli_jawatan_kuasa_pekerjaaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_ajkID')->unsigned();
            $table->bigInteger('ref_profession_id')->unsigned();
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
        Schema::dropIfExists('krt__ahli_jawatan_kuasa_pekerjaaan');
    }
}
