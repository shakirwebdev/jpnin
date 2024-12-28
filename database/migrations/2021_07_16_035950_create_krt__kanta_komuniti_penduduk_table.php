<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKantaKomunitiPendudukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__kanta_komuniti_penduduk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kanta_komuniti_id')->unsigned();
            $table->bigInteger('kaum_id')->unsigned();
            $table->string('bilangan_rumah');
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
        Schema::dropIfExists('krt__kanta_komuniti_penduduk');
    }
}
