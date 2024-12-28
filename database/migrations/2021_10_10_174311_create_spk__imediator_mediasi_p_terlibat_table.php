<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkImediatorMediasiPTerlibatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__imediator_mediasi_p_terlibat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_imediator_mediasi_id')->unsigned();
            $table->string('pihak_pertama');
            $table->string('pihak_kedua');
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
        Schema::dropIfExists('spk__imediator_mediasi_p_terlibat');
    }
}
