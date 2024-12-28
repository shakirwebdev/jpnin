<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefStatusIsuLokasiKantaKomunitiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref__status_isu_lokasi_kanta_komuniti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status_description');
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
        Schema::dropIfExists('ref__status_isu_lokasi_kanta_komuniti');
    }
}
